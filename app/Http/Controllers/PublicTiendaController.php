<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Estanteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicTiendaController extends Controller
{
    public function index()
    {
        // Cargamos las estanterías con sus productos para evitar el error de count
        $estanterias = Estanteria::with('productos')->get()->map(function ($e) {
            // Inicializamos el color por defecto (blanco para usuarios normales)[cite: 7]
            $e->color_gestion = '#ffffff';

            // Lógica de colores solo para el administrador
            if (Auth::check() && Auth::user()->isAdmin()) {
                if ($e->esta_vacia) {
                    $e->color_gestion = '#9ca3af'; // Gris si está vacía[cite: 7]
                } elseif ($e->tiene_caducados) {
                    $e->color_gestion = '#ef4444'; // Rojo si hay caducados[cite: 7]
                } elseif ($e->tiene_caducidad_proxima) {
                    $e->color_gestion = '#f59e0b'; // Naranja si es próxima[cite: 7]
                } else {
                    $e->color_gestion = '#22c55e'; // Verde si todo está bien
                }
            }
            return $e;
        });

        return view('welcome', compact('estanterias'));
    }

    public function filtrarPorEstanteria($id)
    {
        $estanteria = Estanteria::findOrFail($id);
        $esAdmin = Auth::check() && Auth::user()->isAdmin();
        $hoy = now()->startOfDay();
        
        // Enriquecemos los productos con información de descuento
        // ADMIN: Ve TODOS los productos
        // CLIENTE: Ve solo NO caducados Y con stock
        $productosConPrecio = $estanteria->productos
            ->filter(function ($producto) use ($esAdmin, $hoy) {
                // Filtrar por stock: todos deben tener stock > 0
                if ($producto->stock_actual <= 0) {
                    return false;
                }
                
                // Si es admin, mostrar todos los que tienen stock
                if ($esAdmin) {
                    return true;
                }
                
                // Si es cliente, excluir solo productos YA CADUCADOS
                if (!$producto->fecha_caducidad) {
                    return true; // Sin fecha, mostrar siempre
                }
                
                // Comparar fechas directamente: si fecha_caducidad < hoy, está caducado
                $fechaProducto = $producto->fecha_caducidad->startOfDay();
                return $fechaProducto >= $hoy; // Solo si caduca hoy o después
            })
            ->map(function ($producto) {
                return [
	                        'id' => $producto->id,
			    'nombre' => $producto->nombre,
			    'codigo_barras' => $producto->codigo_barras,
			    'stock_actual' => $producto->stock_actual,
			    'fecha_caducidad' => $producto->fecha_caducidad ? $producto->fecha_caducidad->format('Y-m-d') : null,
			    'precio' => (float) $producto->precio,
			    'precio_final' => (float) $producto->getPrecioConDescuento(),
			    'tiene_descuento' => $producto->estaProximoACaducar(),
			    'porcentaje_descuento' => $producto->estaProximoACaducar() ? 30 : 0,
			    'estanteria_id' => $producto->estanteria_id,
			    'imagen' => $producto->imagen,
                ];
            })
            ->values()
            ->all();
        
        return response()->json($productosConPrecio);
    }	

    public function checkout()
    {
        return view('checkout');
    }

    public function verPedido($id)
    {
        $pedidoModel = \App\Models\Pedido::where('codigo', $id)->with('items')->firstOrFail();
        $pedido = $pedidoModel->toArray();
        $pedido['detalles'] = array_map(function ($it) {
            return [
                'producto_id' => $it['producto_id'],
                'nombre' => $it['nombre'],
		'imagen' => $it['imagen'] ?? null,
                'cantidad' => $it['cantidad'],
                'precio_unitario' => (float) $it['precio_unitario'],
                'subtotal' => (float) $it['subtotal'],
                'descuento_aplicado' => (bool) $it['descuento_aplicado'],
            ];
        }, $pedido['items'] ?? []);

        return view('pedido', compact('pedido'));
    }

    /**
     * Procesar compra: Recibe carrito, valida stock, actualiza BD, devuelve resumen
     */
    public function procesarCompra(Request $request)
    {
        $carrito = $request->input('carrito', []);
        $metodoPago = $request->input('metodo_pago', 'tarjeta');
        $correoTicket = trim((string) $request->input('correo_ticket', ''));
	$metodosValidos = ['tarjeta', 'paypal', 'bizum'];

	if (empty($carrito)) {
	    return response()->json(['error' => 'Carrito vacío'], 400);
	}

	if (!in_array($metodoPago, $metodosValidos, true)) {
	    return response()->json(['error' => 'Método de pago no válido'], 422);
	}

	// NUEVO: Solo validamos si NO está vacío. Si está vacío, se salta la validación.
	if (!empty($correoTicket)) {
	    if (!filter_var($correoTicket, FILTER_VALIDATE_EMAIL)) {
	        return response()->json(['error' => 'Introduce un correo válido para enviar el ticket'], 422);
	    }
	} else {
	    // Si viene vacío, lo transformamos en null para que guarde un valor limpio en la base de datos
	    $correoTicket = null;
	}

        $estadoInicial = match ($metodoPago) {
            'tarjeta' => 'Pendiente Stripe',
            'paypal' => 'Pendiente PayPal',
            default => 'Pendiente Bizum',
        };
        [$pedidoModel, $detalles, $total] = $this->crearPedidoPendiente($carrito, $correoTicket, $metodoPago, $estadoInicial);

        if ($metodoPago === 'tarjeta') {
            try {
                $stripeSession = $this->crearSesionStripeCheckout($pedidoModel, $total, $correoTicket);
                $checkoutUrl = $stripeSession['url'] ?? null;

                if (! $checkoutUrl) {
                    throw new \RuntimeException('No se pudo obtener la URL de pago de Stripe.');
                }

                $pedido = $pedidoModel->toArray();
                $pedido['detalles'] = $detalles;
                $pedido['correo_ticket'] = $correoTicket;
                session(['ultima_compra' => $pedido]);

                return response()->json([
                    'success' => true,
                    'provider' => 'stripe',
                    'checkout_url' => $checkoutUrl,
                    'pedido_codigo' => $pedidoModel->codigo,
                    'mensaje' => 'Redirigiendo a Stripe',
                ]);
            } catch (\Throwable $e) {
                $this->revertirPedidoPendiente($pedidoModel);

                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        if ($metodoPago === 'paypal') {
            try {
                $paypalOrder = $this->crearOrdenPayPal($pedidoModel, $total, $correoTicket);
                $approvalUrl = $paypalOrder['approval_url'] ?? null;

                if (!$approvalUrl) {
                    throw new \RuntimeException('No se pudo obtener la URL de aprobación de PayPal.');
                }

                $pedido = $pedidoModel->toArray();
                $pedido['detalles'] = $detalles;
                $pedido['correo_ticket'] = $correoTicket;
                session(['ultima_compra' => $pedido]);

                return response()->json([
                    'success' => true,
                    'provider' => 'paypal',
                    'approval_url' => $approvalUrl,
                    'pedido_codigo' => $pedidoModel->codigo,
                    'mensaje' => 'Redirigiendo a PayPal',
                ]);
            } catch (\Throwable $e) {
                $this->revertirPedidoPendiente($pedidoModel);

                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $pedido = $pedidoModel->toArray();
        $pedido['detalles'] = $detalles;
        $pedido['correo_ticket'] = $correoTicket;
        session(['ultima_compra' => $pedido]);

        return response()->json([
            'success' => true,
            'provider' => 'bizum',
            'pedido_codigo' => $pedidoModel->codigo,
            'pedido_url' => route('pedido.ver', ['id' => $pedidoModel->codigo]),
            'pedido_pdf_url' => route('pedido.pdf', ['id' => $pedidoModel->codigo]),
            'mensaje' => 'Pedido creado. Completa el pago por Bizum usando la referencia indicada.',
        ]);
    }

    private function crearPedidoPendiente(array $carrito, ?string $correoTicket, string $metodoPago, string $estado): array
    {
        $total = 0;
        $detalles = [];

        DB::beginTransaction();

        try {
            foreach ($carrito as $item) {
                $producto = Producto::findOrFail($item['producto_id']);

                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \RuntimeException("Stock insuficiente para {$producto->nombre}. Disponibles: {$producto->stock_actual}");
                }

                $precioUnitario = (float) $producto->getPrecioConDescuento();
                $subtotal = $precioUnitario * $item['cantidad'];
                $total += $subtotal;

                $producto->update([
                    'stock_actual' => $producto->stock_actual - $item['cantidad'],
                ]);

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'cantidad' => (int) $item['cantidad'],
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                    'descuento_aplicado' => $producto->estaProximoACaducar(),
                ];
            }

            $codigoPedido = 'PED-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));

            $pedidoModel = \App\Models\Pedido::create([
                'codigo' => $codigoPedido,
                'fecha' => now(),
                'metodo_pago' => $metodoPago,
                'correo' => $correoTicket,
                'total' => round($total, 2),
                'estado' => $estado,
            ]);

            foreach ($detalles as $it) {
                \App\Models\PedidoItem::create([
                    'pedido_id' => $pedidoModel->id,
                    'producto_id' => $it['producto_id'],
                    'nombre' => $it['nombre'],
                    'cantidad' => $it['cantidad'],
                    'precio_unitario' => $it['precio_unitario'],
                    'subtotal' => $it['subtotal'],
                    'descuento_aplicado' => $it['descuento_aplicado'] ?? false,
                ]);
            }

            DB::commit();

            return [$pedidoModel->fresh('items'), $detalles, round($total, 2)];
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            throw $e;
        }
    }

    private function revertirPedidoPendiente(\App\Models\Pedido $pedidoModel): void
    {
        DB::beginTransaction();

        try {
            $pedidoModel->load('items');

            foreach ($pedidoModel->items as $item) {
                $producto = Producto::findOrFail($item->producto_id);
                $producto->update([
                    'stock_actual' => $producto->stock_actual + $item->cantidad,
                ]);
            }

            $pedidoModel->items()->delete();
            $pedidoModel->delete();

            DB::commit();
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            throw $e;
        }
    }

	    // 1. Añadimos el signo de interrogación (?) antes de string
	private function crearSesionStripeCheckout(\App\Models\Pedido $pedidoModel, float $total, ?string $correoTicket): array
	{
	    $secret = config('services.stripe.secret');
	    $currency = config('services.stripe.currency', 'eur');

	    if (! $secret) {
	        throw new \RuntimeException('Falta configurar STRIPE_SECRET en el entorno.');
	    }

	    // 2. Preparamos los datos para Stripe
	    $stripeData = [
	        'mode' => 'payment',
	        'client_reference_id' => $pedidoModel->codigo,
	        'line_items' => [
	            [
	                'price_data' => [
	                    'currency' => $currency,
	                    'product_data' => [
	                        'name' => 'Pedido ' . $pedidoModel->codigo,
	                    ],
	                    'unit_amount' => (int) round($total * 100),
	                ],
	                'quantity' => 1,
	            ],
	        ],
	        'metadata' => [
	            'pedido_codigo' => $pedidoModel->codigo,
	        ],
	        'success_url' => route('checkout.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
	        'cancel_url' => route('checkout.stripe.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
	    ];

	    // 3. NUEVO: Si el usuario SÍ puso correo, se lo añadimos. Si es null, Stripe no lo recibirá y pedirá el correo en su propia pasarela de pago.
	    if (!empty($correoTicket)) {
	        $stripeData['customer_email'] = $correoTicket;
	    }

	    $response = Http::asForm()
	        ->withBasicAuth($secret, '')
	        ->post('https://api.stripe.com/v1/checkout/sessions', $stripeData); // Pasamos la variable $stripeData limpia

	    if (! $response->successful()) {
	        $mensaje = $response->json('error.message') ?? $response->json('message') ?? 'No se pudo crear la sesión de pago de Stripe.';
	        throw new \RuntimeException($mensaje);
	    }

	    return $response->json();
	}

    private function crearOrdenPayPal(\App\Models\Pedido $pedidoModel, float $total, ?string $correoTicket): array
    {
        $accessToken = $this->obtenerAccessTokenPayPal();
        $baseUrl = config('services.paypal.base_url', 'https://api-m.sandbox.paypal.com');
        $currency = config('services.paypal.currency', 'EUR');

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->asJson()
            ->post($baseUrl . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => $pedidoModel->codigo,
                    'custom_id' => $pedidoModel->codigo,
                    'description' => 'Pedido ' . $pedidoModel->codigo,
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => number_format($total, 2, '.', ''),
                    ],
                ]],
                'application_context' => [
                    'brand_name' => config('app.name', 'UBIKA'),
                    'locale' => 'es-ES',
                    'return_url' => route('checkout.paypal.success'),
                    'cancel_url' => route('checkout.paypal.cancel'),
                ],
            ]);

        if (!$response->successful()) {
            $mensaje = $response->json('message') ?? $response->json('error') ?? 'No se pudo crear la orden de PayPal.';
            throw new \RuntimeException($mensaje);
        }

        $links = collect($response->json('links', []));
        $approvalUrl = $links->firstWhere('rel', 'approve')['href'] ?? null;

        return [
            'order_id' => $response->json('id'),
            'approval_url' => $approvalUrl,
        ];
    }

    private function obtenerAccessTokenPayPal(): string
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.client_secret');
        $baseUrl = config('services.paypal.base_url', 'https://api-m.sandbox.paypal.com');

        if (! $clientId || ! $clientSecret) {
            throw new \RuntimeException('Faltan credenciales de PayPal en el entorno.');
        }

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post($baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            $mensaje = $response->json('error_description') ?? $response->json('error') ?? 'No se pudo obtener el token de PayPal.';
            throw new \RuntimeException($mensaje);
        }

        return (string) $response->json('access_token');
    }

    public function paypalCheckoutSuccess(Request $request)
    {
        $orderId = (string) $request->query('token', '');

        if ($orderId === '') {
            return redirect()->route('checkout.index')->with('ticket_enviado', 'No se pudo verificar el pago de PayPal.');
        }

        $paypalOrder = $this->obtenerOrdenPayPal($orderId);
        $codigoPedido = $paypalOrder['purchase_units'][0]['custom_id'] ?? null;

        if (! $codigoPedido) {
            return redirect()->route('checkout.index')->with('ticket_enviado', 'No se pudo identificar el pedido de PayPal.');
        }

        $pedidoModel = \App\Models\Pedido::where('codigo', $codigoPedido)->with('items')->firstOrFail();

        if ($pedidoModel->estado !== 'Pagado') {
            $estadoOrden = strtoupper((string) ($paypalOrder['status'] ?? ''));

            if ($estadoOrden === 'COMPLETED') {
                $pedidoModel->update(['estado' => 'Pagado']);
            } elseif ($estadoOrden === 'APPROVED') {
                $captura = $this->capturarOrdenPayPal($orderId);

                if (($captura['status'] ?? '') !== 'COMPLETED') {
                    $this->revertirPedidoPendiente($pedidoModel);
                    return redirect()->route('checkout.index')->with('ticket_enviado', 'PayPal no confirmó el cobro.');
                }

                $pedidoModel->update(['estado' => 'Pagado']);
            } else {
                $this->revertirPedidoPendiente($pedidoModel);
                return redirect()->route('checkout.index')->with('ticket_enviado', 'La orden de PayPal no está en un estado válido para cobrar.');
            }
        }

        return redirect()->route('pedido.ver', ['id' => $pedidoModel->codigo])->with('ticket_enviado', 'Pago con PayPal confirmado correctamente.');
    }

    public function paypalCheckoutCancel(Request $request)
    {
        $orderId = (string) $request->query('token', '');

        if ($orderId !== '') {
            try {
                $paypalOrder = $this->obtenerOrdenPayPal($orderId);
                $codigoPedido = $paypalOrder['purchase_units'][0]['custom_id'] ?? null;

                if ($codigoPedido) {
                    $pedidoModel = \App\Models\Pedido::where('codigo', $codigoPedido)->first();

                    if ($pedidoModel && in_array($pedidoModel->estado, ['Pendiente PayPal', 'Pendiente Bizum', 'Pendiente Stripe'], true)) {
                        $this->revertirPedidoPendiente($pedidoModel);
                    }
                }
            } catch (\Throwable $e) {
                // Si PayPal no responde, solo devolvemos al checkout.
            }
        }

        return redirect()->route('checkout.index')->with('ticket_enviado', 'Pago cancelado. Puedes intentarlo de nuevo cuando quieras.');
    }

    private function obtenerOrdenPayPal(string $orderId): array
    {
        $accessToken = $this->obtenerAccessTokenPayPal();
        $baseUrl = config('services.paypal.base_url', 'https://api-m.sandbox.paypal.com');

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->get($baseUrl . '/v2/checkout/orders/' . $orderId);

        if (! $response->successful()) {
            $mensaje = $response->json('message') ?? $response->json('error') ?? 'No se pudo consultar la orden de PayPal.';
            throw new \RuntimeException($mensaje);
        }

        return $response->json();
    }

    private function capturarOrdenPayPal(string $orderId): array
    {
        $accessToken = $this->obtenerAccessTokenPayPal();
        $baseUrl = config('services.paypal.base_url', 'https://api-m.sandbox.paypal.com');

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation',
            ])
            ->send('POST', $baseUrl . '/v2/checkout/orders/' . $orderId . '/capture', [
                'body' => '',
            ]);

        if (! $response->successful()) {
            $mensaje = $response->json('message') ?? $response->json('error') ?? 'No se pudo capturar el pago de PayPal.';
            throw new \RuntimeException($mensaje);
        }

        return $response->json();
    }

    public function stripeCheckoutSuccess(Request $request)
    {
        $sessionId = (string) $request->query('session_id', '');

        if ($sessionId === '') {
            return redirect()->route('checkout.index')->with('ticket_enviado', 'No se pudo verificar el pago con Stripe.');
        }

        $stripeSession = $this->obtenerSesionStripe($sessionId);
        $codigoPedido = $stripeSession['metadata']['pedido_codigo'] ?? $stripeSession['client_reference_id'] ?? null;

        if (! $codigoPedido) {
            return redirect()->route('checkout.index')->with('ticket_enviado', 'No se pudo identificar el pedido de Stripe.');
        }

        $pedidoModel = \App\Models\Pedido::where('codigo', $codigoPedido)->with('items')->firstOrFail();

        if ($pedidoModel->estado !== 'Pagado') {
            $paymentStatus = strtolower((string) ($stripeSession['payment_status'] ?? ''));
            $status = strtolower((string) ($stripeSession['status'] ?? ''));

            if ($paymentStatus === 'paid' || $status === 'complete') {
                $pedidoModel->update(['estado' => 'Pagado']);
            } else {
                $this->revertirPedidoPendiente($pedidoModel);
                return redirect()->route('checkout.index')->with('ticket_enviado', 'Stripe no confirmó el cobro.');
            }
        }

        return redirect()->route('pedido.ver', ['id' => $pedidoModel->codigo])->with('ticket_enviado', 'Pago con Stripe confirmado correctamente.');
    }

    public function stripeCheckoutCancel(Request $request)
    {
        $sessionId = (string) $request->query('session_id', '');

        if ($sessionId !== '') {
            try {
                $stripeSession = $this->obtenerSesionStripe($sessionId);
                $codigoPedido = $stripeSession['metadata']['pedido_codigo'] ?? $stripeSession['client_reference_id'] ?? null;

                if ($codigoPedido) {
                    $pedidoModel = \App\Models\Pedido::where('codigo', $codigoPedido)->first();

                    if ($pedidoModel && in_array($pedidoModel->estado, ['Pendiente Stripe', 'Pendiente PayPal', 'Pendiente Bizum'], true)) {
                        $this->revertirPedidoPendiente($pedidoModel);
                    }
                }
            } catch (\Throwable $e) {
                // Si Stripe no responde, solo devolvemos al checkout.
            }
        }

        return redirect()->route('checkout.index')->with('ticket_enviado', 'Pago cancelado. Puedes intentarlo de nuevo cuando quieras.');
    }

    private function obtenerSesionStripe(string $sessionId): array
    {
        $secret = config('services.stripe.secret');

        if (! $secret) {
            throw new \RuntimeException('Falta configurar STRIPE_SECRET en el entorno.');
        }

        $response = Http::withBasicAuth($secret, '')
            ->acceptJson()
            ->get('https://api.stripe.com/v1/checkout/sessions/' . $sessionId);

        if (! $response->successful()) {
            $mensaje = $response->json('error.message') ?? $response->json('message') ?? 'No se pudo consultar la sesión de Stripe.';
            throw new \RuntimeException($mensaje);
        }

        return $response->json();
    }

    public function descargarPedidoPdf($id)
    {
        $pedidoModel = \App\Models\Pedido::where('codigo', $id)->with('items')->firstOrFail();
        $pedido = $pedidoModel->toArray();
        $pedido['detalles'] = array_map(function ($it) {
            return [
                'producto_id' => $it['producto_id'],
                'nombre' => $it['nombre'],
                'cantidad' => $it['cantidad'],
                'precio_unitario' => (float) $it['precio_unitario'],
                'subtotal' => (float) $it['subtotal'],
                'descuento_aplicado' => (bool) $it['descuento_aplicado'],
            ];
        }, $pedido['items'] ?? []);

        $pdf = Pdf::loadView('pedidos.pdf', compact('pedido'));

        return $pdf->download("ticket-{$id}.pdf");
    }

    public function enviarPedidoPorCorreo(Request $request, $id)
    {
        $pedidoModel = \App\Models\Pedido::where('codigo', $id)->with('items')->firstOrFail();

        $correo = trim((string) $request->input('correo', $pedidoModel->correo ?? ''));

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['correo' => 'Introduce un correo válido para enviar el ticket.']);
        }

        // actualizar correo en BD
        $pedidoModel->update(['correo' => $correo]);

        $pedido = $pedidoModel->toArray();
        $pedido['detalles'] = array_map(function ($it) {
            return [
                'producto_id' => $it['producto_id'],
                'nombre' => $it['nombre'],
                'cantidad' => $it['cantidad'],
                'precio_unitario' => (float) $it['precio_unitario'],
                'subtotal' => (float) $it['subtotal'],
                'descuento_aplicado' => (bool) $it['descuento_aplicado'],
            ];
        }, $pedido['items'] ?? []);

        $pdf = Pdf::loadView('pedidos.pdf', compact('pedido'));
        $contenidoPdf = $pdf->output();

        Mail::send('emails.ticket', compact('pedido'), function ($message) use ($correo, $pedido, $contenidoPdf, $id) {
            $message->to($correo)
                ->subject("Ticket de compra {$id}")
                ->attachData($contenidoPdf, "ticket-{$id}.pdf", ['mime' => 'application/pdf']);
        });

        return back()->with('ticket_enviado', 'El ticket se ha enviado por correo.');
    }
}
