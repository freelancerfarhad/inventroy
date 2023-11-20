<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPEmail;
use App\Helper\JWTToken;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    // Page Controller
    public function RegistrationPage():View{
        return view('pages.auth.registration-page');
    }
    public function LoginPage():View{
        return view('pages.auth.login-page');
    }
    public function SendOtpPage():View{
        return view('pages.auth.send-otp-page');
    }
    public function VerifyOtpPage():View{
        return view('pages.auth.verify-otp-page');
    }
    public function ResetPasswordPage():View{
        return view('pages.auth.reset-password-page');
    }
    public function UserProfilePage():View{
        return view('pages.dashboard.profile-page');
    }

    // API Controller
    //userRegister
    public function UserRegistration(Request $request) {
        try{
            // $userReg = User::create($request->input());
            $userReg = User::create([
                'firstName'=>$request->input('firstName'),
                'lastName'=>$request->input('lastName'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'password'=>$request->input('password'),
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'User Registration Successfuly !'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'User Registration Fail Because Email-Exist ! from back-end'
            ],200);
        }
    }
        //userLogin
    public function UserLogin(Request $request){

        $res = User::where('email','=',$request->input('email'))
        ->where('password','=',$request->input('password'))
        ->select('id')->first();

        if($res!==null){
            // user login -> jwt token isue korbo
            $token = JWTToken::CreateToken($request->input('email'),$res->id);
            return response()->json([
                'status'=>'success',
                'message'=>'User Log-In Successfuly !',
            ],200)->cookie('token',$token,60*60*20);
        }
        else{
            return response()->json([
                'status'=>'fail',
                'message'=>'unauthorized'
            ],200);
        }
    }
    //SendOTPToEmail
    public function SendOTPToEmail(Request $request){
        $userMail = $request->input('email');
        $otp = rand(1000,9999);

        $res = User::where('email','=',$userMail)->count();

        if($res==1){
            Mail::to($userMail)->send(new OTPEmail($otp));
            //inser data databse
            User::where('email','=',$userMail)->update(['otp'=>$otp]);

            return response()->json([
                'status'=>'success',
                'message'=>'Otp send your mail please checked'
            ],200);
        }
        else{
            return response()->json([
                'status'=>'fail',
                'message'=>'unauthorized'
            ],401);
        }
    }
    //OTPVerify
    public function OTPVerify(Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email','=', $email)->where('otp','=',$otp)->count();
        //short query
        // $count = User::where($request->input())->count();

        if($count==1){
           
            //inser data databse
            User::where('email','=',$email)->update(['otp'=>'0']);
             // Reset Pass  Token
             $token = JWTToken::CreateTokenForSetPassowed($request->input('email'));
            return response()->json([
                'status'=>'success',
                'message'=>'Otp Verification Successfull',
                'token'=>$token,
            ],200)->cookie('token',$token,60*60*20);
        }
        else{
            return response()->json([
                'status'=>'fail',
                'message'=>'unauthorized',
            ],401);
        }
    }
    //SetPassword
    public function ResetPassword(Request $request) {

        try{
            $email=$request->header('email');
            $password=$request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }

    //UserLogout
    public function UserLogout() {
        return redirect('/LoginPage')->cookie('token','',-1);

    }

    //ProfileUpdate
    function UserProfile(Request $request){
        $email=$request->header('email');
        $user=User::where('email','=',$email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ],200);
    }
    
    function UpdateProfile(Request $request){
        try{
            $email=$request->header('email');
            $user =  $request->header( 'id' );
            $firstName=$request->input('firstName');
            $lastName=$request->input('lastName');
            $mobile=$request->input('mobile');
            $password=$request->input('password');
            
            User::where('email','=',$email)->update([
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }
    //profile image update




}
