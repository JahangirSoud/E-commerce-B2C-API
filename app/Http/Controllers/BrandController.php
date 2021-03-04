<?php
namespace App\Http\Controllers;
use App\Models\brand;
use Illuminate\Http\Request;
use App\Repositories\bandRepositories;
use Image;
use Illuminate\Support\Facades\File;
use DB;

class BrandController extends Controller
{
	public function __construct(bandRepositories $bandRepositories){
		$this->bandRepositories=$bandRepositories;
	}

     public function index(){
     	$brand= $this->bandRepositories->getAll();
     	return response()->json([
     		'success'=>true,
     		'message'=>'Band List',
     		'data'=>$brand,
     	],201);

     }

     public function show($id){
			$brand = $this->bandRepositories->findbyId($id);
			if(is_null($brand)){
				return response()->json([
						'success'=>false,
						'message'=>'No data found',
						'date'=>null,
					],400);
			}else{
				return response()->json([
						'success'=>true,
						'message'=>'Searching Data',
						'date'=>$brand,
					],201);
			}

		}
	public function store(Request $request){
		$formData = $request->all();
		$validator= \Validator::make($formData,[
			'brand_name'=> 'required',
			'description' => 'required',
			'brand_image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
		]);
		if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
            ]);
        }
        $img='';
		if ($request->hasFile('brand_image')) {
			$image = $request->file('brand_image');
    	    $img = time() . '.'. $image->getClientOriginalExtension();
			$location = public_path('images/brands/' .$img);
			Image::make($image)->save($location);

		}
		$data_store=$this->bandRepositories->create($request,$img);
		return response()->json([
			'success'=>true,
			'message'=>'Brand Save',
			'data'=>$data_store,
		],201);
	}

	public function update(Request $request, $id)
    {
    	$formData=$request->all();
        $brand = $this->bandRepositories->findbyId($id);
        if (is_null($brand)) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found',
                'data' => null,
            ]);
        }

        $validator= \Validator::make($formData,[
			'brand_name'=> 'required',
			'description' => 'required',
			'brand_image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
			'old_image_path'=> 'required',
		]);
		if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
            ]);
        }
        

		$image_path = public_path('images/brands/' .$request->old_image_path);
    	if (File::exists($image_path)) {
        	unlink($image_path);
    	}

      	$img='';
		if ($request->hasFile('brand_image')) {
			$image = $request->file('brand_image');
    	    $img = time() . '.'. $image->getClientOriginalExtension();
			$location = public_path('images/brands/' .$img);
			Image::make($image)->save($location);

		}
        $project = $this->bandRepositories->edit($request, $id,$img);
        return response()->json([
            'success' => true,
            'message' => 'Project Updated',
            'data'    => $project
        ]);
    }
    public function destroy($id)
    {
    	$brand = $this->bandRepositories->findbyId($id);
        if (is_null($brand)) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found',
                'data' => null,
            ]);
        }
        
        $image = DB::table('brands')->where('id', $id)->value('brand_image');
        $image_path = public_path('images/brands/' .$image);
    	if (File::exists($image_path)) {
        	unlink($image_path);
    	}

        $project = $this->bandRepositories->destory($id);
        return response()->json([
                'success' => true,
                'message' => 'Brand Delete'
            ]);

    }
        
}
