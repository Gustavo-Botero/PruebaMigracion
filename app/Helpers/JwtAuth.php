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

    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;
        try {
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }

        if (is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        }

        if ($getIdentity) {
            return $decoded;
        }

        return $auth;
    }
}
