<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kriteria;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class KriteriaController extends Controller
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
        $this->view = 'admin/kriteria/index';
        $this->page = '/admin/kriteria';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Kriteria';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/kriteria/index', $this->data);
    }


    public function json()
    {
        $data = Kriteria::select('*')
            ->orderBy('urutan_order', 'ASC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Kriteria::find($id);

        $rows->update([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'urutan_order' => $request->urutan_order,
            'updated_at' => now()
        ]);

        return redirect(route('admin.kriteria'));
    }

    public function store(Request $request)
    {

        DB::table('kriteria')->insert([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'urutan_order' => $request->urutan_order,
            'updated_at' => now()
        ]);

        return redirect(route('admin.kriteria'));
    }

    public function destroy($id)
    {
        $rows = Kriteria::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.kriteria'));
    }

    public function find($id)
    {
        $data = Kriteria::select('*')->where('id_kriteria', $id)->get();

        return json_encode(array('data' => $data));
    }
}
