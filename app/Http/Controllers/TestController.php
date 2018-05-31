<?php

namespace App\Http\Controllers;

use App\Test;
use App\ScoreScale;
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
        $user_status = auth()->user()->status->name;

        if ($user_status === 'Преподаватель') {
            $offset = request()->pageNumber * request()->pageSize - request()->pageSize;
            $limit = request()->pageSize;
            $teacher_id = auth()->user()->teacher->id;

            $tests = Test::offset($offset)
                ->limit($limit)
                ->with('theme.disciplineTeacher.discipline.cicle', 'speciality')
                ->where('teacher_id', $teacher_id)
                ->get();
            $totalRow = count(Test::where('teacher_id', $teacher_id)->get());

            return response()->json(compact(['tests', 'totalRow']));
        }
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
            'speciality_id' => 'required|numeric',
            'theme_id' => 'required|numeric',
            'name' => 'required|string|min:3|max:255',
            'number_questions' => 'required|numeric|min:1|max:99',
            'score_scales.*.from' => 'required|numeric|min:1|max:99',
            'score_scales.*.to' => 'required|numeric|min:1|max:99',
            'score_scales.*.score' => 'required|numeric|min:1|max:5'
        ]);

        if($validation->fails())
        {
            return json_encode([
                'errors' => $validation->errors()->getMessages(),
                'code' => 422
            ]);
        }

        $test = Test::create([
            'speciality_id' => $request->speciality_id,
            'theme_id' => $request->theme_id,
            'teacher_id' => auth()->user()->teacher->id,
            'name' => $request->name,
            'number_questions' => $request->number_questions
        ]);

        foreach ($request->score_scales as $val) {
            ScoreScale::create([
                'test_id' => $test->id,
                'from' => $val['from'],
                'to' => $val['to'],
                'score' => $val['score']
            ]);
        }

        return response()->json(['test_id' => $test->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return response(
            Test::with('theme')->find($test->id)
        );
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
    public function destroy(Test $test)
    {
        return response()->json(Test::find($test->id)->delete());
    }
}
