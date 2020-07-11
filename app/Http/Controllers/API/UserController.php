<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{

    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function employee($id=null){
        if($id==null){
            $response = $this->callEmployeeAPI("GET", "http://dummy.restapiexample.com/api/v1/employees", false);
            return $response;
        }
        else{
            $response = $this->callEmployeeAPI("GET", "http://dummy.restapiexample.com/api/v1/employee/".$id, false);
            return $response;
        }
    }

    public function createEmployee(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'salary' => 'required',
            'age' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();

        $data = json_encode(array("name"=>$input['name'],"salary"=>$input['salary'],"age"=>$input['age']));
        $response = $this->callEmployeeAPI("POST", "http://dummy.restapiexample.com/api/v1/create", $data);
        return $response;
    }

    public function updateEmployee(Request $request, $id=null){
        if($id!=null){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'salary' => 'required',
                'age' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }

            $input = $request->all();

            $data = json_encode(array("name"=>$input['name'],"salary"=>$input['salary'],"age"=>$input['age']));
            $response = $this->callEmployeeAPI("PUT", "http://dummy.restapiexample.com/api/v1/update/".$id, $data);
            return $response;
        }
        else{
            return response()->json(['error'=>'expected parameter id'], 401);
        }
    }

    public function deleteEmployee($id=null){
        $response = $this->callEmployeeAPI("DELETE", "http://dummy.restapiexample.com/api/v1/delete/".$id, "");
        return $response;
    }

    public function callEmployeeAPI($method, $url, $data){
        if(!isset($_COOKIE['phpsessid'])) {
            $cookie_session = $this->get_session_cookies();
            setcookie('phpsessid', $cookie_session, time() + (2* 86400 * 30), "/");
        } else {
           $cookie_session = $_COOKIE['phpsessid'];
        }
        // var_dump($cookie_session);
        $curl = curl_init();
        switch ($method){
            case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
            case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
            case "DELETE":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
            default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           "Content-Type" => "application/json",
           "Access-Control-Allow-Origin" => "*",
           "Cookie: PHPSESSID=".$cookie_session.";"
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        $result = curl_exec($curl);

        if(!$result){die("Connection Failure");}
        curl_close($curl);

        return $result;
     }

     public function get_session_cookies(){
        $ch = curl_init("http://dummy.restapiexample.com/api/v1/employees");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
 
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        curl_close($ch);

        return $cookies['PHPSESSID'];
     }

}