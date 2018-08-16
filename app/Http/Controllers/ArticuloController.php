<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $articulos = Articulo::join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                ->select('articulos.id', 'articulos.id_categoria', 'articulos.codigo', 'articulos.nombre', 'categorias.nombre as nombre_categoria', 'articulos.precio_venta', 'articulos.stock', 'articulos.descripcion', 'articulos.condicion')
                ->orderBy('articulos.id', 'desc')->paginate(3);
        } else {
            $articulos = Articulo::join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                ->select('articulos.id', 'articulos.id_categoria', 'articulos.codigo', 'articulos.nombre', 'categorias.nombre as nombre_categoria', 'articulos.precio_venta', 'articulos.stock', 'articulos.descripcion', 'articulos.condicion')
                ->where('articulos.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('id', 'desc')->paginate(3);



        }

        return [
            'pagination' => [
                'total' => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page' => $articulos->perPage(),
                'last_page' => $articulos->lastPage(),
                'from' => $articulos->firstItem(),
                'to' => $articulos->lastItem()
            ],
            'articulos' => $articulos
        ];
    }

    public function buscarArticulo(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulo = Articulo::where('codigo', '=', $filtro)
            ->select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->take(1)
            ->get();

        return ['articulos' => $articulo];


    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = new Articulo();

        $articulo->id_categoria = $request->id_categoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::findOrFail($request->id);
        $articulo->id_categoria = $request->id_categoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();

    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Articulo::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $categoria = Articulo::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }
}
