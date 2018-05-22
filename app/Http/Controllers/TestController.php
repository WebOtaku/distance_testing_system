<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Test::all();
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
        $validation = Validator::make($request->all(), [
            'theme_id' => 'required|numeric',
            'name' => 'required|string|min:3|max:255',
            'number_questions' => 'required|numeric|min:1|max:99'
        ]);

        if($validation->fails())
        {
            return json_encode([
                'errors' => $validation->errors()->getMessages(),
                'code' => 422
            ]);
        }

        $test = Test::create([
            'theme_id' => $request->theme_id,
            'name' => $request->name,
            'number_questions' => $request->number_questions
        ]);

        return response()->json([ 'test_id' => $test->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) //, Test $test
    {
        if ($request->action == 'change_state') {
            Test::find($request->test)
                ->update(['active' => $request->value]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) // Test $test
    {
        $test_id = $request->test;

        Test::find($test_id)->delete();
    }
}
