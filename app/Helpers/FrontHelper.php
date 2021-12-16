<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailSmsMaster;
use App\Mail\sendEmail;
use App\Models\User;
use App\Models\Query;
use File;
use Image;
use Settings;
use Config;

class FrontHelper {

   public static function generatePassword($length = 8, $add_dashes = false, $available_sets = 'luds')
   {
      $sets = array();
      if (strpos($available_sets, 'l') !== false)
         $sets[] = 'abcdefghjkmnpqrstuvwxyz';
      if (strpos($available_sets, 'u') !== false)
         $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
      if (strpos($available_sets, 'd') !== false)
         $sets[] = '23456789';
      if (strpos($available_sets, 's') !== false)
         $sets[] = '!@#$%&*?';
      $all = '';
      $password = '';
      foreach ($sets as $set) {
         $password .= $set[array_rand(str_split($set))];
         $all .= $set;
      }
      $all = str_split($all);
      for ($i = 0; $i < $length - count($sets); $i++)
         $password .= $all[array_rand($all)];
      $password = str_shuffle($password);
      if (!$add_dashes)
         return $password;
      $dash_len = floor(sqrt($length));
      $dash_str = '';
      while (strlen($password) > $dash_len) {
         $dash_str .= substr($password, 0, $dash_len) . '-';
         $password = substr($password, $dash_len);
      }
      $dash_str .= $password;
      return $dash_str;
   }

   public static function singleImage($request,$fileName,$img_dir,bool $isResize=false,array $resizeValue=[],string $preImage='')
   {  
      if ($preImage) 
      {
         Storage::disk('public')->delete($preImage);
      }
      $gen_rand = rand(100,999).time();
      $image_path = $request->file($fileName);
      $extension = $image_path->getClientOriginalExtension();
      $image = $img_dir.'/'.$gen_rand.'.'.$extension;
      Storage::disk('public')->put($image,  File::get($image_path));

      if ($isResize && !empty($resizeValue)) 
      {
         foreach ($resizeValue as $key=>$value) 
         {
            
            $source = Storage::disk('public')->get($image);
            Storage::disk('public')->makeDirectory('thumbnail/'.$key.'x'.$value.'/'.$img_dir);
            $target = public_path('uploads/thumbnail/'.$key.'x'.$value.'/'.$image);
            Image::make($source)->resize($key,$value)->save($target);
            
            if ($preImage) {
               Storage::disk('public')->delete('thumbnail/'.$key.'x'.$value.'/'.$preImage);
            }

         }
      }
      return $image;
   }

   public static function multipleImage($request,$fileName,$img_dir,bool $isResize=false,array $resizeValue=[],string $preImage='')
   {  
      if ($preImage) 
      {
         Storage::disk('public')->delete($preImage);
      }
      $gen_rand = rand(100,999).time();
      $image_path = $request->file($fileName);
      $extension = $image_path->getClientOriginalExtension();
      $image = $img_dir.'/'.$gen_rand.'.'.$extension;
      Storage::disk('public')->put($image,  File::get($image_path));

      if ($isResize && !empty($resizeValue)) 
      {
         foreach ($resizeValue as $key=>$value) 
         {
            
            $source = Storage::disk('public')->get($image);
            Storage::disk('public')->makeDirectory('thumbnail/'.$key.'x'.$value.'/'.$img_dir);
            $target = public_path('uploads/thumbnail/'.$key.'x'.$value.'/'.$image);
            Image::make($source)->resize($key,$value)->save($target);
            
            if ($preImage) {
               Storage::disk('public')->delete('thumbnail/'.$key.'x'.$value.'/'.$preImage);
            }

         }
      }
      return $image;
   }

