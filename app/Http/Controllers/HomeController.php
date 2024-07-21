<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Masterdata\Jurusan;
use App\Models\Matakuliah;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array(
            'dosen' => Dosen::count(),
            'mahasiswa' => Mahasiswa::count(),
            'matakuliah' => Matakuliah::count(),
            'jurusan' => Jurusan::count(),
        );
        return view('dashboard', compact('data'));
    }

    public function auditTrail(Request $request)
    {
        try {
            $data = Audit::select('audits.*', 'users.name')
                ->join('users', 'users.id', 'audits.user_id')
                ->orderBy('id', 'asc');

            if (Auth::user()->role->key != 'sekretariat') {
                $data = $data->where('user_id', Auth::user()->id);
            }
            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('audits.auditable_type', 'like', '%' . $request->search . '%')
                        ->OrWhere('audits.url', 'like', '%' . $request->search . '%')
                        ->OrWhere('audits.ip_address', 'like', '%' . $request->search . '%')
                        ->OrWhere('users.name', 'like', '%' . $request->search . '%');
                });
            }
            return datatables()->of($data->get())
                ->addIndexColumn()
                ->toJson();
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }

    public function trendNilai(Request $request)
    {
        try {
            $c1 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'A')->count();
            $c2 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'A-')->count();
            $c3 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'B+')->count();
            $c4 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'B')->count();
            $c5 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'B-')->count();
            $c6 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'C+')->count();
            $c7 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'C')->count();
            $c8 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'D')->count();
            $c9 = Penilaian::select('penilaian.*')
                ->join('detail_perwalian', 'detail_perwalian.id', 'penilaian.id_detail_perwalian')
                ->join('perwalian', 'perwalian.id', 'detail_perwalian.id_perwalian')
                ->where('perwalian.id_mahasiswa', Auth::user()->mahasiswa->id)->where('penilaian.index', 'E')->count();

            $raw = array(
                'A' => $c1,
                'A-' => $c2,
                'B+' => $c3,
                'B' => $c4,
                'B-' => $c5,
                'C+' => $c6,
                'C' => $c7,
                'D' => $c8,
                'E' => $c9,
            );
            return $this->api_response_success("Data berhasil diambil", $raw);
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
}
