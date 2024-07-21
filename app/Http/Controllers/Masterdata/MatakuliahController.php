<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Masterdata\Jurusan;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MatakuliahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jurusan = Jurusan::get();
        $dosen = Dosen::get();
        return view('admin.masterdata.matakuliah', compact('jurusan', 'dosen'));
    }

    public function json(Request $request)
    {
        try {
            $data = Matakuliah::select('matakuliah.*', 'jurusan.nama_jurusan', 'dosen.nama_dosen')
                ->join('jurusan', 'jurusan.id', 'matakuliah.id_jurusan')
                ->join('dosen', 'dosen.id', 'matakuliah.id_dosen')
                ->orderBy('matakuliah.semester', 'asc');
            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('matakuliah.nama_matakuliah', 'like', '%' . $request->search . '%');
                });
            }
            return datatables()->of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="d-flex justify-content-center">
                            <button class="btn btn-sm btn-icon btn-success" onclick="editData(`' . Crypt::encrypt($row->id) . '`);"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-icon ms-2 btn-danger btn-delete" onclick="destroyData(`' . Crypt::encrypt($row->id) . '`);"><i class="fas fa-trash-alt"></i></button>
                        </div>';

                    return $btn;
                })->rawColumns(['action'])->toJson();
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function store(Request $request)
    {
        try {
            $rules = [
                'nama_matakuliah' => 'required|string',
                'id_jurusan' => 'required',
                'id_dosen' => 'required',
                'sks' => 'required',
                'semester' => 'required',
                'perkuliahan' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }

            $data = new Matakuliah();
            $data->id_jurusan = $request->id_jurusan;
            $data->id_dosen = $request->id_dosen;
            $data->nama_matakuliah = $request->nama_matakuliah;
            $data->key = Str::random(8);
            $data->sks = $request->sks;
            $data->semester = $request->semester;
            $data->perkuliahan = $request->perkuliahan;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('masterdata.matakuliah.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function detail(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $selectedItem = Matakuliah::find($id);

        return response()->json($selectedItem);
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $data = Matakuliah::find($id);
            $rules = [
                'nama_matakuliah' => 'required|string',
                'id_jurusan' => 'required',
                'id_dosen' => 'required',
                'sks' => 'required',
                'semester' => 'required',
                'perkuliahan' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
            $data->id_jurusan = $request->id_jurusan;
            $data->id_dosen = $request->id_dosen;
            $data->nama_matakuliah = $request->nama_matakuliah;
            $data->key = Str::random(8);
            $data->sks = $request->sks;
            $data->semester = $request->semester;
            $data->perkuliahan = $request->perkuliahan;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('masterdata.matakuliah.index')->with('success', 'Data berhasil diperbaharui');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $data = Matakuliah::find($id);
        if ($data->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'failed to delete Data']);
        }
    }
}
