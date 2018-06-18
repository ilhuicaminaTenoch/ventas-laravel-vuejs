<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;
use App\Categoria;
//use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $categorias = Categoria::orderBy('id', 'desc')->paginate(3);
        }else{
            $categorias = Categoria::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'         => $categorias->total(),
                'current_page'  => $categorias->currentPage(),
                'per_page'      => $categorias->perPage(),
                'last_page'     => $categorias->lastPage(),
                'from'          => $categorias->firstItem(),
                'to'            => $categorias->lastItem()
            ],
            'categorias'    => $categorias
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }


}
