<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Masterdata\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.masterdata.jurusan');
    }

    public function json(Request $request)
    {
        try {
            $data = Jurusan::orderBy('id', 'asc');
            if (!empty($request->search)) {
                $data->where(function ($query) use ($request) {
                    $query->OrWhere('jurusan.nama_jurusan', 'like', '%' . $request->search . '%');
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
                'nama_jurusan' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
            $status = Jurusan::create($request->all());

            return redirect()->route('masterdata.jurusan.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function detail(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $selectedItem = Jurusan::find($id);

        return response()->json($selectedItem);
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $data = Jurusan::find($id);
            $rules = [
                'nama_jurusan' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
            $data->update($request->all());
            return redirect()->route('masterdata.jurusan.index')->with('success', 'Data berhasil diperbaharui');
        } catch (\Throwable $th) {
            return $this->api_response_error($th->getMessage() . ' - ' . $th->getLine(), [], $th->getTrace());
        }
    }
    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $data = Jurusan::find($id);
        if ($data->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'failed to delete Data']);
        }
    }
}
