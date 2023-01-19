<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Slider;

class SliderController extends Controller
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
            $data["sliders"] = Slider::latest()->get();
            return view('admin.sliders.list_sliders',$data);
        }catch(\Exception $e){
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
            return view('admin.sliders.add_sliders');
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
            'slider_image'     => 'required|image'
        ],[],[
            'slider_image'=>'Image',
        ]);

        try{
            $slider_image = '';

            if($request->hasFile('slider_image')){
                $file = $request->file('slider_image');
                $originalname = $file->getClientOriginalName();
                $file_name = time()."_".$originalname;
                $file->move('uploads/sliders/',$file_name);
                $slider_image = "sliders/".$file_name;
            }

            $request->request->add(['image_name' => $slider_image]);

            Slider::create($request->all());
            return redirect()->route('admin.list_slider')->with('success','Slider Added Successfully.');
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
            $data["slider_details"] = Slider::where(["id"=>$id])->first();
            return view('admin.sliders.show_sliders',$data);
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
            $data["slider_details"] = Slider::where(["id"=>$id])->first();
            return view('admin.sliders.edit_sliders',$data);
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
            'slider_image'     => 'required|image'
        ],[],[
            'slider_image'=>'Image',
        ]);

        try{

            $slider_image = '';

            if($request->hasFile('slider_image')){
                $file = $request->file('slider_image');
                $originalname = $file->getClientOriginalName();
                $file_name = time()."_".$originalname;
                $file->move('uploads/sliders/',$file_name);
                $slider_image = "sliders/".$file_name;
                $update_arr["image_name"] = $slider_image;
            }

            $request->request->add(['image_name' => $slider_image]);

            Slider::where(["id"=>$request->update_id])->update($update_arr);
            return redirect()->route('admin.list_slider')->with('success','Slider Updated Successfully.');
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
            $sliderQuery = Slider::where(["id"=>$id]);
            $sliderData = $sliderQuery->first();
            $sliderQuery->delete();

            unlink(public_path()."/uploads/".$sliderData["image_name"]);

            return redirect()->route('admin.list_slider')->with('success','Slider Deleted Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }

    public function update_slider_status($id){
        try{
            $slider_details = Slider::where(["id"=>$id])->first();
            if($slider_details->status==INACTIVE){
                $activeSliderCount = Slider::where(["status"=>1])->count();
                if($activeSliderCount==3){
                    return redirect()->route('admin.list_slider')->with('error','There can not be more than 3 active sliders.');
                }
            }

            $status = ($slider_details->status==INACTIVE) ? ACTIVE : INACTIVE;

            $slider_details->status = $status;
            $slider_details->save();
            return redirect()->route('admin.list_slider')->with('success','Slider Status Updated Successfully.');
        }catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error',ERROR_MSG);
        }
    }
    public function prepare_list_sliders(Request $request){
        try{

        }catch(\Exception $e){

        }
    }
}
?>