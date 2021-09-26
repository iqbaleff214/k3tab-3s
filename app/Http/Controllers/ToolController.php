<?php

namespace App\Http\Controllers;

use App\Models\tool;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function show(tool $tool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function edit(tool $tool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tool $tool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function destroy(tool $tool)
    {
        //
    }
}
