<?php

namespace App\Http\Controllers;

use App\Theme;
use App\DisciplineTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
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

        if ($user_status === 1 && request()->query()) {
            $offset = request()->pageNumber * request()->pageSize - request()->pageSize;
            $limit = request()->pageSize;

            $themes = Theme::offset($offset)->limit($limit)
                ->with('disciplineTeacher.discipline.cicle')
                ->whereHas('disciplineTeacher', function ($query) {
                    $teacher_id = auth()->user()->teacher->id;
                    $query->where('teacher_id', $teacher_id);
                })->get();


            $totalRow = count(Theme::whereHas('disciplineTeacher', function ($query) {
                $teacher_id = auth()->user()->teacher->id;
                $query->where('teacher_id', $teacher_id);
            })->get());

            return response()->json(compact(['themes', 'totalRow']));
        }
        else if ($user_status === 1) {
            return response(
                Theme::whereHas('disciplineTeacher', function ($query) {
                    $teacher_id = auth()->user()->teacher->id;
                    $query->where('teacher_id', $teacher_id);
                })->get()
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

        if ($user_status === 1) {

            $teacher_id = auth()->user()->teacher->id;

            $validation = Validator::make($request->all(), [
                'discipline_id' => 'required|numeric',
                'name' => 'required|string|min:3|max:255',
                'course' => 'required|numeric|min:1|max:4'
            ]);

            if($validation->fails())
            {
                return json_encode([
                    'errors' => $validation->errors()->getMessages(),
                    'code' => 422
                ]);
            }

            $discipline_teacher = DisciplineTeacher::firstOrCreate([
                'teacher_id' => $teacher_id,
                'discipline_id' => $request->discipline_id
            ]);

            $theme = Theme::firstOrCreate([
                'discipline_teacher_id' => $discipline_teacher->id,
                'name' => $request->name,
                'course' => $request->course
            ]);

            return response()->json(['theme_id' => $theme->id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $theme)
    {
        $user_status = auth()->user()->status->id;

        if ($user_status === 1) {
            $theme = Theme::with('disciplineTeacher.discipline.cicle')
                ->whereHas('disciplineTeacher', function ($query) {
                    $teacher_id = auth()->user()->teacher->id;
                    $query->where('teacher_id', $teacher_id);
                })->findOrFail($theme->id);

            return response($theme);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Theme $theme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theme $theme)
    {
        $user_status = auth()->user()->status->id;

        if ($user_status === 1) {

            $teacher_id = auth()->user()->teacher->id;

            $validation = Validator::make($request->all(), [
                'discipline_id' => 'required|numeric',
                'name' => 'required|string|min:3|max:255',
                'course' => 'required|numeric|min:1|max:4'
            ]);

            if($validation->fails())
            {
                return json_encode([
                    'errors' => $validation->errors()->getMessages(),
                    'code' => 422
                ]);
            }

            $discipline_teacher = DisciplineTeacher::firstOrCreate([
                'teacher_id' => $teacher_id,
                'discipline_id' => $request->discipline_id
            ]);

            Theme::find($theme->id)->update([
                'discipline_teacher_id' => $discipline_teacher->id,
                'name' => $request->name,
                'course' => $request->course
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $theme)
    {
        return response()->json(
            Theme::find($theme->id)->delete()
        );
    }
}
