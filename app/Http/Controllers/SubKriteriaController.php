<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kriteria;
use App\Models\PilihanKriteria;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class SubKriteriaController extends Controller
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
        $this->middleware('is_admin');
        $this->view = 'admin/kriteria/detail';
        $this->page = '/admin/kriteria';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Sub Kriteria';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/kriteria/index', $this->data);
    }


    public function json($id)
    {
        $data = PilihanKriteria::select('*')
            ->where('id_kriteria', $id)
            ->orderBy('nilai', 'DESC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = PilihanKriteria::find($id);

        $rows->update([
            'id_kriteria' => $request->id_kriteria,
            'nama' => $request->nama_sub,
            'nilai' => $request->nilai,
            'updated_at' => now()
        ]);

        return redirect(url('/admin/kriteria/subkriteria/get/' . $rows->id_kriteria));
    }

    public function store(Request $request)
    {

        DB::table('pilihan_kriteria')->insert([
            'id_kriteria' => $request->id_kriteria,
            'nama' => strval($request->nama_sub),
            'nilai' => $request->nilai,
            'updated_at' => now()
        ]);

        return redirect(url('/admin/kriteria/subkriteria/get/' . $request->id_kriteria));
    }

    public function destroy($id)
    {
        $rows = PilihanKriteria::findOrFail($id);
        $rows->delete();

        return redirect(url('/admin/kriteria/subkriteria/get/' . $rows->id_kriteria));
    }

    public function find($id)
    {
        $data = PilihanKriteria::select('*')->where('id_pil_kriteria', $id)->get();

        return json_encode(array('data' => $data));
    }
}
