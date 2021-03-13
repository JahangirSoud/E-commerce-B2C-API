<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubcategorysController extends Controller
{
    public function __construct(subcategorysRepositories $subcategorysRepositories){
		$this->subcategorysRepositories=$subcategorysRepositories;
	}

     public function index(){
     	$subcategory= $this->subcategorysRepositories->getAll();
     	return response()->json([
     		'success'=>true,
     		'message'=>'Band List',
     		'data'=>$subcategory,
     	],201);

     }

     public function show($id){
			$subcategory = $this->subcategorysRepositories->findbyId($id);
			if(is_null($subcategory)){
				return response()->json([
						'success'=>false,
						'message'=>'No data found',
						'date'=>null,
					],400);
			}else{
				return response()->json([
						'success'=>true,
						'message'=>'Searching Data',
						'date'=>$subcategory,
					],201);
			}

		}
	public function store(Request $request){
		$formData = $request->all();
		$validator= \Validator::make($formData,[
			'subcategory_name'=> 'required',
            'category_id'=> 'required',
			'subcategory_image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
		]);
		if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
            ]);
        }
        $img='';
		if ($request->hasFile('subcategory_image')) {
			$image = $request->file('subcategory_image');
    	    $img = time() . '.'. $image->getClientOriginalExtension();
			$location = public_path('images/subcategorys/' .$img);
			Image::make($image)->save($location);

		}
		$data_store=$this->subcategorysRepositories->create($request,$img);
		return response()->json([
			'success'=>true,
			'message'=>'Brand Save',
			'data'=>$data_store,
		],201);
	}

	public function update(Request $request, $id)
    {
    	$formData=$request->all();
        $subcategory = $this->subcategorysRepositories->findbyId($id);
        if (is_null($brand)) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found',
                'data' => null,
            ]);
        }

        $validator= \Validator::make($formData,[
			'subcategory_name'=> 'required',
            'category_id'=> 'required',
			'subcategory_image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
			'old_image_path'=> 'required',
		]);
		if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
            ]);
        }
        

		$image_path = public_path('images/subcategorys/' .$request->old_image_path);
    	if (File::exists($image_path)) {
        	unlink($image_path);
    	}

      	$img='';
		if ($request->hasFile('subcategory_image')) {
			$image = $request->file('subcategory_image');
    	    $img = time() . '.'. $image->getClientOriginalExtension();
			$location = public_path('images/subcategorys/' .$img);
			Image::make($image)->save($location);

		}
        $subcategory = $this->subcategorysRepositories->edit($request, $id,$img);
        return response()->json([
            'success' => true,
            'message' => 'Project Updated',
            'data'    => $subcategory
        ]);
    }
    public function destroy($id)
    {
    	$subcategory = $this->subcategorysRepositories->findbyId($id);
        if (is_null($subcategory)) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found',
                'data' => null,
            ]);
        }
        
        $image = DB::table('subcategorys')->where('id', $id)->value('subcategory_image');
        $image_path = public_path('images/subcategorys/' .$image);
    	if (File::exists($image_path)) {
        	unlink($image_path);
    	}

        $subcategory = $this->subcategorysRepositories->destory($id);
        return response()->json([
                'success' => true,
                'message' => 'Brand Delete'
            ]);

    }
}
