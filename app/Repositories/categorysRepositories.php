<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\categorys;
	class categorysRepositories{

		public function getAll(){
			$category=categorys::all();
			return $category;
		}
		
		public function findbyId($id){
			$category = categorys::find($id);
			return $category;
		}

		public function create(Request $request,$img){
			$category = new categorys();
			$category->category_name=$request->category_name;
			$category->category_image=$img;
			$category->save();
			return $category;
		}
		public function edit(Request $request, $id,$img)
    	{
	        $category = $this->findbyId($id);
	        $category->category_name=$request->category_name;
			$category->category_image=$img;
			$category->save();
			return $category;
    	}
    	public function destory($id)
    	{
	        $category = $this->findbyId($id);
	        $category->delete();
			return $category;
    	}
	}
?>