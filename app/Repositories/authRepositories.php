<?php 
namespace App\Repositories;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class authRepositories{
    public function checkIfAuthenticated(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return true;
        }
        return false;
    }
    public function findUserByEmailAddress($email){
        $user = User::where( 'email',$email)->first();
        return $user;
    }
    public function createUser($request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $user;
    }
}

?>