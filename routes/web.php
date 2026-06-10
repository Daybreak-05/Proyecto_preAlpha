<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicTiendaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\EstanteriaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (CLIENTES)
|--------------------------------------------------------------------------
*/

//Test
Route::get('/test', function () {
    return 'OK LARAVEL';
});
Route::view('/sobre-nosotros', 'info.sobre-nosotros')->name('sobre');
Route::view('/contacto', 'info.contacto')->name('contacto');
Route::view('/privacidad', 'info.privacidad')->name('privacidad');
Route::view('/terminos', 'info.terminos')->name('terminos');
Route::view('/cookies', 'info.cookies')->name('cookies');


// Página principal: Tienda y Mapa en gris
Route::get('/', [PublicTiendaController::class, 'index'])->name('index');
// API para filtrar productos por estantería desde el mapa (AJAX)
Route::get('/api/estanteria/{id}/productos', [PublicTiendaController::class, 'filtrarPorEstanteria']);
// Rutas de compra para clientes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [PublicTiendaController::class, 'checkout'])->name('checkout.index');
    Route::post('/carrito/procesar', [PublicTiendaController::class, 'procesarCompra'])->name('carrito.procesar');
    Route::get('/checkout/stripe/success', [PublicTiendaController::class, 'stripeCheckoutSuccess'])->name('checkout.stripe.success');
    Route::get('/checkout/stripe/cancel', [PublicTiendaController::class, 'stripeCheckoutCancel'])->name('checkout.stripe.cancel');
    Route::get('/checkout/paypal/success', [PublicTiendaController::class, 'paypalCheckoutSuccess'])->name('checkout.paypal.success');
    Route::get('/checkout/paypal/cancel', [PublicTiendaController::class, 'paypalCheckoutCancel'])->name('checkout.paypal.cancel');
    Route::get('/pedido/{id}', [PublicTiendaController::class, 'verPedido'])->name('pedido.ver');
    Route::get('/pedido/{id}/pdf', [PublicTiendaController::class, 'descargarPedidoPdf'])->name('pedido.pdf');
    Route::post('/pedido/{id}/enviar', [PublicTiendaController::class, 'enviarPedidoPorCorreo'])->name('pedido.enviar');
});


/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (EMPLEADOS / ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Panel de control principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUDs de gestión
    Route::resource('productos', ProductoController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('estanterias', EstanteriaController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
