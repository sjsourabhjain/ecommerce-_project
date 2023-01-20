<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Product;
use App\Models\UserAddresses;
use App\Models\CartDetails;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariantCombinationDetails;
use JWTAuth;
use JWTAuthException;
use App\Helpers\Helper;
use DB;

class ApiController extends Controller
{
    public function register(Request $request){
        //Validate data

        $validator = Validator::make($request->all(),[
            'mob_no'     => 'required|numeric',
            'email'  => 'nullable|string',
            //'country_code'  => 'required',
            //'mob_no'     => 'required|numeric|unique:users|digits_between:8,12',
            'password'=> 'required|string',
        ],[],[
            'email'=>'Email',
            //'country_code'=>'Country Code',
            'mob_no'=>'Mobile No.',
            'password'=>'Password'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                    'status' => false,
                    'message' => $validator->messages()->first(),
                    'data'=>[]
                ]);
        }

        try{
            $userDetails = User::where(["mob_no"=>$request->mob_no])->first();
            $otp = "1234";
            if(!empty($userDetails) && $userDetails["is_otp_verified"]==1){
                return response()->json([
                    'status' => false,
                    'message' => 'User is already registered',
                    'data'=>[]
                ]);
            }elseif(!empty($userDetails) && $userDetails["is_otp_verified"]==0){
                // update the details
                // do not register a new user
                User::where(["mob_no"=>$request->mob_no])->update([
                    'email' => $request->email,
                    'otp'=>$otp,
                    'password' => bcrypt($request->password)
                ]);

                //Helper::sendOTP($request->mob_no,$otp);

                return response()->json([
                    'status' => true,
                    'message' => 'User created successfully',
                    'data'=>[]
                ]);
            }else{
                // register a new user

                User::create([
                    'email' => $request->email,
                    'mob_no'=>$request->mob_no,
                    'otp'=>$otp,
                    'role_id'=>4,
                    'password' => bcrypt($request->password)
                ]);

                //Helper::sendOTP($request->mob_no,$otp);

                //User created, return success response
                return response()->json([
                    'status' => true,
                    'message' => 'User created successfully',
                    'data'=>[]
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data'=>[]
            ]);
        }
    }
    public function forget_password(Request $request){
        //Validate data

        $validator = Validator::make($request->all(),[
            'mob_no'     => 'required|numeric'
        ],[],[
            'mob_no'=>'Mobile No.'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }

        try{
            $userDetails = User::where(["mob_no"=>$request->mob_no])->first();
            if(empty($userDetails)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Mobile No.',
                    'data'=>[]
                ]);
            }

            $otp = "1234";
            $userDetails->otp = $otp;
            $userDetails->save();
            return response()->json([
                'status' => true,
                'message' => 'Otp sent',
                'data'=>[]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data'=>[]
            ]);
        }
    }
    public function verifyAccount(Request $request){
        //Validate data

        $validator = Validator::make($request->all(),[
            'user_id'     => 'required|numeric',
            'otp'     => 'required|numeric',
        ],[],[
            'user_id'=>'User ID',
            'otp'=>'OTP',
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                    'status' => false,
                    'message' => $validator->messages()->first(),
                    'data'=>[]
                ]);
        }

        try{
            //Request is valid, create new user
            $user_details = User::findOrFail($request->user_id);

            if($user_details->otp!=$request->otp){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP',
                    'data'=>[]
                ]);
            }

            $user_details->otp = 0;
            $user_details->status = ACTIVE;
            $user_details->save();

            //User created, return success response
            return response()->json([
                'status' => true,
                'message' => 'Your account has been verified. Please login now.',
                'data'=>[]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function verifyOtp(Request $request){
        //Validate data

        $validator = Validator::make($request->all(),[
            'mob_no'     => 'required|numeric',
            'otp'     => 'required|numeric',
            'type' => 'required|string'
        ],[],[
            'mob_no'=>'Mobile Number',
            'otp'=>'OTP',
            'type' => 'Request Type'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }

        try{
            if($request->type=="register"){

                $userQuery = User::where(["mob_no"=>$request->mob_no,"otp"=>$request->otp]);

                $userExists = $userQuery->count();

                if($userExists==1){
                    $user_details = $userQuery->first();
                    $user_details->otp = 0;
                    $user_details->is_otp_verified = 1;
                    $user_details->status = 1;
                    $user_details->save();

                    return response()->json([
                        'status' => true,
                        'message' => 'OTP is verified',
                        'data'=>[]
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid OTP',
                        'data'=>[]
                    ]);
                }
            }elseif($request->type=="forget_password"){
                $userDetails = User::where(["mob_no"=>$request->mob_no,"otp"=>$request->otp])->first();
                if(empty($userDetails)){
                    return response()->json([
                        'status' => false,
                        'message' => "Invalid Details",
                        'data'=>[]
                    ]);
                }

                $userDetails->otp = 0;
                $userDetails->password = Hash::make($request->new_password);
                $userDetails->save();
                
                return response()->json([
                    'status' => true,
                    'message' => "New password has been updated",
                    'data'=>[]
                ]);
            }else{
                //$user_details->otp = 0;
                $user_details->save();

                $token = JWTAuth::fromUser($user_details);

                //User created, return success response
                return response()->json([
                    'status' => true,
                    'message' => 'Your account has been verified. Please login now.',
                    'data'=>[]
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'mob_no'     => 'required|numeric',
            'password'  => 'required'
        ],[],[
            'mob_no'=>'Mobile No.',
            'password'=>'Password',
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                    'status' => false,
                    'message' => $validator->messages()->first(),
                    'data'=>[]
                ]);
        }

        try{
            //Request is valid, create new user
            $password = $request->password;
            $user_details = User::where(["mob_no"=>$request->mob_no])->first();
            if(empty($user_details)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Details.',
                    'data'=>[]
                ]);                  
            }
            if(!Hash::check($password,$user_details->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Details.',
                    'data'=>[]
                ]);
            }
            if($user_details["status"]==INACTIVE){
                return response()->json([
                    'status' => false,
                    'message' => 'User is Inactive. Please check with admin',
                    'data'=>[]
                ]);                
            }

            $token = JWTAuth::fromUser($user_details);
            $user_details->token = $token;
            $user_details->is_logged_in = 1;
            $user_details->save();

            //User created, return success response
            return response()->json([
                'status' => true,
                'message' => 'Login successfully.',
                'data'=>$user_details
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function sliderList(Request $request){
        try{
            $sliders = Slider::limit(3)->latest()->get();
            $slidersArr = [];
            if(!empty($sliders)){
                foreach($sliders as $slider){
                    $slidersArr[] = asset("uploads/".$slider->image_name);
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Slider images fetch successfully.',
                'data'=>["sliders"=>$slidersArr]
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }     
    }
    public function get_settings(Request $request){
        try{
            $slider_settings = Setting::where(["id"=>1])->first();
            $slidersArr = [];

            return response()->json([
                'status' => true,
                'message' => '',
                'data'=>["settings"=>[
                        "promotion_line"=>$slider_settings->promotion_line
                        ]
                    ]
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }     
    }
    public function categoryList(Request $request){
        try{
            $main_categories = Category::where(["parent_id"=>0])->latest()->get();
            $categoryArr = [];
            if(!empty($main_categories)){
                foreach($main_categories as $main_category){
                    $sub_cats = [];
                    
                    $sub_categories = Category::where(["parent_id"=>$main_category->id])->latest()->get();
                    if(!empty($sub_categories)){
                        foreach($sub_categories as $sub_category){
                            $sub_cats[] = [
                                "category_id"=>$sub_category->id,
                                "category_name"=>$sub_category->category_name
                            ];
                        }
                    }

                    $categoryArr[] = [
                        "category_id"=>$main_category->id,
                        "category_name"=>$main_category->category_name,
                        "sub_categories"=>$sub_cats
                    ];
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Category fetch successfully.',
                'data'=>$categoryArr
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }     
    }

    public function categoryImageList(Request $request){
        try{
            $categoryImageList = Category::select('category_name','category_image')->latest()->get(); 
            /*foreach ($categoryImageList as $key => $value) {
                $categoryImage[$key]['name'] = $value->category_name;
                $categoryImage[$key]['image'] = asset($value->category_image);
            }*/
            return response()->json([
                'status' => true,
                'message' => 'Category fetch successfully.',
                'data'=>$categoryImageList
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }

    public function biggestDealProduct(Request $request){
        
    }

    public function productList(Request $request){
        try{
            $products = Product::with("images","variant_combinations")->latest()->get();
            $productArr = [];
            if(!empty($products)){
                foreach($products as $product){
                    $product_image_url = "";
                    $product_price = "";
                    $variant_id = 0;
                    $variant_name = "";
                    if(!empty($product->variant_combinations)){
                        foreach($product->variant_combinations as $combination){
                            if($combination->is_primary==1){
                                if(!empty($combination->variantImages)){
                                    foreach($combination->variantImages as $variantImage){
                                        if($variantImage->is_primary==1){
                                            $product_image_url = asset("/uploads/".$variantImage->image_name);
                                        }
                                    }
                                }
                                $product_price = $combination->price;
                                $variant_id = $combination->id;
                                if(!empty($combination->combinationDetails)){
                                    $k = 0;
                                    foreach($combination->combinationDetails as $k=>$combination_detail){
                                        if($k==0){
                                            $variant_name .= $combination_detail->variant_value;
                                        }else{
                                            $variant_name .= " - " . $combination_detail->variant_value ;
                                        }
                                        $k++;
                                    }
                                }
                                break;
                            }
                        }
                    }

                    $productArr[] = [
                        "product_id"=>$product->id,
                        "product_name"=>$product->product_name,
                        "image_url"=>$product_image_url,
                        "price"=>$product_price,
                        "variant_id"=>$variant_id,
                        "variant_name"=>$variant_name
                    ];
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Product fetch successfully.',
                'data'=>["products"=>$productArr]
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }     
    }
    
    public function getProductByCategoryId(request $request){
        $validator = Validator::make($request->all(),[
            'category_id'     => 'required|numeric'
        ],[],[
            'category_id'=>'Category ID'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }

        try{
            $productQuery = Product::where("category_id","=",$request->category_id)->with("images","variants","variant_combinations")->latest();
            if(!empty($request->search_str)){
                $productQuery = $productQuery->where("product_name","like","%".$request->search_str."%");
            }
            if(!empty($request->filter_data)){
                $sql = "SELECT `product_id` FROM `product_variant_combination_details` ";
                $condition = 0;
                $filterVariantIds = [];
                foreach($request->filter_data as $k=>$filter){
                    if($filter['variant_value']!=""){
                        $filterVariantIds[$filter['variant_id']] = $filter['variant_value'];
                        if($condition==0){
                            $sql .= " WHERE `variant_id`= ".$filter['variant_id'] . " AND `variant_value`= '".$filter["variant_value"]."'";
                            $condition = 1;
                        }else{
                            $sql .= " UNION SELECT `product_id` FROM `product_variant_combination_details` WHERE `variant_id`= '".$filter['variant_id'] . "' AND `variant_value`= '".$filter["variant_value"] . "'";
                        }
                    }
                }

                $product_ids = DB::select($sql);
                $product_ids = array_unique(array_column($product_ids,"product_id"));

                $productQuery->whereIn("id",$product_ids);
            }
            
            $products = $productQuery->get();

            $productArr = [];
            $variantsArr = [];
            $variants = [];
            if(!empty($products)){
                foreach($products as $product){
                    $product_image_url = "";
                    $product_price = "";
                    $variant_name = "";
                    $variant_id = 0;
                    if(!empty($product->variants)){
                        foreach($product->variants as $product_variant){
                            if(!in_array($product_variant->variant_id,$variants)){
                                $variants[] = $product_variant->variant_id;
                                $variantsArr[$product_variant->variant_id] = [
                                    "variant_id"=>$product_variant->variant_id,
                                    "variant_name"=>$product_variant->variantDetails->name,
                                    "possible_values"=>[]
                                ];
                            }
                        }
                    }
                    if(!empty($product->variant_combinations)){
                        foreach($product->variant_combinations as $combination){
                            if($combination->is_primary==1){
                                if(!empty($combination->variantImages)){
                                    foreach($combination->variantImages as $variantImage){
                                        if($variantImage->is_primary==1){
                                            $product_image_url = asset("/uploads/".$variantImage->image_name);
                                        }
                                    }
                                }
                                $product_price = $combination->price;
                                $variant_id = $combination->id;
                                if(!empty($combination->combinationDetails)){
                                    $k = 0;
                                    foreach($combination->combinationDetails as $k=>$combination_detail){
                                        if($k==0){
                                            $variant_name .= $combination_detail->variant_value;
                                        }else{
                                            $variant_name .= " - " . $combination_detail->variant_value ;
                                        }
                                        $k++;
                                    }
                                }
                                break;
                            }
                        }
                    }
                    $productArr[] = [
                        "product_id"=>$product->id,
                        "product_name"=>$product->product_name,
                        "image_url"=>$product_image_url,
                        "price"=>$product_price,
                        "variant_id"=>$variant_id,
                        "variant_name"=>$variant_name
                    ];
                }
            }
            if(!empty($variantsArr)){
                foreach($variantsArr as $k=>$variant){
                    $pvc_details = ProductVariantCombinationDetails::where(["variant_id"=>$variant["variant_id"]])->get();
                    if(!empty($pvc_details)){
                        foreach($pvc_details as $pvc_detail){
                            $variantsArr[$k]["possible_values"][] = $pvc_detail->variant_value;
                        }
                    }
                }
            }
            $variantsArr = array_values($variantsArr);
            return response()->json([
                'status' => true,
                'message' => 'Product fetch successfully.',
                'data'=>["products"=>$productArr,"variants"=>$variantsArr]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage().ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    
    public function getProductById(request $request){
        $validator = Validator::make($request->all(),[
            'product_id'     => 'required|numeric'
        ],[],[
            'product_id'=>'Product ID'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }

        try{
            $product = Product::where(["id"=>$request->product_id])->with("images","variant_combinations")->latest()->first();
            $productArr = [];
            if(!empty($product)){
                $product_variants = [];
                $product_primary_variant_details = [];
                $primary_variant_image_gallery = [];
                if(!empty($product->variant_combinations)){
                    foreach($product->variant_combinations as $variant_combination){
                        $variant_images = [];
                        $variation_details = [];

                        if(!empty($variant_combination->variantImages)){
                            foreach($variant_combination->variantImages as $images){
                                $variant_images[] = [
                                    "imageUrl" => asset("uploads/".$images->image_name),
                                    "is_primary" => $images->is_primary
                                ];
                            }
                        }
                        if(!empty($variant_combination->combinationDetails)){
                            foreach($variant_combination->combinationDetails as $combination_detail){
                                $variation_details[] = [
                                    "variation_detail_id"=>$combination_detail->id,
                                    "variant_id"=>$combination_detail->variant_id,
                                    "variant_name"=>$combination_detail->variantDetails->name,
                                    "variant_value"=>$combination_detail->variant_value
                                ];
                            }
                        }

                        if($variant_combination->is_primary==1){
                            $product_primary_variant_details = [
                                "id"=>$variant_combination->id,
                                "price"=>$variant_combination->price,
                                "description"=>$variant_combination->description,
                                "variation_details"=>$variation_details,
                                "images"=>$variant_images
                            ];
                        }

                        $product_variants[] = [
                            "id"=>$variant_combination->id,
                            "is_primary"=>$variant_combination->is_primary,
                            "price"=>$variant_combination->price,
                            "description"=>$variant_combination->description,
                            "variation_details"=>$variation_details,
                            "variant_images"=>$variant_images
                        ];
                    }
                }

                $productArr = [
                    "product_id"=>$product->id,
                    "product_name"=>$product->product_name,
                    "product_primary_variant_details"=>$product_primary_variant_details,
                    "product_variants"=>$product_variants,
                ];
            }
            return response()->json([
                'status' => true,
                'message' => 'Product Details fetch successfully.',
                'data'=>["product_details"=>$productArr]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    
    public function userProfile(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric'
        ],[],[
            'user_id'=>'User ID'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=> []
            ]);
        }
        try{
            $data = User::where('id',$request->user_id)->first();
            return response()->json([
                'status' => true,
                'message' => 'User Details fetch successfully.',
                'data'=>$data
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function userAddresses(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric'
        ],[],[
            'user_id'=>'User ID'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=> []
            ]);
        }
        try{
            $data = UserAddresses::select(['id','title'])->where('user_id',$request->user_id)->get();
            return response()->json([
                'status' => true,
                'message' => '',
                'data'=>$data
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage().ERROR_MSG,
                'data'=>[]
            ]);
        }
        dd("hello");
    }
    public function store_user_address(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric',
            'title' => 'required',
            'name' => 'required',
            'line_one' => 'required',
            'line_two' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ],[],[
            'user_id'=>'User ID',
            'title' => 'Title',
            'name' => 'Name',
            'line_one' => 'Address Line one',
            'line_two' => 'Address Line two',
            'city' => 'city',
            'zipcode' => 'zipcode',
            'phone' => 'phone',
            'email' => 'email'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=> []
            ]);
        }
        try{
            $data = UserAddresses::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'User Address stored successfully',
                'data'=>[]
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function place_order(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric',
            'address_id' => 'required',
            'cart_details' => 'required'
        ],[],[
            'user_id'=>'User ID',
            'shipping_address' => 'Shipping Address',
            'cart_details' => 'Cart Details'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=> []
            ]);
        }
        try{
            $cart_details = json_decode($request->cart_details,true);
            $request->request->add(['total_price' => $cart_details['total']]);
            $order_details = Order::create($request->all());
            $order_id = $order_details->id;

            if(!empty($cart_details["items"])){
                foreach($cart_details["items"] as $item){
                    if(!empty($item["cartDetails"])){
                        foreach($item["cartDetails"] as $cart_item){
                            OrderDetail::create([
                                "order_id"=>$order_id,
                                "product_id"=>$item["product_id"],
                                "variant_id"=>$cart_item["variant_id"],
                                "quantity"=>$cart_item["qty"],
                                "price"=>$cart_item["total_price"]
                            ]);
                        }
                    }
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'data'=>[]
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function update_profile(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric',
            'full_name' => 'required',
            'email' => 'required',
            'mob_no' => 'required'
        ],[],[
            'user_id' => 'User ID',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'mob_no' => 'Mobile No.'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=> []
            ]);
        }
        try{
            User::where(["id"=>$request->user_id])->update([
                "full_name"=>$request->full_name,
                "email"=>$request->email
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully',
                'data'=>[]
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function store_cart_details(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id'     => 'required|numeric',
            'cart_details'     => 'required'
        ],[],[
            'user_id'=>'User ID',
            'cart_details'=>'Cart Details'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }
        try{
            $cartData = CartDetails::where(["user_id"=>$request->user_id])->first();
            if(empty($cartData)){
                CartDetails::create($request->all());
            }else{
                $cartData->cart_details = $request->cart_details;
                $cartData->save();
            }
            return response()->json([
                'status' => true,
                'message' => 'Cart Data saved successfully',
                'data'=>[]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function product_search(Request $request){
        $validator = Validator::make($request->all(),[
            'search_str'     => 'required'
        ],[],[
            'search_str'=>'Search string'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }
        try{
            $products = Product::select(["id","product_name"])->where("product_name","like","%".$request->search_str."%")->latest()->get();

            return response()->json([
                'status' => true,
                'message' => '',
                'data'=>$products
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function get_related_products(Request $request){
        $validator = Validator::make($request->all(),[
            'product_id'     => 'required'
        ],[],[
            'product_id'=>'Product ID'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }
        try{
            $productDetails = Product::where(["id"=>$request->product_id])->first();
            $cat_id = $productDetails->category_id;
            $relatedProducts = Product::where("category_id","=",$cat_id)->where("id","<>",$request->product_id)->latest()->get();
            $productArr = [];
            if(!empty($relatedProducts)){
                foreach($relatedProducts as $product){
                    $product_image_url = "";
                    $product_price = "";
                    $variant_id = 0;
                    $variant_name = "";
                    if(!empty($product->variant_combinations)){
                        foreach($product->variant_combinations as $combination){
                            if($combination->is_primary==1){
                                if(!empty($combination->variantImages)){
                                    foreach($combination->variantImages as $variantImage){
                                        if($variantImage->is_primary==1){
                                            $product_image_url = asset("/uploads/".$variantImage->image_name);
                                        }
                                    }
                                }
                                $product_price = $combination->price;
                                $variant_id = $combination->id;
                                if(!empty($combination->combinationDetails)){
                                    $k = 0;
                                    foreach($combination->combinationDetails as $k=>$combination_detail){
                                        if($k==0){
                                            $variant_name .= $combination_detail->variant_value;
                                        }else{
                                            $variant_name .= " - " . $combination_detail->variant_value ;
                                        }
                                        $k++;
                                    }
                                }
                                break;
                            }
                        }
                    }

                    $productArr[] = [
                        "product_id"=>$product->id,
                        "product_name"=>$product->product_name,
                        "image_url"=>$product_image_url,
                        "price"=>$product_price,
                        "variant_id"=>$variant_id,
                        "variant_name"=>$variant_name
                    ];
                }
            }
            return response()->json([
                'status' => true,
                'message' => '',
                'data'=>$productArr
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
    public function get_product_filters(Request $request){

        $validator = Validator::make($request->all(),[
            'category_id'     => 'required'
        ],[],[
            'category_id'=>'Category ID'
        ]);

        //Send failed response if request is not valid
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
                'data'=>[]
            ]);
        }
        try{
            return response()->json([
                'status' => true,
                'message' => 'filter listing successful',
                'data'=>[]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => ERROR_MSG,
                'data'=>[]
            ]);
        }
    }
}
?>