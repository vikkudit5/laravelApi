<?php

namespace App\Http\Controllers;



use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Response;
use App\UserSignUp;
use App\Image;

class UserController extends Controller
{
    //

    public function getAuthUser(Request $request)
    {
    	dd('working');
    }

    public function postImage(Request $request)
    {


    	try
    	{
    		  $description = $request->description;//for description
                $name = $request->name;//for name
                $car = $request->car;//for car
                $data = $request->image;
                $data1 = explode(",",$data);
                $data2 = explode(";", $data1[0]);
                $data3 = explode("/", $data2[0]);
                
                $data = str_replace($data1[0], '', $data1[1]);

                $data = str_replace(' ', '+', $data);

                $data = base64_decode($data);
                

                $file = public_path().'/images/'.rand() . '.'.$data3[1];

                $success = file_put_contents($file, $data);
                $input = array(
                        'image'=>$file,
                        'name'=>$name,
                        'car'=>$car,
                        'description'=>$description
                    );
 

                if($success)
                {
                    $insert = Image::create($input);
                   
                     return Response::json(['data'=> $insert,'status'=>200]);
                }

               






           
           

            // $this->validate($request, [
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            // ]);

             // $photoTemp = base64_decode($request->image);
             // $safeName = $photoTemp.'.'.'png';

    	  // $imageName = time().'.'.$safeName->getClientOriginalExtension();
    	  // $request->image->move(public_path('images'), $imageName);

    	 // return Response::json(['data' => $imageName,'error'=> false ,'message' => 'Upload Successfully','status' => 200 ]);

    	}catch(Exception $e){

    		return Response::json(['error'=> false ,'message' => 'Upload Not Successfully','status' => 500 ]);
    	 
    	}
    	 
    }

    public function fetchData()
    {
        $allData = Image::get();
        return Response::json(['data'=> $allData,'status'=>200]);
    }
}
