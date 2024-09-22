<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alternatif;
use App\Models\Node;
use App\Models\Anggaran;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class PimpinanAlternatifController extends Controller
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
        $this->view = 'pimpinan/jalan/index';
        $this->page = '/pimpinan/jalan';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Jalan';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('pimpinan/jalan/index', $this->data);
    }

    public function lihat($id)
    {
        $this->page = '/pimpinan/jalan/lihat/'.$id;
        $this->data['page'] = $this->page;
        $this->data['load'] = Alternatif::findorfail($id);
        $this->data[ 'title' ] = 'Data Jalan - '. $this->data['load']->nama_alternatif;
        $data = Node::select('*')->where('id_alternatif', $id)->get();
        $this->data['node'] = $data;
        $this->data['load']->cordinat = '';
        foreach($data as $row) {
            $this->data['load']->cordinat .= '[';
            if (!next($data)) {
                $this->data['load']->cordinat .= '{lat:'.$row->latitude.'},';
                $this->data['load']->cordinat .= '{lng:'.$row->longitude.'}';
            } else {
                $this->data['load']->cordinat .= '{lat:'.$row->latitude.'},';
                $this->data['load']->cordinat .= '{lng:'.$row->longitude.'}],';
            }
        }
        return view('pimpinan/jalan/lihat', $this->data);
    }

    public function json()
    {
        $data = Alternatif::select('*')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_anggaran($id)
    {
        $data = Anggaran::select('*')->where('id_alternatif', $id)->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Anggaran::find($id);

        $data = [
            'id_alternatif' => $request->id_alternatif,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
        ];

        $rows->update($data);

        return redirect(url('/pimpinan/jalan/lihat/'.$request->id_alternatif));
    }

    public function store(Request $request)
    {

        $data = [
            'id_alternatif' => $request->id_alternatif,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
        ];

        Anggaran::create($data);

        return redirect(url('/pimpinan/jalan/lihat/'.$request->id_alternatif));
    }

    public function destroy($id)
    {
        $rows = Anggaran::findOrFail($id);
        $id_alternatif = $rows->id_alternatif;
        $rows->delete();

        return redirect(url('/pimpinan/jalan/lihat/'.$id_alternatif));
    }

    public function find($id,$od)
    {
        $data = Anggaran::select('*')->where('id', $od)->get();

        return json_encode(array('data' => $data));
    }
}