   public static function getListing($data,$tableObj)
   {
       
      $perpage = !empty( $data[ 'length' ] ) ? (int)$data[ 'length' ] : 10;
       
      $sort_type = isset( $data['order'][0]['dir'] ) && is_string( $data['order'][0]['dir'] ) ? $data['order'][0]['dir'] : '';  

      $sort_col =  isset($data['order'][0]['column']) ? $data['order'][0]['column'] :'';

      $sort_field = isset($data['columns'][$sort_col]['data']) ? $data['columns'][$sort_col]['data'] :'';

      $aTable = $tableObj;

      $aTableQuery = $aTable;

      if($sort_col != 0)
      {
         $aTableQuery = $aTableQuery->orderBy($sort_field, $sort_type);
      }
      else
      {
         $aTableQuery = $aTableQuery->orderBy('created_at', 'DESC');
      }

      $total_table_data= $aTableQuery->count();

      $offset = isset($data['start']) ? $data['start'] :'';
        
      $counter = $offset;
      $aTabledata = [];
      $aTables = $aTableQuery->offset($offset)->limit($perpage)->get()->toArray();
        
      foreach ($aTables as $key => $value) 
      {
         $value['index'] = $counter+1;
         $value['createdat'] = date('d-M-Y',strtotime($value['created_at']));
         $aTabledata[$counter] = $value;
         $counter++;
      }
         
      $price = array_column($aTabledata, 'index');

      if($sort_col == 0){
         if($sort_type == 'desc'){
            array_multisort($price, SORT_DESC, $aTabledata);
         }else{
            array_multisort($price, SORT_ASC, $aTabledata);
         }
      }  

      $result = array(
         "draw" => $data['draw'],
         "recordsTotal" =>$total_table_data,
         "recordsFiltered" => $total_table_data,
         'data' => $aTabledata,
      );
      return $result;
   }

   /*
   * Chnage status 
   */
   public static function status($cid,$tableObj)
   {
      if(empty($cid)){
            $response['status'] = false;
      }else{
         $data = $tableObj->where('id',$cid)->first();
         $data->status = $data->status == 1 ? 2 : 1;
         if ($data->update()) {
             $response['status'] = true;
             $response['message'] = "Status Successfully changed";
         }else{
             $response['status'] = false;
         }
      }
      return $response;
   }


   /*
    * Send Password Email
   */
   public static function sendEmail($email,array $aData,$key)
   {
     $data = EmailSmsMaster::where('email_sms_key', $key)->first();

     if (isset($data) && !empty($data)) {
         $data = $data->toArray();      
         
         $message = $data['content'];

         $subject = $data['subject'];
         
         foreach ($aData as $kii => $val) {
            $message = str_replace("{{".$kii."}}", $val, $message);
         }
         
         Mail::to($email)->send(new sendEmail($message,$subject));        
     }
     return true;
   }

   /*
    * find hotel address 
   */
   public static function hotelAddress($data,$type=false)
   {
     $address = '';
     
     if ($data!=null && $type) {
         $address = $data->city.', '.$data->country.', '.$data->zipcode;
     }
     elseif($data!=null){
         $address = $data->address1.' '.$data->address2.', '.$data->city.', '.$data->country;
     }
     return $address;
   }

   /*
    * Save query
   */
   public static function generateQuery($request)
   {
      $aData = [];
      
      DB::beginTransaction();
      $checkinout = '';
      if ($request->checkinout) {
         $checkinout = explode(" > ",$request->checkinout);
      }
      $add = new Query;
      $add->fname = $request->fname;
      $add->lname = $request->lname;
      $add->email = $request->email;
      $add->phone = $request->phone;
      if ($request->type==2) {
         $add->checkin = $checkinout ? date("Y-m-d",strtotime($checkinout[0])) : null;
         $add->checkout = $checkinout ? date("Y-m-d",strtotime($checkinout[1])) : null;
      }
      if ($request->type==3) {
         $add->pickdate = date("Y-m-d",strtotime($request->pickupdate));
         $add->picktime = date("H:i",strtotime($request->pickuptime));
         $add->pickaddress = $request->pickaddress;
         $add->dropaddress = $request->dropaddress;
      }

      $add->adult = $request->adult;
      $add->child = $request->child;
      $add->hotel_id = $request->hotel_id;
      $add->type = $request->type;
      $add->message = $request->message;
      $add->status = 1;
      $add->save();
      if ($add) {
         DB::commit();
         $key='email_to_admin_send_query';
         $email = Settings::get('general_setting_email');
         $aData['NAME'] = $add->fname.' '.$add->lname;
         $aData['EMAIL'] = $add->email;
         $aData['PHONE'] = $add->phone;
         $aData['TYPE'] = Config::get('constant.query_type')[$add->type];
         FrontHelper::sendEmail($email,$aData,$key);
         return true;
      }
      else{
         DB::rollback();
         return false;
      }
   }

}

?>