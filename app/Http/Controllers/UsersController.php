<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $push['no'] = 1;
        $push['data'] = User::orderby('id', 'ASC')
        ->orderby('level', 'ASC')
        ->get();

        return view('home', $push);
    }

    public function destroy($id)
    {
        $rows = User::findOrFail($id);
        $rows->delete();
        return redirect('/users');

    }

    public function update(Request $request, $id)
    {
        $rows = User::find($id);
        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'updated_at' => now()
        ];
        if($request->password == true) {
            $data['password'] = Hash::make($request->password);
        }

        $rows->update($data);

        if(Auth::user()->level == "Pegawai") {
            return redirect(route('pegawai.profil'));
        } else {
            return redirect(route('pimpinan.profil'));
        }

    }

    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level
        ]);

        return redirect('/users');

    }

    public function json()
    {
        $data = User::select('*')
            ->where('level', 'Pimpinan')
            ->get();

        foreach($data as $row) {
            $row->no_hp = '0' . $row->no_hp;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
