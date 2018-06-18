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
        $user_status = auth()->user()->status->id;

        if ($user_status === 1)
        {
            return response(
                Question::where('test_id', request()->testId)
                    ->with('answerVariants', 'answerFree')->get()
            );
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
        $user_status = auth()->user()->status->id;

        if ($user_status === 1)
        {
            if ((int)$request->question_type_id === 3)
            {
                $validation = Validator::make($request->all(), [
                    'test_id' => 'required|numeric',
                    'question_type_id' => 'required|numeric',
                    'question' => 'required|string|min:10',
                    'answer_free.answer' => 'required|string|min:1'
                ]);

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

                AnswerFree::create([
                    'question_id' => $question->id,
                    'answer' => $request->answer_free['answer']
                ]);
            }
            else
            {
                $validation = Validator::make($request->all(), [
                    'test_id' => 'required|numeric',
                    'question_type_id' => 'required|numeric',
                    'question' => 'required|string|min:10',
                    'answer_variants.*.answer' => 'required|string|min:1'
                ]);

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

                foreach ($request->answer_variants as $val) {
                    AnswerVariant::create([
                        'question_id' => $question->id,
                        'answer' => $val['answer'],
                        'correct_answer' => $val['correct_answer']
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $user_status = auth()->user()->status->id;

        if ($user_status === 1)
        {
            return response(
                Question::with('answerVariants', 'answerFree')
                    ->findOrFail($question->id)
            );
        }
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
        $user_status = auth()->user()->status->id;

        if ($user_status === 1)
        {
            if ((int)$request->question_type_id === 3)
            {
                $validation = Validator::make($request->all(), [
                    'test_id' => 'required|numeric',
                    'question_type_id' => 'required|numeric',
                    'question' => 'required|string|min:10',
                    'answer_free.answer' => 'required|string|min:1'
                ]);

                if($validation->fails())
                {
                    return json_encode([
                        'errors' => $validation->errors()->getMessages(),
                        'code' => 422
                    ]);
                }

                Question::find($question->id)->update([
                    'test_id' => $request->test_id,
                    'question_type_id' => $request->question_type_id,
                    'question' => $request->question
                ]);

                if ($question->question_type_id !== 3) {
                    AnswerVariant::where('question_id', $question->id)->delete();
                }

                $id = (isset($request->answer_free['id']))? $request->answer_free['id'] : 0;

                AnswerFree::updateOrCreate(['id' => $id], [
                    'question_id' => $request->id,
                    'answer' => $request->answer_free['answer']
                ]);
            }
            else
            {
                $validation = Validator::make($request->all(), [
                    'test_id' => 'required|numeric',
                    'question_type_id' => 'required|numeric',
                    'question' => 'required|string|min:10',
                    'answer_variants.*.answer' => 'required|string|min:1'
                ]);

                if($validation->fails())
                {
                    return json_encode([
                        'errors' => $validation->errors()->getMessages(),
                        'code' => 422
                    ]);
                }

                Question::find($question->id)->update([
                    'test_id' => $request->test_id,
                    'question_type_id' => $request->question_type_id,
                    'question' => $request->question
                ]);

                if ($question->question_type_id === 3) {
                    AnswerFree::where('question_id', $question->id)->delete();
                }

                foreach ($request->answer_variants as $val) {
                    $id = (isset($val['id']))?  $val['id'] : 0;

                    AnswerVariant::updateOrCreate(['id' => $id], [
                        'question_id' => $question->id,
                        'answer' => $val['answer'],
                        'correct_answer' => $val['correct_answer']
                    ]);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        return response()->json(
            Question::find($question->id)->delete()
        );
    }
}
