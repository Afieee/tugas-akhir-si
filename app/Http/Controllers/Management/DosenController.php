<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.management.dosen');
    }

    public function json(Request $request)
    {
        try {
            $data = Dosen::orderBy('id', 'asc');
            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('dosen.nama_dosen', 'like', '%' . $request->search . '%');
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
                'nip' => 'required|string|min:8|unique:users,username',
                'email' => 'required|string',
                'nama_dosen' => 'required|string',
                'gender' => 'required',
                'telepon' => 'required',
                'password' => 'required|min:8'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
            $user = new User();
            $user->username = $request->nip;
            $user->name = $request->nama_dosen;
            $user->email = $request->email;
            $user->salt = $request->password;
            $user->password = Hash::make($request->password);
            $user->role_id = 2;
            $user->save();

            $data = new Dosen();
            $data->user_id = $user->id;
            $data->nip = $request->nip;
            $data->nama_dosen = $request->nama_dosen;
            $data->email = $request->email;
            $data->gender = $request->gender;
            $data->telepon = $request->telepon;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('management.dosen.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function detail(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $selectedItem = Dosen::find($id);

        return response()->json($selectedItem);
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $data = Dosen::find($id);
            $rules = [
                'nip' => 'required|string|min:8|unique:users,username,' . $data->user_id,
                'email' => 'required|string',
                'nama_dosen' => 'required|string',
                'gender' => 'required',
                'telepon' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
            $user = User::find($data->user_id);
            $user->username = $request->nip;
            $user->name = $request->nama_dosen;
            $user->email = $request->email;

            if ($request->password != '' && $request->password != null) {
                $user->salt = $request->password;
                $user->password = Hash::make($request->password);
            }

            $user->role_id = 2;
            $user->save();

            $data->user_id = $user->id;
            $data->nip = $request->nip;
            $data->nama_dosen = $request->nama_dosen;
            $data->email = $request->email;
            $data->gender = $request->gender;
            $data->telepon = $request->telepon;
            $data->updated_by = Auth::user()->id;
            $data->save();

            return redirect()->route('management.dosen.index')->with('success', 'Data berhasil diperbaharui');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $data = Dosen::find($id);
        $user = User::find($data->user_id);
        if ($data->delete()) {
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'failed to delete Data']);
        }
    }
}
