<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Offer;
use Hash;

class OfferController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }
    public function index(Request $request){
        try{
            $data["offers"] = Offer::latest()->get();
            return view('admin.offer.list_offer',$data);
        }catch(\Exception $e){
            echo $e->getMessage(); die;
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('admin.offer.add_offer');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = $request->validate([
            'coupon_code'     => 'required|string|max:250',
            'discount_value'     => 'required|string|max:250',
        ]);

        try{
            if(Offer::create($request->all())){
                return redirect()->route('admin.list_offer')->with('success','Offer Added Successfully.');
            }else{
                return redirect()->route('admin.list_offer')->with('error','Offer not added');
            }
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data["Offer_details"] = Offer::where(["id"=>$id])->first();
            return view('admin.offer.show_offer',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data["Offer_details"] = Offer::where(["id"=>$id])->first();
            
            if(empty($data["Offer_details"])){
                return redirect()->route('admin.dashboard')->with('error',UNAUTHORIZED_ACCESS);
            }
            return view('admin.offer.edit_Offer',$data);
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = $request->validate([
            'title'     => 'required|string|max:250',
            'url'     => 'required|string|max:250',
            'image'  => 'nullable|image',
        ]);

        try{

            $ad_image = '';
            if($request->hasFile('ad_image')){
                $file = $request->file('ad_image');
                $originalname = $file->getClientOriginalName();
                $file_name = time()."_".$originalname;
                $file->move('uploOffer/offer/',$file_name);
                $ad_image = "offer/".$file_name;

                $update_arr["image"] = $ad_image;
            }

            $update_arr["title"] = $request->title;
            $update_arr["url"] = $request->url;

            $user_details = Offer::where(["id"=>$request->update_id])->update($update_arr);
            return redirect()->route('admin.list_Offer')->with('success','Offer Updated Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try{
            Offer::where(["id"=>$id])->delete();
            return redirect()->route('admin.list_Offer')->with('success','Offer Deleted Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
}
?>