<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{

    // Create Token
    public static function CreateToken($userEmail,$userID):string{

        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-jwt',
            'iat' => time(),
            'exp' => time() + 60*60,
            'userEmail'=>$userEmail,
            'userID'=>$userID
        ];

        return $jwt = JWT::encode($payload, $key, 'HS256');
    }
      // Reset Pass  Token
    public static function CreateTokenForSetPassowed($userEmail):string{

        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-jwt',
            'iat' => time(),
            'exp' => time() + 60*10,
            'userEmail'=>$userEmail,
            'userID'=>'0'
        ];

        return $jwt = JWT::encode($payload, $key, 'HS256');
    }
  
    // Verify  Token
    public static function VerifyToken($token):string|object{
        try{
            if($token==null){
                return "unauthorized";
            }
            else{

            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded;
                            
            }

        }
        catch(Exception $e){
            return "unauthorized";
        }
    }
}