<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Producto;
use App\Models\Estanteria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    // Listado de productos (el panel de admin)
    public function index()
    {
        // Cargamos los productos con su estantería (Eager Loading) para que no falle
        $productos = \App\Models\Producto::with('estanteria')->get();
        
        // El punto indica carpetas: admin/productos/index.blade.php
        return view('admin.productos.index', compact('productos'));

        // $productos = Producto::with(['estanteria', 'proveedor'])->get();
        // return view('admin.productos.index', compact('productos'));
    }

    // Mostrar el formulario para crear uno nuevo
    public function create()
    {
        $estanterias = Estanteria::all();
        $proveedores = Proveedor::all();
        return view('admin.productos.create', compact('estanterias', 'proveedores'));
    }

    // Guardar el producto en la base de datos
    

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'codigo_barras' => 'required|unique:productos',
        'stock_actual' => 'required|integer',
        'fecha_caducidad' => 'required|date',
        'estanteria_id' => 'required|exists:estanterias,id',
        'proveedor_id' => 'required|exists:proveedores,id',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    $data = $request->all();

    if ($request->hasFile('imagen')) {
        $data['imagen'] = $request->file('imagen')->store('productos', 'public');
    }

    Producto::create($data);

    return redirect()->route('productos.index')
        ->with('success', 'Producto creado con éxito');
}


    //Aquí irían edit, update y destroy...


    // Aquí irían edit, update y destroy...

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $estanterias = Estanteria::all();
        $proveedores = Proveedor::all();
        return view('admin.productos.edit', compact('producto', 'estanterias', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, Producto $producto)
{
    $request->validate([
        'nombre' => 'required',
        'codigo_barras' => 'required|unique:productos,codigo_barras,' . $producto->id,
        'stock_actual' => 'required|integer',
        'precio' => 'required|numeric',
        'fecha_caducidad' => 'required|date',
        'estanteria_id' => 'required|exists:estanterias,id',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    $data = $request->all();

    if ($request->hasFile('imagen')) {

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $data['imagen'] = $request->file('imagen')->store('productos', 'public');
    }

    $producto->update($data);

    return redirect()->route('productos.index')
        ->with('success', 'Producto actualizado correctamente');
}

    //Borrar el producto
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado');
    }
}
