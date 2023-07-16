<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function Register(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'user_name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6',
            ]);

            // Create the new user
            $user = User::create([
                'user_name' => $validatedData['user_name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            // Generate a token for the user
            $token = $user->createToken('authToken')->plainTextToken;

            // Return a success response
            return response()->json(['status' => 'success', 'data' => ['user' => $user, 'token' => $token]], 201);
        } catch (ValidationException $e) {
            // Return a validation error response
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    // This is for auto token create
    // public function login(Request $request)
    // {
    //     try {
    //         // Validate the incoming request data
    //         $validatedData = $request->validate([
    //             'email' => 'required|string|email',
    //             'password' => 'required|string',
    //         ]);

    //         // Check if the provided credentials are valid
    //         if (!Auth::attempt($validatedData)) {
    //             return response()->json(['status' => 'error', 'data' => ['message' => 'Invalid credentials']], 401);
    //         }
    //         // Retrieve the authenticated user
    //         $user = Auth::user();

    //         // Generate a new token for the user
    //         $token = $user->createToken('authToken')->plainTextToken;

    //         // Return the token in JSON format
    //         return response()->json(['status' => 'success', 'data' => ['user' => $user, 'token' => $token]], 200);
    //     } catch (ValidationException $e) {

    //         // Return validation error in JSON format
    //         return response()->json(['status' => 'error', 'data' => $e->getMessage()], 422);
    //     } catch (\Exception $e) {

    //         // Return other errors in JSON format
    //         return response()->json(['status' => 'error', 'data' => $e->getMessage()], 500);
    //     }
    // }
    //This is Creating a custom JWTToken

    public function Login(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Check if the provided credentials are valid
            if (!Auth::attempt($validatedData)) {
                return response()->json(['status' => 'error', 'data' => ['message' => 'Invalid credentials']], 401);
            }

            // Retrieve the authenticated user
            $user = Auth::user();

            // Generate a new token using your custom JWTToken::CreateToken() method
            $token = JWTToken::CreateToken($user->email); // Replace 'email' with the appropriate field to identify the user

            // Return the token in JSON format
            return response()->json(['status' => 'success', 'data' => ['user' => $user, 'token' => $token]], 200);
        } catch (ValidationException $e) {
            // Return validation error in JSON format
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            // Return other errors in JSON format
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }

    public function GetUser(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }

    public function SendMail(Request $request)
    {
        $user_mail = $request->input('email');
        $otp = rand(1000, 9999);
        $res = User::where($request->input())->count();
        //Mail Send
        if ($res == 1) {
            Mail::To($user_mail)->send(new SendMail($otp));
            // Database Update
            User::where($request->input())->update(['otp' => $otp]);
            return response()->json(['message' => 'success', 'data' => 'OTP send to your mail']);
        } else {
            return response()->json(['message' => 'fail', 'data' => 'Invalid Mail or Unauthorised ']);
        }
    }
    public function OtpVerify(Request $request)
    {
        $res = User::where($request->input())->count();
        if ($res == 1) {
            User::where($request->input())->update(['otp' => "0"]);
            return response()->json(['message' => 'success', 'data' => 'Verified OTP']);
        } else {
            return response()->json(['message' => 'fail', 'data' => 'Invalid OTP']);
        }
    }
    public function SetPassword(Request $request)
    {
        User::where($request->input())->update(['password' => $request->input('password')]);
        return response()->json(['message' => 'success', 'data' => 'Password Updated']);
    }
    public function ProfileUpdate()
    {

    }

}
