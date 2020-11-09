<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Userlogin;
use App\User;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function proses_turun()
    {
        $data=Userlogin::all();

        foreach($data as $o){
            $ss            = new User;
            $ss->nik       = $o['regno'];
            $ss->name      = $o['full_name'];
            $ss->email     = $o['email'];
            $ss->role_id   = $o['group_id'];
            $ss->password  = Hash::make($o['regno']);
            $ss->save();
        }
    }
    public function pdf()
    {
        $data='Hai PDF';
        $pdf = PDF::loadView('pdf', ['data'=>$data]);
        return $pdf->stream();
    }
}
