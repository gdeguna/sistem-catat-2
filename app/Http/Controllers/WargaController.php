<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// panggil model pegawai
use App\ModelWarga;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WargaController extends Controller
{
    public function index()
    {
    	// mengambil data warga
    	$warga = ModelWarga::all();
 
    	// mengirim data warga ke view masyarakat
    	return view('masyarakat', ['warga' => $warga]);
    }

    public function dashboard()
    {
        $jumlahwarga = DB::table('tb_warga')->count();
        $jumlahpengajuan = DB::table('tb_catatan')->count();
        $jumlahditerima = DB::table('tb_catatan')->where('status', '=', 'Diterima')->whereDate('created_at', Carbon::today())->count();
        $jumlahditolak = DB::table('tb_catatan')->where('status', '=', 'Ditolak')->whereDate('created_at', Carbon::today())->count();

    	return view('dashboard', ['jumlahwarga'=>$jumlahwarga , 'jumlahpengajuan'=>$jumlahpengajuan , 'jumlahditolak'=>$jumlahditolak , 'jumlahditerima'=>$jumlahditerima]);
    }

        public function editwarga($email){

        // $hasilkuh = ModelWarga::find($email);
        $hasilkuh = ModelWarga::where('email', '=', $email)->first();
        return view('datadiri', ['hasilkuh'=>$hasilkuh]);
    }

     public function edituserpost($id, Request $request){
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|min:4|email|unique:tb_warga,email,'.$request->id.',nik' ,
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required'
        ]);

        $data = ModelWarga::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->tgl_lahir = $request->tgl_lahir;
        $data->gender = $request->gender;
        $data->role = $request->role;
        $data->save();
        return redirect('/')->with('alert','Akun anda diperbaharui. Silahkan Login Ulang');
    }

    //halaman warga

    public function dashboardwarga()
    {
        return view('publicdashboard');
    }

    public function publiceditwarga($email){

        // $hasilkuh = ModelWarga::find($email);
        $hasilkuh = ModelWarga::where('email', '=', $email)->first();
        return view('public_datadiri', ['hasilkuh'=>$hasilkuh]);
    }

     public function publicedituserpost($id, Request $request){
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|min:4|email|unique:tb_warga,email,'.$request->id.',nik' ,
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required'
        ]);

        $data = ModelWarga::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->tgl_lahir = $request->tgl_lahir;
        $data->gender = $request->gender;
        $data->role = $request->role;
        $data->save();
        return redirect('/')->with('alert','Akun anda diperbaharui. Silahkan Login Ulang');
    }
}