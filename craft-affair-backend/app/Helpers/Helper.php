<?php
namespace App\Helpers;
use Mail;
use App\Models\User;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Product;
use App\Models\Order;

class Helper{

	public static function str_random(){
	    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

	    $length = 64;
	    $token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
	    return $token;
	}
	public static function generateOTP($length){
		$string		=	'0123456789';
		$strShuffled=	str_shuffle($string);
		$otp		=	substr($strShuffled, 1, $length);
		return $otp;
	}
	public static function createUserReferal($length){
		$string		=	'0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ9630125478abcdefghijklmnopqrstuvwxyz9876543210';
		$strShuffled=	str_shuffle($string);
		$referCode	=	substr($strShuffled, 1, $length);
		return $referCode;
	}
	public static function get_tot_users(){
		return User::where(["role_id"=>4])->count();
	}
	public static function get_tot_sub_admins(){
		return User::where(["role_id"=>2])->count();
	}
	public static function get_tot_category(){
		return Category::count();
	}
	public static function get_tot_variant(){
		return Variant::count();
	}
	public static function get_tot_product(){
		return Product::count();
	}
	public static function get_tot_order(){
		return Order::count();
	}
	public static function pr($arr = []){
		echo "<pre>"; print_r($arr); echo "</pre>";
	}
	public static function sendOTP($mob_no,$otp){

		$curl = curl_init();

		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=".env("FAST_SMS_API_KEY")."&variables_values=".$otp."&route=otp&numbers=".urlencode($mob_no),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => ["cache-control: no-cache"],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		/*if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}*/
	}
}
?>