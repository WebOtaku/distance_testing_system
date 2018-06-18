<?php

namespace App\Http\Controllers;

use App\AnswerVariant;
use Illuminate\Http\Request;

class AnswerVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\AnswerVariant  $answerVariant
     * @return \Illuminate\Http\Response
     */
    public function show(AnswerVariant $answerVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AnswerVariant  $answerVariant
     * @return \Illuminate\Http\Response
     */
    public function edit(AnswerVariant $answerVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AnswerVariant  $answerVariant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnswerVariant $answerVariant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AnswerVariant  $answerVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerVariant $answerVariant)
    {
        return response()->json(
            AnswerVariant::find($answerVariant->id)->delete()
        );
    }
}
