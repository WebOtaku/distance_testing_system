<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;

use App\User;

use App\Student;

use App\Teacher;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
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
        return view('registration.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = [];

        $user_rules = [
            'name' => 'required|string|min:3|max:255',
            'surname' => 'required|string|min:3|max:255',
            'patronymic' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|min:6|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'status_id' => 'required|numeric',
            'avatar' => 'required|image|max:2048'
        ];

        $student_rules = [
            'speciality_id' => 'required|numeric',
            'group' => 'required|string|min:7|max:8',
            'course' => 'required|numeric'
        ];

        $teacher_rules = [
            'speciality' => 'required|string|min:3'
        ];

        if ((int)$request->status_id === 1)
        {
            $this->validate($request, $user_rules + $teacher_rules);

            $user = $this->createUser($request);

            Teacher::create([
                'user_id' => $user->id,
                'speciality' => $request->speciality
            ]);
        }
        elseif ((int)$request->status_id === 1)
        {
            $this->validate($request, $user_rules + $student_rules);

            $user = $this->createUser($request);

            Student::create([
                'user_id' => $user->id,
                'speciality_id' => $request->speciality_id,
                'group' => $request->group,
                'course' => $request->course
            ]);
        }

        auth()->login($user);

        return redirect()->home();
    }

    /**
     * Create a new user from request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\User $user
     * */
    private function createUser($request)
    {
        $user_data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_id' => $request->status_id
        ];

        $path = $request->file('avatar')->store('public/avatars');

        $path = str_replace('public', '', $path);

        $avatar = ['avatar' => $path];

        $user = User::create($user_data + $avatar);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
