<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Bill;
use App\User;
use Storage;
use Config;
use File;
use Auth;
use Hash;
class DashboardController extends Controller
{
   	public function dashboard()
    {
        $data = [];
        $data['product'] = Product::count();
        $data['customer'] = Customer::count();
        $data['bills'] = Bill::count();
        return view('admin.dashboard.dashboard',compact('data'));
    }


	/**
	 * Used for Admin Profile
	 * @return redirect to Admin->Profile
	 */
    public function profile(Request $request)
    {
        if (request()->ajax()) {
            return \View::make('admin.dashboard.profile')->renderSections();
        }
        return view('admin.dashboard.profile');
    }


    /**
	 * Used for editProfile
	 * @return redirect to Admin->editProfile
	 */
    public function editProfile(Request $request){

        $response = [];
        $input = $request->all();      

        $emailExist = User::where('email','=', $input['email'])->where('user_id','!=',Auth::user()->user_id)->get();
        $emailExistCount = $emailExist->count();
        
        if($emailExistCount != 0){
            $response['status'] = false;
            $response['message'] =  'Email already exist, Please try with a different email';
            return response()->json($response);
            die();
        }
        
        $user = User::findorfail(Auth::user()->user_id);
        $user->email = $input['email'];
        $user->name = $input['name'];
        $user->mobile_number = $input['mobile_number'];
        
        if($request->hasFile('user_img')){
            $gen_rand = rand(100,99999).time();
            $image_path = $request->file('user_img');
            $extension = $image_path->getClientOriginalExtension();
            Storage::disk('public')->put(Config::get('constant.images_dirs.USERS').'/'.$gen_rand.'.'.$extension,  File::get($image_path));
            if(!empty($user->user_photo)){
                Storage::disk('public')->delete(Config::get('constant.images_dirs.USERS').'/'.$user->user_photo);
            }
            $user->user_photo = $gen_rand.'.'.$extension;
        }

        if($user->save()){
        	$response['status'] = true;
            $response['message'] =  "Profile Successfully updated";

        }else{
            $response['status'] = false;
            $response['message'] =  "Something Wrong Please try again Later";
        }

        return response()->json($response);
 
    }

    /**
     * Used for Profile Change Password when forgot save
     * @return redirect to Admin->Profile
    */
    public function changePasswordPost(Request $request)
    {
        $response = [];
        $input = $request->all();
        if(isset($input['old_password']) && $input['old_password'] != null && !empty($input['old_password']))
        {    

            if (Hash::check($input['old_password'], Auth::user()->password)) {
                // The passwords match...
                $user = User::findorfail(Auth::user()->user_id);
                
                if(isset($input['new_password']) && $input['new_password'] != null && !empty($input['new_password']))
                {
                    $user->password = Hash::make($input['new_password']);
                }   
                if($user->save()){
                    $response['status'] = true;
                    $response['message'] ="Password updated successfully";
                    $response['redirect'] = url('/logout');

                }else{
                    $response['status'] = false;
                    $response['message'] ='Something Wrong Please try again Later';
                }
               
            }else{
                $response['status'] = false;
                $response['message'] ="Entered password is incorrect, Your password doesn't match";
            }
        }
        return response()->json($response);
    }

}
