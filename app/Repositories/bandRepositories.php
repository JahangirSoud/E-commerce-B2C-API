<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\brand;
	class bandRepositories{

		public function getAll(){
			$brand=brand::all();
			return $brand;
		}
		
		public function findbyId($id){
			$brand = brand::find($id);
			return $brand;
		}

		public function create(Request $request,$img){
			$brand = new brand();
			$brand->brand_name=$request->brand_name;
			$brand->description=$request->description;
			$brand->brand_image=$img;
			$brand->save();
			return $brand;
		}
		public function edit(Request $request, $id,$img)
    	{
	        $brand = $this->findbyId($id);
	        $brand->brand_name=$request->brand_name;
			$brand->description=$request->description;
			$brand->brand_image=$img;
			$brand->save();
			return $brand;
    	}
    	public function destory($id)
    	{
	        $brand = $this->findbyId($id);
	        $brand->delete();
			return $brand;
    	}
	}
?>