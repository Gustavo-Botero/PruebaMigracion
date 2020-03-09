<?php

namespace App\Helpers;

use App\Models\User;
use Firebase\JWT\JWT;

class JwtAuth
{
    public $key;

    public function __construct()
    {
        $this->key = 'ClaveSecreta256';
    }

    public function singUp($email, $password, $getToken = null)
    {
        $user = User::where([
            'email' => $email,
            'password' => $password
        ])->first();

        if (!is_object($user)) {
            return [
                'status' => 'Error',
                'message' => 'Login ha fallado!!'
            ];
        }

        $token = [
            'sub' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'surname' => $user->surname,
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60),
        ];

        $jwt = JWT::encode($token, $this->key, 'HS256');
        $decoded = JWT::decode($jwt, $this->key, ['HS256']);

        if (!is_null($getToken)) {
            return $jwt;
        }

        return $decoded;
    }
}
