<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\subcategorys;
	class subcategorysRepositories{

		public function getAll(){
			$subcategory=subcategorys::all();
			return $category;
		}
		
		public function findbyId($id){
			$subcategory = subcategorys::find($id);
			return $subcategorys;
		}

		public function create(Request $request,$img){
			$subcategory = new categorys();
			$subcategory->subcategory_name=$request->subcategory_name;
			$subcategory->subcategory_image=$img;
            $subcategory->category_id=$request->category_id;
			$subcategory->save();
			return $subcategory;
		}
		public function edit(Request $request, $id,$img)
    	{
	        $subcategory = $this->findbyId($id);
	        $subcategory->subcategory_name=$request->subcategory_name;
			$subcategory->subcategory_image=$img;
            $subcategory->category_id=$request->category_id;
			$subcategory->save();
			return $subcategory;
    	}
    	public function destory($id)
    	{
	        $subcategory = $this->findbyId($id);
	        $subcategory->delete();
			return $subcategory;
    	}
	}
?>