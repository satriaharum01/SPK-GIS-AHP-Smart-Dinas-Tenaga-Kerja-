<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use App\Models\PilihanKriteria;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class NilaiAlternatifController extends Controller
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
        $this->view = 'admin/nilai/index';
        $this->page = '/admin/nilai';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Nilai Alternatif';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/nilai/index', $this->data);
    }


    public function json()
    {
        $data = Alternatif::select('*')->get();

        foreach($data as $row) {
            $row->nama_alt = $row->nama_alternatif;
            $temp = array();
            $kriteria = Kriteria::select('*')->orderby('urutan_order', 'ASC')->get();
            foreach($kriteria as $arr) {
                $load = NilaiAlternatif::select('*')
                        ->where('id_kriteria', $arr->id_kriteria)
                        ->where('id_alternatif', $row->id_alternatif)->first();
                $temp[] = $load;
            }

            $i = 0;
            $j = 1;
            foreach($kriteria as $arr) {
                if(empty($temp[$i])) {
                    $temp[$i] = 'Belum Diisi';
                } else {
                    $nilai = PilihanKriteria::select('*')
                            ->where('id_kriteria', $temp[$i]['id_kriteria'])
                            ->where('nilai', $temp[$i]['nilai'])
                            ->first();
                    $temp[$i] = $nilai->nama;
                }
                $row->{'C'.$j} = $temp[$i];
                $i++;
                $j++;
            }

        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $data = Alternatif::select('*')->where('id_alternatif', $id)->get();
        foreach($data as $row) {

            $temp = array();

            $kriteria = Kriteria::select('*')->orderby('urutan_order', 'ASC')->get();
            $i = 0;
            foreach($kriteria as $arr) {
                $temp[$i]['id_kriteria'] = $arr->id_kriteria;
                $temp[$i]['nilai'] = $request->{'C'.$arr->urutan_order};
                $i++;
            }


            for($i = 0;$i < count($kriteria);$i++) {
                $insert = [
                    'id_alternatif' => $row->id_alternatif,
                    'id_kriteria' => $temp[$i]['id_kriteria'],
                    'nilai' => $temp[$i]['nilai'],
                    'updated_at' => now()
                ];
                $load = NilaiAlternatif::select('*')
                        ->where('id_kriteria', $temp[$i]['id_kriteria'])
                        ->where('id_alternatif', $row->id_alternatif)->first();
                if(empty($load)) {
                    NilaiAlternatif::create($insert);
                } else {
                    $rows = NilaiAlternatif::find($load->id_nilai_alternatif);
                    $rows->update($insert);
                }
            }

        }

        return redirect(route('admin.nilai_alternatif'));
    }

    public function store(Request $request)
    {
        $data = Alternatif::select('*')->where('id_alternatif', $id)->get();
        foreach($data as $row) {

            $temp = array();

            $kriteria = Kriteria::select('*')->orderby('urutan_order', 'ASC')->get();
            $i = 0;
            foreach($kriteria as $arr) {
                $temp[]['id_kriteria'] = $arr->id_kriteria;
            }

            $temp[0]['nilai'] = $request->akreditasi;
            $temp[1]['nilai'] = $request->harga;
            $temp[2]['nilai'] = $request->fasilitas;
            $temp[3]['nilai'] = $request->durasi_perjalanan;
            $temp[4]['nilai'] = $request->layanan;

            for($i = 0;$i < count($kriteria);$i++) {
                $insert = [
                    'id_alternatif' => $row->id_alternatif,
                    'id_kriteria' => $temp[$i]['id_kriteria'],
                    'nilai' => $temp[$i]['nilai'],
                    'updated_at' => now()
                ];
                $load = NilaiAlternatif::select('*')
                        ->where('id_kriteria', $temp[$i]['id_kriteria'])
                        ->where('id_alternatif', $row->id_alternatif)->first();
                if(empty($load)) {
                    DB::table('nilai_alternatif')->insert($insert);
                } else {
                    $rows = NilaiAlternatif::find($load->id_nilai_alternatif);
                    $rows->update($insert);
                }
            }

        }

        return redirect(route('admin.nilai_alternatif'));
    }


    public function find($id)
    {
        $data = Alternatif::select('*')->where('id_alternatif', $id)->get();
        foreach($data as $row) {

            $temp = array();
            $kriteria = Kriteria::select('*')->orderby('urutan_order', 'ASC')->get();
            $i = 0;
            $j = 1;
            foreach($kriteria as $arr) {
                $load = NilaiAlternatif::select('*')
                        ->where('id_kriteria', $arr->id_kriteria)
                        ->where('id_alternatif', $row->id_alternatif)->first();
                if(!empty($load)) {
                    $temp[] = $load->nilai;
                } else {
                    $temp[] = 0;
                }
                $row->{'C'.$j} = $temp[$i];
                $i++;
                $j++;
            }

        }
        return json_encode(array('data' => $data));
    }
}
