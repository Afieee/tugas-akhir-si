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

class VerifikasiPerwalianController extends Controller
{
    public function index()
    {
        return view('admin.perwalian.validasi');
    }
    public function indexJson(Request $request)
    {
        try {
            $data = Perwalian::select('perwalian.*', 'mahasiswa.nama_mahasiswa', 'mahasiswa.nim', 'mahasiswa.angkatan', 'jurusan.nama_jurusan')
                ->join('mahasiswa', 'mahasiswa.id', 'perwalian.id_mahasiswa')
                ->join('jurusan', 'jurusan.id', 'mahasiswa.id_jurusan')
                ->orderBy('status', 'ASC');

            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('mahasiswa.nim', 'like', '%' . $request->search . '%')
                        ->OrWhere('mahasiswa.nama_mahasiswa', 'like', '%' . $request->search . '%')
                        ->OrWhere('mahasiswa.angkatan', 'like', '%' . $request->search . '%')
                        ->OrWhere('jurusan.nama_jurusan', 'like', '%' . $request->search . '%')
                        ->OrWhere('perwalian.status', 'like', '%' . $request->search . '%');
                });
            }

            return datatables()->of($data)
                ->addColumn('aksi', function ($row) {
                    $btn =
                        '<div class="d-flex justify-content-center">
                        <button class="btn m-1 btn-sm btn-icon btn-danger" onclick="tolak(`' . Crypt::encrypt($row->id) . '`);"><i class="fas fa-times-circle"></i></button>
                            <button class="btn m-1 btn-sm btn-icon btn-success" onclick="validasi(`' . Crypt::encrypt($row->id) . '`);"><i class="fas fa-check-circle"></i></button>
                        </div>';

                    return $btn;
                })->rawColumns(['aksi'])->toJson();
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function validasi(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $id = Crypt::decrypt($id);
            $data = Perwalian::find($id);
            $data->status = 'Tervalidasi';
            $data->save();

            DB::commit();
            return $this->api_response_success('Data berhasil diverifikasi');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
            // return redirect()->back()->with('error', 'Error Server');
        }
    }

    public function tolak(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $id = Crypt::decrypt($id);
            $data = Perwalian::find($id);
            $data->status = 'Ditolak';
            $data->save();

            DB::commit();
            return $this->api_response_success('Data berhasil ditolak');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
            // return redirect()->back()->with('error', 'Error Server');
        }
    }
}
