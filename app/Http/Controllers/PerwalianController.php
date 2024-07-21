<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPerwalian;
use App\Models\Matakuliah;
use App\Models\Perwalian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PerwalianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $matakuliah = Matakuliah::select('matakuliah.*', 'dosen.nama_dosen', 'dosen.nip')
            ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
            ->orderBy('key', 'ASC')
            ->get();

        $perwalian = Perwalian::where('id_mahasiswa', Auth::user()->mahasiswa->id)
            ->where('semester', Auth::user()->mahasiswa->semester)
            ->orderBy('semester', 'DESC')
            ->first();

        $detail_perwalian = DetailPerwalian::select('detail_perwalian.*', 'matakuliah.nama_matakuliah', 'matakuliah.sks', 'matakuliah.semester', 'matakuliah.perkuliahan', 'dosen.nama_dosen', 'dosen.nip')
            ->join('matakuliah', 'matakuliah.id', 'detail_perwalian.id_matakuliah')
            ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
            ->orderBy('matakuliah.key', 'ASC')
            ->get();

        return view('admin.perwalian.index', compact('matakuliah', 'perwalian', 'detail_perwalian'));
    }

    public function kirim(Request $request)
    {
        try {
            DB::beginTransaction();

            $perwalian = '';
            if ($request->id_perwalian != null && $request->id_perwalian != '') {
                $id_perwalian = Crypt::decrypt($request->id_perwalian);
                $perwalian = Perwalian::find($id_perwalian);
            } else {
                $perwalian = new Perwalian();

                if ($request->matakuliah == '' || empty($request->matakuliah)) {
                    return redirect()->back()->with('error', 'Anda belum mengisi dan memilih satupun Matakuliah');
                }
            }

            $perwalian->id_mahasiswa = Auth::user()->mahasiswa->id;
            $perwalian->semester =  Auth::user()->mahasiswa->semester;
            $perwalian->status = 'Menunggu Validasi';
            $perwalian->save();

            if ($request->matakuliah != '' && !empty($request->matakuliah)) {
                foreach ($request->matakuliah as $item => $key) {
                    $idMatkul = Crypt::decrypt($request->matakuliah[$item]);
                    $newDetail = DetailPerwalian::where('id_matakuliah', $idMatkul)->where('id_perwalian', $perwalian->id)->first();

                    if (empty($newDetail)) {
                        $newDetail = new DetailPerwalian();
                        $newDetail->id_perwalian = $perwalian->id;
                        $newDetail->id_matakuliah = Crypt::decrypt($request->matakuliah[$item]);
                        $newDetail->keterangan = 'Dikontrak';
                        $newDetail->save();
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Perwalian berhasil terkirim dan menunggu validasi');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
            return redirect()->back()->with('error', 'Error Server');
        }
    }

    public function deleteMatkul($id)
    {
        try {
            DB::beginTransaction();
            $id = Crypt::decrypt($id);
            $matakuliah = DetailPerwalian::find($id);
            $matakuliah->delete();

            DB::commit();
            return $this->api_response_success('Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
            // return redirect()->back()->with('error', 'Error Server');
        }
    }
}
