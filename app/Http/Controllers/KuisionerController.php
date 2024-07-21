<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Masterdata\Kuisioner as MasterdataKuisioner;
use App\Models\Masterdata\ResponKuisioner;
use App\Models\Perwalian;
use App\Models\Kuisioner;
use App\Models\DetailKuisioner;
use App\Models\DetailPerwalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class KuisionerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexMahasiswa()
    {
        return view('admin.kuisioner.index');
    }

    public function indexJson(Request $request)
    {
        try {
            $data = Perwalian::select('dosen.nama_dosen', 'dosen.nip', 'matakuliah.nama_matakuliah', 'matakuliah.sks', 'matakuliah.semester', 'kuisioner.*', 'detail_perwalian.id as id_kuisioner_sementara')
                ->join('detail_perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->join('matakuliah', 'matakuliah.id', 'detail_perwalian.id_matakuliah')
                ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
                ->leftJoin('kuisioner', 'kuisioner.id_detail_perwalian', 'detail_perwalian.id')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id);

            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('dosen.nama_dosen', 'like', '%' . $request->search . '%');
                });
            }
            return datatables()->of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->id_kuisioner_sementara != $row->id_detail_perwalian) {
                        $btn =
                            '<div class="d-flex justify-content-center">
                        <a class="btn btn-sm btn-icon btn-primary" href="' . url('kuisioner/pengisian/' . Crypt::encrypt($row->id_kuisioner_sementara)) . '"><i class="fas fa-edit"></i></a>
                    </div>';
                    } else {
                        $btn =
                            '<div class="d-flex justify-content-center">
                            <a class="btn btn-sm btn-icon btn-secondary" href="' . url('kuisioner/detail/' . Crypt::encrypt($row->id)) . '"><i class="fas fa-eye"></i></a>
                        </div>';
                    }

                    return $btn;
                })->rawColumns(['action'])->toJson();
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }

    public function pengisian($id)
    {
        try {
            $pertanyaan = MasterdataKuisioner::orderBy('id', 'asc')->get();
            $jawaban = ResponKuisioner::orderBy('id', 'asc')->get();

            return view('admin.kuisioner.pengisian', compact('id', 'pertanyaan', 'jawaban'));
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }

    public function kirim(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $dataDosen = DetailPerwalian::select('dosen.*')
                ->join('matakuliah', 'matakuliah.id', 'detail_perwalian.id_matakuliah')
                ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
                ->where('detail_perwalian.id', $id)
                ->first();

            $kuisioner = new Kuisioner();
            $kuisioner->id_dosen = $dataDosen->id;
            $kuisioner->id_mahasiswa = Auth::user()->mahasiswa->id;
            $kuisioner->id_detail_perwalian = $id;
            $kuisioner->keterangan = $request->keterangan;
            $kuisioner->created_by = Auth::user()->id;
            $kuisioner->save();

            $masterKuisioner = MasterdataKuisioner::orderBy('id', 'asc')->get();

            foreach ($masterKuisioner as $item => $key) {
                $detailKuisioner = new DetailKuisioner();
                $detailKuisioner->id_kuisioner = $kuisioner->id;
                $detailKuisioner->id_masterdata_kuisioner = $key->id;
                $detailKuisioner->id_masterdata_respon_kuisioner = $request->id_masterdata_respon_kuisioner[$key->id];
                $detailKuisioner->created_by = Auth::user()->id;
                $detailKuisioner->save();
            }

            return redirect()->route('kuisioner.index')->with('success', 'Data berhasil dikirim');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data = DetailKuisioner::select('detail_kuisioner.*', 'masterdata_kuisioner.kuisioner', 'masterdata_respon_kuisioner.respon')
            ->join('kuisioner', 'kuisioner.id', 'detail_kuisioner.id_kuisioner')
            ->join('masterdata_kuisioner', 'masterdata_kuisioner.id', 'detail_kuisioner.id_masterdata_kuisioner')
            ->join('masterdata_respon_kuisioner', 'masterdata_respon_kuisioner.id', 'detail_kuisioner.id_masterdata_respon_kuisioner')
            ->where('detail_kuisioner.id_kuisioner', $id)
            ->orderBy('masterdata_kuisioner.id', 'asc')
            ->get();

        $header = Kuisioner::select('dosen.nama_dosen', 'dosen.nip', 'matakuliah.nama_matakuliah', 'kuisioner.keterangan')
            ->join('detail_perwalian', 'detail_perwalian.id', 'kuisioner.id_detail_perwalian')
            ->join('matakuliah', 'matakuliah.id', 'detail_perwalian.id_matakuliah')
            ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
            ->where('kuisioner.id', $id)
            ->first();

        return view('admin.kuisioner.detail-kuisioner', compact('data', 'header'));
    }

    public function indexDosen()
    {
        return view('admin.kuisioner.index-dosen');
    }

    public function indexDosenJson(Request $request)
    {
        try {
            $data = Kuisioner::where('id_dosen', Auth::user()->dosen->id)
                ->orderBy('id', 'desc');

            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('keterangan', 'like', '%' . $request->search . '%');
                });
            }
            return datatables()->of($data->get())
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    $date = Carbon::parse($row->created_at)->isoFormat('D MMMM Y');
                    return $date;
                })
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="d-flex justify-content-center">
                        <a class="btn btn-sm btn-icon btn-secondary" href="' . url('kuisioner/detail/' . Crypt::encrypt($row->id)) . '"><i class="fas fa-eye"></i></a>
                    </div>';

                    return $btn;
                })->rawColumns(['action'])->toJson();
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
}
