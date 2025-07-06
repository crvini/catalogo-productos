<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

public function list(Request $request)
{
    $sort = $request->input('sort', 'fecha_ingreso');
    $order = $request->input('order', 'asc');

    $productos = Product::orderBy($sort, $order)->paginate(5);

    $productos->getCollection()->transform(function ($producto) {
        $producto->fecha_ingreso = Carbon::parse($producto->fecha_ingreso)->format('d/m/Y');
        $producto->fecha_vencimiento = Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y');
        return $producto;
    });

    return response()->json($productos);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|alpha_num|unique:products,codigo',
            'nombre' => 'required|regex:/^[\pL\s]+$/u',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date_format:Y-m-d',
            'fecha_vencimiento' => 'required|date_format:Y-m-d|after_or_equal:fecha_ingreso',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1536',
        ]);
\Log::info('Archivo recibido', [
    'hasFile' => $request->hasFile('foto'),
    'valid' => $request->file('foto')?->isValid(),
    'nombre' => $request->file('foto')?->getClientOriginalName()
]);

if ($request->hasFile('foto')) {
    $foto = $request->file('foto');
    
    if ($foto->isValid()) {
        $nombre = uniqid() . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('fotos'), $nombre);
        $validated['foto'] = 'fotos/' . $nombre;

        \Log::info('Foto movida a public/fotos', ['path' => $validated['foto']]);
    } else {
        return response()->json([
            'message' => 'The foto failed to upload.',
            'errors' => ['foto' => ['Archivo inválido o dañado.']]
        ], 422);
    }
}




        Product::create($validated);
        return response()->json(['success' => true]);
    }
    public function show($id)
{
    return Product::findOrFail($id);
}

public function update(Request $request, $id)
{
    $producto = Product::findOrFail($id);

    $validated = $request->validate([
        'codigo' => 'required|alpha_num|unique:products,codigo,' . $id,
        'nombre' => 'required|regex:/^[\pL\s]+$/u',
        'cantidad' => 'required|integer|min:1',
        'precio' => 'required|numeric|min:0',
        'fecha_ingreso' => 'required|date_format:Y-m-d',
        'fecha_vencimiento' => 'required|date_format:Y-m-d|after_or_equal:fecha_ingreso',
        'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1536',
    ]);

    \Log::info('Archivo recibido', [
    'hasFile' => $request->hasFile('foto'),
    'valid' => $request->file('foto')?->isValid(),
    'nombre' => $request->file('foto')?->getClientOriginalName()
]);


   if ($request->hasFile('foto')) {
    $foto = $request->file('foto');
    
    if ($foto->isValid()) {
        $nombre = uniqid() . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('fotos'), $nombre);
        $validated['foto'] = 'fotos/' . $nombre;

        \Log::info('Foto movida a public/fotos', ['path' => $validated['foto']]);
    } else {
        return response()->json([
            'message' => 'The foto failed to upload.',
            'errors' => ['foto' => ['Archivo inválido o dañado.']]
        ], 422);
    }
}

    $producto->update($validated);

    return response()->json(['success' => true]);
}


public function destroy($id)
{
    Product::destroy($id);
    return response()->json(['success' => true]);
}

}
