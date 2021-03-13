<?php
namespace App\Http\Controllers;
use App\Models\categorys;
use Illuminate\Http\Request;
use App\Repositories\categorysRepositories;
use Image;
use Illuminate\Support\Facades\File;
use DB;

class CategorysController extends Controller
{
    public function __construct(categorysRepositories $categorysRepositories){
		$this->categorysRepositories=$categorysRepositories;
	}

     public function index(){
     	$category= $this->categorysRepositories->getAll();
     	return response()->json([
     		'success'=>true,
     		'message'=>'Band List',
     		'data'=>$category,
     	],201);

     }

     public function show($id){
			$category = $this->categorysRepositories->findbyId($id);
			if(is_null($category)){
				return response()->json([
						'success'=>false,
						'message'=>'No data found',
						'date'=>null,
					],400);
			}else{
				return response()->json([
						'success'=>true,
						'message'=>'Searching Data',
						'date'=>$category,
					],201);
			}

		}
	public function store(Request $request){
		$formData = $request->all();
		$validator= \Validator::make($formData,[
			'category_name'=> 'required',
			'category_image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
		]);
		if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
            ]);
        }
        $img='';
		if ($request->hasFile('category_image')) {
			$image = $request->file('category_image');
    	    $img = time() . '.'. $image->getClientOriginalExtension();
			$location = public_path('images/categorys/' .$img);
			Image::make($image)->save($location);

		}
		$data_store=$this->categorysRepositories->create($request,$img);
		return response()->json([
			'success'=>true,
			'message'=>'Brand Save',
			'data'=>$data_store,
		],201);
	}

	public function update(Request $request, $id)
    {
    	$formData=$request->all();
        $category = $this->categorysRepositories->findbyId($id);
        if (is_null($brand)) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found',
                'data' => null,
            ]);
        }

        $validator= \Validator::make($formData,[
			'category_name'=> 'required',
			'category_image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
			'old_image_path'=> 'required',
		]);
		if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
            ]);
        }
        

		$image_path = public_path('images/categorys/' .$request->old_image_path);
    	if (File::exists($image_path)) {
        	unlink($image_path);
    	}

      	$img='';
		if ($request->hasFile('category_image')) {
			$image = $request->file('category_image');
    	    $img = time() . '.'. $image->getClientOriginalExtension();
			$location = public_path('images/categorys/' .$img);
			Image::make($image)->save($location);

		}
        $category = $this->categorysRepositories->edit($request, $id,$img);
        return response()->json([
            'success' => true,
            'message' => 'Project Updated',
            'data'    => $category
        ]);
    }
    public function destroy($id)
    {
    	$category = $this->categorysRepositories->findbyId($id);
        if (is_null($category)) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found',
                'data' => null,
            ]);
        }
        
        $image = DB::table('categorys')->where('id', $id)->value('category_image');
        $image_path = public_path('images/categorys/' .$image);
    	if (File::exists($image_path)) {
        	unlink($image_path);
    	}

        $project = $this->categorysRepositories->destory($id);
        return response()->json([
                'success' => true,
                'message' => 'Brand Delete'
            ]);

    }
}
