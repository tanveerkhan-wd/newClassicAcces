<?php
/**
* UserController 
*/

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\EmailSmsMaster;
use App\Mail\sendEmail;
use App\Models\User;
use Validator;
use Session;
use Config;
use Auth;
use Hash;
use URL;

class UserController extends Controller
{
    use AuthenticatesUsers;
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Used for Admin Login
     * @return redirect to Login
    */
    public function index(Request $request)
    {
        return view('auth.login');
    }

    /**
     * Used for Login
     * @return redirect to Login
    */
    public function loginPost(Request $request)
    {
        $input = $request->all();            
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('adminLoginForm')
                        ->withErrors($validator)
                        ->withInput();
        }
        $emailCount = User::where('email','=',$input['email'])->count();

        $noEmailFound = true;

        if($emailCount != 0){
          $userData = User::where('email','=',$input['email'])->first();
          $Name = $userData->adm_Name;
          $noEmailFound = false;
        }

        if($noEmailFound){
          $message =  'No such email found';
          return redirect()->route('adminLoginForm')->withErrors([$message]);
        }

        $userType = 'admin';

        if(!empty($userType)){
            if(Auth::attempt(['email' => $input['email'], 'password' => $input['password'] ],true)){
                if (Auth::check()) {
                    $rediret =  redirect()->route('adminDashboard');
                }else{
                   $rediret =  redirect()->route('adminLoginForm')->withErrors("Something Went Wrong!");
                }
                return $rediret;
            }else{
                $message =  'Please enter valid password';
                return redirect()->route('adminLoginForm')
                        ->withErrors([$message]);
            }
        }


    }

    /**
     * Used for Forgot Password Page
     * @return redirect to Admin->Forgot Password page
    */
    public function forgotPassword(Request $request)
    {
      return view('auth.forgot');        
    }


    /**
     * Used for Forgot Password Check
     * @return redirect to Admin->Forgot Password Check
    */
    public function forgotPasswordPost(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('forgotPassword')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::where('email','=',$input['email'])->first();
        
        if (empty($user)) 
        {
            $message = 'Sorry, we can not find this email id in the system. Please try again later';
            return redirect()->route('forgotPassword')
                        ->withErrors([$message])
                        ->withInput();
        }else{ 
          
          $data = EmailSmsMaster::where('email_sms_key', 'forget_password')->first();

          if (isset($data) && !empty($data)) {
            $data = $data->toArray();      
            
            $num = mt_rand(1000,9999);
            
            $user->forgot_password_otp = $num;
            $user->update();
            
            $message = $data['content'];

            $subject = $data['subject'];
            
            $message1 = str_replace("{{USERNAME}}", $user->name, $message);
            
            $msg = str_replace("{{RESET_PASS_OTP}}", $num, $message1);
            $mail = Mail::to($user->email)->send(new sendEmail($msg,$subject));

            $user_id = $user->user_id;
            $message ='A password reset Otp has been sent on your registered Email address';
            return redirect()->route('getVerifyOtp',['id'=>$user_id])->with('success', $message);
            
          }else{
            $message ='Email Template Not Found';
            return redirect()->route('forgotPassword')->withErrors([$message])
                        ->withInput();
          }

        }
    }


    /**
    * Used for Admin OTP verify check right or not
    * @return redirect to Admin->OTP Check
    */
    public function getVerifyOtp(Request $request, $user_id)
    {
      $user_id = User::where('user_id',$user_id)->first();
      if ($user_id) {
        return view('auth.verifyOtp',compact('user_id'));
      }else{
        $message ='Something Went Wrong';
            return redirect()->route('forgotPassword')->withErrors([$message])
                        ->withInput();
      }
    }


    /**
    * Used for Admin OTP verify check right or not
    * @return redirect to Admin->OTP Check
    */
    public function verifyOtpPost(Request $request)
    {
        $input = $request->all();
        $user = User::where('user_id','=',$input['user_id'])->first();
        if(!empty($user->forgot_password_otp) && $user->forgot_password_otp==$input['otp']){
              $uType = Config::get('constant.role.'.$user->user_type);
              $current_time = date("Y-m-d H:i:s");
              $reset_pass_token = base64_encode($user->email.'&&'.$uType."&&".$current_time);
              $resetLink = URL::to('resetPassword').'/'.$reset_pass_token;
             return redirect($resetLink);            
        
        }else{
          $message ='Please enter valid OTP';
            return redirect()->route('getVerifyOtp',['id'=>$input['user_id']])->withErrors([$message])->withInput();
        }
    }


    /**
    * Used for Admin resetPassword
    * @return redirect to Admin->resetPassword
    */
    public function resetPassword($token)
    {
        $response = [];

        $decoded = base64_decode($token);
        $tmp_dec = explode('&&', $decoded);
        
        if(empty($tmp_dec[0]) || empty($tmp_dec[1]) || empty($tmp_dec[2])){
            $response['status'] = false;
            $response['message'] = 'Invalid reset password token';
            return response()->json($response);
            exit();
        }


        $current_time = date("Y-m-d H:i:s");

        $minuteDiff = round((strtotime($current_time) - strtotime($tmp_dec[2]))/60, 1);


        if($minuteDiff > 30){ //check if link is generated more than 30 mins ago
            $message =  'Sorry, the reset password link is expired please try again';
            return redirect()->route('forgotPassword')
                        ->withErrors([$message])
                        ->withInput();
        }
      
        return view('auth.reset_password',['token'=>$token]);
    }


    /**
    * Used for Admin resetPasswordPost
    * @return redirect to Admin->resetPasswordPost
    */    
    public function resetPasswordPost(Request $request)
    {
        $input = $request->all();
        $response = [];
        $decoded = base64_decode($input['token']);
        $tmp_dec = explode('&&', $decoded);
        
        if(empty($tmp_dec[0]) || empty($tmp_dec[1])){
            $response['status'] = false;
            $response['message'] =  'Invalid reset password token';
            return response()->json($response);
            exit();
        }

        $new_pass = Hash::make($input['new_password']);

        $user = User::where('email', $tmp_dec[0])->first();

        if(!empty($user)) {
          $user->password = $new_pass;
          $user->save();
          $response['status'] = true;
          $response['message'] =  'Reset Password Successful';
        }else{
          $response['status'] = false;
          $response['message'] =  'Sorry, your account does not exist in the system';
        }
        $response['redirect'] = route('adminLoginForm');
        return response()->json($response);
    }

    //SET PASSWORD FOR SUB ADMIN
    public function setPassword($token)
    {
        $response = [];

        $decoded = base64_decode($token);
        $tmp_dec = explode('&&', $decoded);
        
        if(empty($tmp_dec[0]) || empty($tmp_dec[1]) || empty($tmp_dec[2])){
            $response['status'] = false;
            $response['message'] = 'Invalid reset password token';
            return response()->json($response);
            exit();
        }


        $current_time = date("Y-m-d H:i:s");

        $minuteDiff = round((strtotime($current_time) - strtotime($tmp_dec[2]))/60, 1);


        if($minuteDiff > 30){ //check if link is generated more than 30 mins ago
            $message = $this->translations['msg_reset_pass_link_expire'] ?? 'Sorry, the reset password link is expired please try again';
            return redirect()->route('forgotPassword')
                        ->withErrors([$message])
                        ->withInput();
        }
      
        return view('auth.reset_password',['token'=>$token]);
    }

    /**
     * Used for Admin Logout
     * @return redirect to Admin->Logout
    */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('adminLoginForm');     
      
    }
}