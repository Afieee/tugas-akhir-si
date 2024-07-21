<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Masterdata\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jurusan = Jurusan::get();
        foreach ($jurusan as $item) {
            $item->encrypt_id = Crypt::encrypt($item->id);
        }
        return view('admin.management.mahasiswa', compact('jurusan'));
    }

    public function json(Request $request)
    {
        try {
            $data = Mahasiswa::select('mahasiswa.*', 'jurusan.nama_jurusan as jurusan')
                ->join('jurusan', 'jurusan.id', 'mahasiswa.id_jurusan')
                ->orderBy('mahasiswa.id', 'asc');
            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('mahasiswa.nama_mahasiswa', 'like', '%' . $request->search . '%');
                });
            }
            return datatables()->of($data->get())
                ->addIndexColumn()
                ->addColumn('encrypt_id', function ($row) {
                    $id = Crypt::encrypt($row->user_id);

                    return $id;
                })
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
                'nim' => 'required|string|min:6|unique:users,username',
                'email' => 'required|string',
                'nama_mahasiswa' => 'required|string',
                'gender' => 'required',
                'telepon' => 'required',
                'semester' => 'required',
                'angkatan' => 'required',
                'id_jurusan' => 'required',
                'password' => 'required|min:8'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
            $user = new User();
            $user->username = $request->nim;
            $user->name = $request->nama_mahasiswa;
            $user->email = $request->email;
            $user->salt = $request->password;
            $user->password = Hash::make($request->password);
            $user->role_id = 3;
            $user->save();

            $data = new Mahasiswa();
            $data->user_id = $user->id;
            $data->nim = $request->nim;
            $data->nama_mahasiswa = $request->nama_mahasiswa;
            $data->email = $request->email;
            $data->gender = $request->gender;
            $data->telepon = $request->telepon;
            $data->semester = $request->semester;
            $data->angkatan = $request->angkatan;
            $data->id_jurusan = $request->id_jurusan;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('management.mahasiswa.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function detail(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $selectedItem = Mahasiswa::find($id);
        $selectedItem->jurusan = Crypt::encrypt($selectedItem->id_jurusan);
        return response()->json($selectedItem);
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $data = Mahasiswa::find($id);
            $rules = [
                'nim' => 'required|string|min:6|unique:users,username,' . $data->user_id,
                'email' => 'required|string',
                'nama_mahasiswa' => 'required|string',
                'gender' => 'required',
                'telepon' => 'required',
                'semester' => 'required',
                'angkatan' => 'required',
                'id_jurusan' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
            $user = User::find($data->user_id);
            $user->username = $request->nim;
            $user->name = $request->nama_mahasiswa;
            $user->email = $request->email;

            if ($request->password != '' && $request->password != null) {
                $user->salt = $request->password;
                $user->password = Hash::make($request->password);
            }

            $user->role_id = 3;
            $user->save();

            $data->user_id = $user->id;
            $data->nim = $request->nim;
            $data->nama_mahasiswa = $request->nama_mahasiswa;
            $data->email = $request->email;
            $data->gender = $request->gender;
            $data->telepon = $request->telepon;
            $data->semester = $request->semester;
            $data->angkatan = $request->angkatan;
            $data->id_jurusan = $request->id_jurusan;
            $data->updated_by = Auth::user()->id;
            $data->save();

            return redirect()->route('management.mahasiswa.index')->with('success', 'Data berhasil diperbaharui');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $data = Mahasiswa::find($id);
        $user = User::find($data->user_id);
        if ($data->delete()) {
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'failed to delete Data']);
        }
    }

    public function syncSemester(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Mahasiswa::get();

            foreach ($data as $item) {
                if ($item->semester != 8) {
                    $item->semester += 1;
                    $item->save();
                }
            }

            DB::commit();
            return $this->api_response_success("Sinkronisasi Berhasil", []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
            return redirect()->back()->with('error', 'Error Server');
        }
    }
}
