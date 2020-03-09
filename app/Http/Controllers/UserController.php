<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(Request $req)
    {
        $json = $req->json;
        $params = json_decode($json);

        $name = !is_null($json) && isset($params->name) ? $params->name : '';
        $surname = !is_null($json) && isset($params->surname) ? $params->surname : '';
        $email = !is_null($json) && isset($params->email) ? $params->email : '';
        $password = !is_null($json) && isset($params->password) ? $params->password : '';

        if (!is_null($name) && !is_null($email) && !is_null($password)) {
            if (is_null($this->user->where('email', $email)->get()->first())) {
                $this->user->role = 'ROLE_USER';
                $this->user->name = $name;
                $this->user->surname = $surname;
                $this->user->email = $email;
                $this->user->password = bcrypt($password);
                $this->user->save();

                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario registrado'
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario duplicado, no se puede registrar'
                ];
            }
        } else {
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Usuario no registrado'
            ];
        }

        return response()->json($data, 200);
    }

    public function login()
    {
        return 'Login de usuario';
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
        //
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
