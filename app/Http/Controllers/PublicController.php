<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use App\Models\PilihanKriteria;
use App\Models\Pengaduan;
use App\Models\Node;
use App\Models\Anggaran;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use File;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('is_admin');
    }

    private $status = [
        'Rusak Berat',
        'Rusak Sedang',
        'Rusak Ringan',
        'Baik'
    ];
    /*
     * Dashboad Function
    */
    public function index()
    {
        return redirect(route('home.page'));
    }

    public function peta()
    {
        $this->data['page'] = 'Peta';
        $this->data['title'] = 'Peta';
        return view('landing.index', $this->data);
    }

    public function pengaduan()
    {
        $this->data['title'] = 'Layanan Pengaduan';
        return view('landing.pengaduan', $this->data);
    }

    public function jalan()
    {
        $this->data['title'] = 'Data Jalan';
        return view('landing.jalan', $this->data);
    }

    //For JSON

    public function find($id)
    {
        $data = Alternatif::select('*')->where('id_alternatif', $id)->get();

        foreach($data as $row) {
            $row->nama_alt = $row->nama_alternatif;
            $row->akreditasi = 'Belum Diisi';
            $row->harga = 'Belum Diisi';
            $row->fasilitas = 'Belum Diisi';
            $row->durasi_perjalanan = 'Belum Diisi';
            $row->layanan = 'Belum Diisi';

            $temp = array();
            $kriteria = Kriteria::select('*')->orderby('urutan_order', 'ASC')->get();
            foreach($kriteria as $arr) {
                $load = NilaiAlternatif::select('*')
                        ->where('id_kriteria', $arr->id_kriteria)
                        ->where('id_alternatif', $row->id_alternatif)->first();
                $temp[] = $load;
            }
            $i = 0;
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
                $i++;
            }

            $row->akreditasi = $temp[0];
            $row->harga =  $temp[1];
            $row->fasilitas =  $temp[2];
            $row->durasi_perjalanan =  $temp[3];
            $row->layanan =  $temp[4];
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_jalan()
    {
        $data = Alternatif::select('*')
        ->get();

        $kriteria = Kriteria::select('*')->orderby('urutan_order', 'ASC')->get();

        $count = count($kriteria);
        foreach($data as $row) {
            $row->nilai = 0;
            $cek = NilaiAlternatif::select('*')->where('id_alternatif', $row->id_alternatif)->first();
            if(!empty($cek)) {
                foreach($kriteria as $low) {
                    $max = PilihanKriteria::select('*')->where('id_kriteria', $low->id_kriteria)->max('nilai');
                    $min = PilihanKriteria::select('*')->where('id_kriteria', $low->id_kriteria)->min('nilai');
                    $nilai = NilaiAlternatif::select('*')->where('id_kriteria', $low->id_kriteria)->where('id_alternatif', $row->id_alternatif)->first();
                    if(!empty($nilai)) {
                        $row->{'C'.$low->urutan_order} = ($nilai->nilai - $min) / ($max - $min);
                    } else {
                        $row->{'C'.$low->urutan_order} = ($max - $min) / ($max - $min);
                    }
                }
            }

            foreach($kriteria as $low) {
                $row->nilai = $row->nilai + ($low->bobot * $row->{'C'.$low->urutan_order});
            }
            if($row->nilai != 0) {
                $row->nilai = number_format($row->nilai, 4);
            }
        }

        $hasil = $data->toArray();

        array_multisort(array_column($hasil, 'nilai'), SORT_DESC, $hasil);

        $i = 1;
        foreach($hasil as $row) {
            $hasil[$i - 1]['rank'] = $i;
            $i++;
        }

        array_multisort(array_column($hasil, 'rank'), SORT_ASC, $hasil);
        $counter = count($hasil);
        $segment = $counter / 4;
        $i = round($segment,0);
        $j = 0;
        $k = 0;
        foreach($hasil as $row) {
            $hasil[$k]['status'] = $this->status[$j];
            $hasil[$k]['cordinat'] = Node::select('*')->where('id_alternatif', $row['id_alternatif'])->get();
            $i--;
            if($i == 0)
            {
                $i = round($segment,0);
                $j++;
            }
            $k++;
        }

        return json_encode($hasil);
    }

    public function find_cordinat($id)
    {
        $data = Node::select('*')->where('id_alternatif', $id)->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Pengaduan::find($id);

        $data = [
            'pelapor' => $request->pelapor,
            'deskripsi' => $request->deskripsi,
            'id_jalan' => $request->id_jalan
        ];

        $file = $request->file('foto');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = $request->pelapor . '-' . date('Y-m-d') . $ext;
            $this->image_destroy($filename);
            $file->storeAs('', $filename, ['disk' => 'public_uploads']);
            $data['foto'] = $filename;
        }
        $rows->update($data);

        return redirect(route('home.page'));
    }

    public function store(Request $request)
    {
        $file = $request->file('foto');
        $data = [
            'pelapor' => $request->pelapor,
            'deskripsi' => $request->deskripsi,
            'id_jalan' => $request->id_jalan
        ];
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = $request->pelapor . '-' . date('Y-m-d') . $ext;
            $this->image_destroy($filename);
            $file->storeAs('', $filename, ['disk' => 'public_uploads']);
            $data['foto'] = $filename;
        }
        Pengaduan::create($data);

        return redirect(route('home.page'));
    }

    public function destroy($id)
    {
        $rows = Pengaduan::findOrFail($id);
        $rows->delete();

        return redirect(route('home.page'));
    }

    public function image_destroy($filename)
    {
        if (File::exists(public_path('/file/pengaduan/' . $filename . ''))) {
            File::delete(public_path('/file/pengaduan/' . $filename . ''));
        }
    }


    public function jalan_test()
    {
        $cord = array();
        $data = Alternatif::select('*')->where('id_alternatif', 1)->get();
        foreach($data as $row) {
            $load = $row->cordinat;
            $cord[] = $row->cordinat;
        }
        return print_r(json_($load));
        //return Datatables::of($cord)
        //    ->addIndexColumn()
        //    ->make(true);
    }

    public function get_jalan()
    {
        $data = Alternatif::select('*')->get();

        foreach($data as $row)
        {
            if(Anggaran::select('*')->where('id_alternatif', $row->id_alternatif)->count() > 0)
            {
                $row->keterangan = 'Anggaran sudah dibuat';
            }else{
                $row->keterangan = 'Masih dalam proses perhitungan anggaran';
            }
        }

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

    public function ganti_password(Request $request)
    {
        $rows = User::find(Auth::user()->id);
        $rows->update(['password' => Hash::make($request->password)]);

        return redirect(url('/'));
    }
}
