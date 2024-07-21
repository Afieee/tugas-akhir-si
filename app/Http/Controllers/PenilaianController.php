<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPerwalian;
use App\Models\Matakuliah;
use App\Models\Penilaian;
use App\Models\Perwalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    public function index()
    {
        $matkul = Matakuliah::select('matakuliah.*', 'dosen.nama_dosen', 'dosen.nip')
            ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
            ->orderBy('key', 'ASC')
            ->where('id_dosen', Auth::user()->dosen->id)->get();

        return view('admin.penilaian.index', compact('matkul'));
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $matkul = Matakuliah::find($id);

        return view('admin.penilaian.detail', compact('matkul'));
    }

    public function json(Request $request)
    {
        try {
            $id = Crypt::decrypt($request->id_matkul);
            $data = DetailPerwalian::select('detail_perwalian.*', 'mahasiswa.nama_mahasiswa', 'mahasiswa.semester', 'mahasiswa.nim', 'mahasiswa.angkatan', 'jurusan.nama_jurusan', 'penilaian.index', 'penilaian.id as id_penilaian', 'penilaian.nilai')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->join('mahasiswa', 'mahasiswa.id', 'perwalian.id_mahasiswa')
                ->join('jurusan', 'jurusan.id', 'mahasiswa.id_jurusan')
                ->leftJoin('penilaian', 'penilaian.id_detail_perwalian', 'detail_perwalian.id')
                ->where('detail_perwalian.id_matakuliah', $id)
                ->orderBy('mahasiswa.nama_mahasiswa', 'ASC');

            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('mahasiswa.nim', 'like', '%' . $request->search . '%')
                        ->OrWhere('mahasiswa.nama_mahasiswa', 'like', '%' . $request->search . '%')
                        ->OrWhere('mahasiswa.angkatan', 'like', '%' . $request->search . '%')
                        ->OrWhere('jurusan.nama_jurusan', 'like', '%' . $request->search . '%');
                });
            }

            return datatables()->of($data)
                ->addColumn('aksi', function ($row) {
                    $btn =
                        '<div class="d-flex justify-content-center">
                            <button class="btn btn-sm btn-icon btn-primary" onclick="openNilaiForm(`' . Crypt::encrypt($row->id) . '`);"><i class="fas fa-edit"></i></button>
                        </div>';

                    return $btn;
                })->rawColumns(['aksi'])->toJson();
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }

    public function detailNilai($id)
    {
        $id = Crypt::decrypt($id);
        $data = DetailPerwalian::select('detail_perwalian.*', 'penilaian.id as id_penilaian', 'penilaian.nilai', 'penilaian.index', 'penilaian.keterangan')
            ->leftJoin('penilaian', 'penilaian.id_detail_perwalian', 'detail_perwalian.id')
            ->where('detail_perwalian.id', $id)
            ->first();

        if ($data->id_penilaian != null && $data->id_penilaian != '') {
            $data->id_penilaian = Crypt::encrypt($data->id_penilaian);
        }

        return $this->api_response_success('Data berhasil diambil', $data->toArray());
    }

    public function submit(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $id = Crypt::decrypt($id);
            $data = DetailPerwalian::find($id);

            $rules = [
                'nilai' => 'required|numeric',
                'index' => 'required|string',
                'keterangan' => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }

            $penilaian = Penilaian::where('id_detail_perwalian', $data->id)->first();

            if (empty($penilaian)) {
                $penilaian = new Penilaian();
            }
            $penilaian->id_detail_perwalian = $data->id;
            $penilaian->nilai = $request->nilai;
            $penilaian->index = $request->index;
            $penilaian->keterangan = $request->keterangan;
            $penilaian->save();

            DB::commit();
            return redirect()->back()->with('success', 'Penilaian Berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
            return redirect()->back()->with('error', 'Error Server');
        }
    }

    public function indexMahasiswa()
    {
        $data = Perwalian::where('id_mahasiswa', Auth::user()->mahasiswa->id)->orderBy('semester', 'ASC')->get();
        if (!$data->isEmpty()) {
            foreach ($data as $item) {
                $item->penilaian = DetailPerwalian::select('dosen.nama_dosen', 'dosen.nip', 'matakuliah.nama_matakuliah', 'matakuliah.sks', 'matakuliah.semester', 'detail_perwalian.*', 'penilaian.id as id_penilaian', 'penilaian.nilai', 'penilaian.index', 'penilaian.keterangan')
                    ->join('matakuliah', 'matakuliah.id', 'detail_perwalian.id_matakuliah')
                    ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
                    ->leftJoin('penilaian', 'penilaian.id_detail_perwalian', 'detail_perwalian.id')
                    ->where('detail_perwalian.id_perwalian', $item->id)
                    ->get();
            }
        }

        return view('admin.penilaian.index-mahasiswa', compact('data'));
    }
}
