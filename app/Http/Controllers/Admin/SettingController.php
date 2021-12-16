<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\FrontHelper;
use App\Models\Setting;
use Config;
use Settings;

class SettingController extends Controller
{
    /**
	 * Used for Admin Setting
	 * @return redirect to Admin->Setting
	 */

	public function index(Request $request)
    {
        if (request()->ajax()) {
            return \View::make('admin.setting.index')->renderSections();
        }
    	return view('admin.setting.index');
    }

    /*
    * Add And Update settings data
    */
    public function updateSetting(Request $request)
    {
        $input = $request->all();
        $data = $this->checkUploadFile($request);
        foreach ($input as $key => $value) {
            if(array_key_exists($key, $data)){
                $input[$key] = $data[$key];
            }
        }
        if (Settings::set($input)) {
            $response['status'] = true;
            $response['message'] = "Settings Successfully Updated";
        }else{
            $response['status'] = false;
            $response['message'] = "Something Went Wrong!";
        }
        return response()->json($response);
    }

    /*
    * Check And Upload Setting images
    */
    public function checkUploadFile($request)
    {
        $data = [];
        $input = $request->all();
        $bannerImage = [];
        foreach ($input as $key => $value) {
            if($request->hasFile($key)){
                $isResize = false;
                $resizeValue = [];
                if (in_array($key, $bannerImage)) {
                    $isResize = true;
                    $resizeValue = [1400=>470];
                }
                $fileName = $key;
                $img_dir = Config::get('constant.images_dirs.SETTING');
                $preImage = Settings::get($key);
                
                $data[$fileName] =  FrontHelper::singleImage($request,$fileName,$img_dir,$isResize,$resizeValue,$preImage);
            }
        }
        /*END*/
        return $data;
    }
	

}
