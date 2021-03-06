<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Type::paginate(50);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Type::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return $type;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $type->update($request->all());

        return $type;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        return Type::destroy($type->id);
    }
}
