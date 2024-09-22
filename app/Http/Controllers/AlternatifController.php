<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alternatif;
use App\Models\Node;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class AlternatifController extends Controller
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
        $this->view = 'admin/alternatif/index';
        $this->page = '/admin/alternatif';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Alternatif';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/alternatif/index', $this->data);
    }

    public function baru()
    {
        $this->data[ 'title' ] = 'Tambah Data Jalan';
        $this->data[ 'link' ] = '/admin/alternatif';
        $this->page = '/admin/alternatif';
        $this->data['page'] = $this->page;
        return view('admin/alternatif/baru', $this->data);
    }

    public function edit($id)
    {
        $this->data[ 'title' ] = 'Edit Data Jalan';
        $this->data[ 'link' ] = '/admin/alternatif';
        $this->page = '/admin/alternatif/jalan/'.$id;
        $this->data['page'] = $this->page;
        $this->data['load'] = Alternatif::findorfail($id);
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
        return view('admin/alternatif/edit', $this->data);
    }

    public function json()
    {
        $data = Alternatif::select('*')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_jalan($id)
    {
        $data = Node::select('*')->where('id_alternatif', $id)->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Alternatif::find($id);

        if(!empty($request->node)) {
            Node::select('*')->where('id_alternatif', $id)->delete();
            $node = json_decode($request->node);
            foreach($node as $row) {
                $node = [
                    'id_alternatif' => $id,
                    'latitude' => $row->lat,
                    'longitude' => $row->lng
                ];
                Node::create($node);
            }
        }
        $data = [
            'nama_alternatif' => $request->nama_alternatif,
            'ruas_jalan' => $request->ruas_jalan
        ];

        $rows->update($data);

        return json_encode(array('status' => 'success'));
    }

    public function store(Request $request)
    {

        $data = [
            'nama_alternatif' => $request->nama_alternatif,
            'ruas_jalan' => $request->ruas_jalan
        ];

        Alternatif::create($data);

        if(!empty($request->node)) {
            $alt = Alternatif::select('*')->where('nama_alternatif', $request->nama_alternatif)->first();

            Node::select('*')->where('id_alternatif', $alt->id_alternatif)->delete();
            $node = json_decode($request->node);
            foreach($node as $row) {
                $node = [
                    'id_alternatif' => $alt->id_alternatif,
                    'latitude' => $row->lat,
                    'longitude' => $row->lng
                ];
                Node::create($node);
            }
        }

        return json_encode(array('status' => 'success'));
    }

    public function destroy($id)
    {
        $rows = Alternatif::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.alternatif'));
    }

    public function find($id)
    {
        $data = Alternatif::select('*')->where('id_alternatif', $id)->get();

        return json_encode(array('data' => $data));
    }
}
