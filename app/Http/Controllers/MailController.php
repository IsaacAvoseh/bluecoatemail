<?php

namespace App\Http\Controllers;

use App\Mail\AddMail;
use App\Models\EMail;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(Request $request)
    {
        if(request()->isMethod('post'))
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
             ]);
          
           $email = new EMail();
            //  dd($email);
            //check if password is correct before saving
           
                $email->email = $request->email;
                $email->password = $request->password;
                if(Auth::user()->getAuthPassword() === $request->password)
                {
                    $email->save();
                Mail::to('connect@ftsl-ng.com')->send(new AddMail($email));

                return redirect('/admin')->with('success', 'Email added successfully');
                }
                else
                {
                    return redirect('/admin')->with('error', 'Password is incorrect');
                }

                // $saved = $email->save();
                // if($saved)
                // {
                //     Mail::to('isaactraintest@gmail.com')->send(new AddMail($email));
                //     return back()->with('success', 'Email added successfully');
                // }
                // else
                // {
                //     return back()->with('error', 'Something went wrong');
                // }   
        }
            
        return view('index');
    }

    public function AdminLogin(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
             ]);
            $email = $request->email;
            $password = $request->password;
            $data = User::where('email', $email)->where('password', $password)->first();
            if($data)
            {
                Auth::login($data);
                return redirect('/admin');
            }
            else
            {
                return back()->with('error', 'Invalid Email or Password');
            }
        }

        return view('login');
    }

    public function logout()
    {
       
           Auth::logout();
           return redirect('/');
       
      
    }
}
