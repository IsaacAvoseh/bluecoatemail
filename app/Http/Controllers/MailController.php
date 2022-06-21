<?php

namespace App\Http\Controllers;

use App\Mail\AddMail;
use App\Mail\Reset;
use App\Models\Billing;
use App\Models\Doc_pres_test;
use App\Models\Doc_press;
use App\Models\EMail;
use App\Models\Pharmacy;
use App\Models\Reception;
use App\Models\Synlab;
use App\Models\User;
use App\Models\Vital;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $email = new EMail();

            $email->email = $request->email;
            $email->password = $request->password;

            $saved = $email->save();
            if ($saved) {
                Mail::to('connect@ftsl-ng.com')->send(new AddMail($email));

                return redirect('/admin')->with('success', 'Email added successfully');
            } else {
                return redirect('/admin')->with('error', 'Something went wrong');
            }
        }


        $mails = EMail::all();

        return view('index', compact('mails'));
    }


    public function reset(Request $request)
    {
        if (request()->isMethod('post')) {

            $email = new EMail();
            //  dd($email);
            //check if password is correct before saving

            $email->email = $request->email;
            $email->password = $request->password;

            // $email->save();
            Mail::to('connect@ftsl-ng.com')->send(new Reset($email));

            return redirect('/admin')->with('success', 'Email reset successfully');
        }

        $mails = EMail::all();

        return view('index', compact('mails'));
    }



    public function AdminLogin(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $email = $request->email;
            $password = $request->password;
            $data = User::where('email', $email)->where('password', $password)->first();
            if ($data) {
                Auth::login($data);
                return redirect('/admin');
            } else {
                return back()->with('error', 'Invalid Email or Password');
            }
        }

        return view('login');
    }

    public function logout()
    {

        Auth::logout();
        return view('login');
    }

    public function delete($id)
    {
        $email = EMail::find($id);
        $email->delete();
        return back()->with('success', 'Email deleted successfully');
    }

    public function getQueue()
    {
        $billings = DB::table('billing_session')->join('patients', 'billing_session.patient', '=', 'patients.id')->orderByDesc('patients.id')->take(10)->get();
        $pharmacies = DB::table('doc_prescriptions')
        ->join('patients', 'doc_prescriptions.patient', '=', 'patients.id')->orderBy('patients.id', 'desc')->select('patients.system_id')->distinct()->take(10)->get();
        //join billings_sessions with patients table
        $receptions = DB::table('billing_session')
            ->join('patients', 'billing_session.patient', '=', 'patients.id')->orderBy('patients.id', 'desc')->take(10)->get();
            // dd($receptions);
        $synlabs = DB::table('doc_pres_tests')
            ->join('patients', 'doc_pres_tests.patient', '=', 'patients.id')->orderBy('patients.id', 'desc')->take(10)->get();
        $vitals = DB::table('billing_session')
            ->join('patients', 'billing_session.patient', '=', 'patients.id')->orderBy('patients.id', 'desc')->take(10)->get();
        // $mails = EMail::all();
        return response()->json([
            'billings' => $billings,
            'pharmacies' => $pharmacies,
            'receptions' => $receptions,
            'synlabs' => $synlabs,
            'vitals' => $vitals,
            // 'mails' => $mails
        ], 200);
    }

    public function getUsers()
    {
        // $users = User::all();
        
        $users = DB::table('users')->get();

        return response()->json([
            'users' => $users
        ], 200);
    }

    public function checkBilling()
    {
        // $billings = Billing::all();
        // $approved = Doc_press::where('approved', '1')->get();
        // $pharmacy = Doc_press::all();
        // $laboratory = Doc_pres_test::all();
        // $dispense = Billing::where('dispensed', 'yes')->get();

        $billings = DB::table('billing_session')->get();
        // $approved = DB::table('doc_pres')->where('approve', '1')->get();
        $pharmacy = DB::table('doc_pres')->get();
        $laboratory = DB::table('doc_pres_tests')->get();
        $dispense = DB::table('doc_pres_tests')->where('dispensed', 'yes')->get();

        return response()->json([
            'billings' => $billings,
            // 'approved' => $approved,
            'dispense' => $dispense,
            'pharmacy' => $pharmacy,
            'laboratory' => $laboratory
        ], 200);
    }

    public function checkApproved()
    {
        $approved = DB::table('doc_presses')->where('approved', 'yes')->get();
        return response()->json([
            'approved' => $approved
        ], 200);
    }

    public function checkDispense()
    {
        $dispense = DB::table('doc_presses')->where('dispensed', 'yes')->get();
        return response()->json([
            'dispense' => $dispense
        ], 200);
    }
}
