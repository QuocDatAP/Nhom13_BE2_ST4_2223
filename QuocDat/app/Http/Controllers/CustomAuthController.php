<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

//Unknow
class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $email = $request->get('email');
        $data = $request->all();
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            //            'name' => 'required',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        //upload
        $file = $request->file('fileToUpload');
        $fileName = $file->getClientOriginalName();
        $destinationPath = 'uploads';
        $file->move($destinationPath, $file->getClientOriginalName());

        $data['fileName'] = $fileName;
        $check = $this->create($data);

        return redirect("login")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'image' => $data['fileName'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function dashboard()
    {      
        if (Auth::check()) {
            return view('dashboard');
        }            
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
    public function user(){
        $data = User::orderBy('id','DESC')->paginate(2);
        return view('auth.user',compact('data'))->with('i',(request()->input('page',1)-1)*2);
    }
}