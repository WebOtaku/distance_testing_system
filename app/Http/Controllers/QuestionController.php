<?php

namespace App\Http\Controllers;

use App\Question;
use App\AnswerVariant;
use App\AnswerFree;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
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
        if ((int)$request->question_type_id === 3)
        {
            // Вопрос со свободным ответом

            $question = $this->createQuestion($request, [
                'answer' => 'required|string|min:1'
            ]);

            AnswerFree::create([
                'question_id' => $question->id,
                'answer' => $request->answer
            ]);
        }
        else
        {
            // Вопрос со строгим ответом или с несколькими вариантами ответа

            $question = $this->createQuestion($request, [
                'answers.*.answer' => 'required|string|min:1'
            ]);

            foreach ($request->answers as $val) {
                AnswerVariant::create([
                    'question_id' => $question->id,
                    'answer' => $val['answer'],
                    'correct_answer' => $val['correct_answer']
                ]);
            }
        }
    }

    /**
     * Create a new question from request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $bonusRules
     * @return \App\Question  $question
     */
    private function createQuestion($request, $bonusRules)
    {
        $rules = [
            'test_id' => 'required|numeric',
            'question_type_id' => 'required|numeric',
            'question' => 'required|string|min:10'
        ];

        $validation = Validator::make($request->all(), $rules + $bonusRules);

        if($validation->fails())
        {
            return json_encode([
                'errors' => $validation->errors()->getMessages(),
                'code' => 422
            ]);
        }

        $question = Question::create([
            'test_id' => $request->test_id,
            'question_type_id' => $request->question_type_id,
            'question' => $request->question
        ]);

        return $question;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test) //Question $question
    {
        return Question::where('test_id', $test->id)->with('answerVariants', 'answerFree')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) //Question $question
    {
        $question_id = $request->question;

        Question::find($question_id)->delete();
    }
}
