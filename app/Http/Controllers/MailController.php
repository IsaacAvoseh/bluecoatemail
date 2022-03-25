<?php

namespace App\Http\Controllers;

use App\Mail\AddMail;
use App\Mail\Reset;
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
                Mail::to('isaactraintest@gmail.com')->send(new AddMail($email));

                return redirect('/admin')->with('success', 'Email added successfully');
                }
                else
                {
                    return redirect('/admin')->with('error', 'Password is incorrect');
                }

        }
        
        $mails = EMail::all();
            
        return view('index', compact('mails'));
    }


    public function reset(Request $request)
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
                    // $email->save();
                Mail::to('isaactraintest@gmail.com')->send(new Reset($email));

                return redirect('/admin')->with('success', 'Email reset successfully');
                }
                else
                {
                    return redirect('/admin')->with('error', 'Password is incorrect');
                }

        }
        
        $mails = EMail::all();
            
        return view('index', compact('mails'));
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

    public function delete($id)
    {
        $email = EMail::find($id);
        $email->delete();
        return back()->with('success', 'Email deleted successfully');
    }
}
