<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class PimpinanPengaduanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //Start Controller Function
        $this->middleware('auth');
        $this->middleware('is_pimpinan');
        $this->view = 'pimpinan/pengaduan/index';
        $this->page = '/pimpinan/pengaduan';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Pelaporan Kerusakan Jalan';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('pimpinan/pengaduan/index', $this->data);
    }

    public function detail($id)
    {
        $data = Pengaduan::select('*')->where('id', $id)->get();

        foreach($data as $row) {
            $row->tanggal = date('d F Y', strtotime($row->created_at));
            $row->jalan = $row->cari_jalan->nama_alternatif;
        }
        $this->data['load'] = $data;
        return view('pimpinan/pengaduan/detail', $this->data);
    }

    public function json()
    {
        $data = Pengaduan::select('*')->get();

        foreach($data as $row) {
            $row->tanggal = date('d F Y', strtotime($row->created_at));
            $row->jalan = $row->cari_jalan->nama_alternatif;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function destroy($id)
    {
        $rows = Pengaduan::findOrFail($id);
        $rows->delete();

        return redirect(route('pimpinan.pengaduan'));
    }

    public function find($id)
    {
        $data = Pengaduan::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }
}
