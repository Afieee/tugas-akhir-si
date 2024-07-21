@extends('layouts.admin-layout')
@section('title', 'Detail Penilaian')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Penilaian Mahasiswa Matakuliah {{ @$matkul->nama_matakuliah }}</h3>
                    <div class="card-toolbar">
                        <div class="d-flex">
                            <input type="text" class="m-1 form-control" placeholder="Search" id="search">
                            <button onclick="search()" type="button" class="m-1 btn btn-sm btn-light-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="table-perwalian"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Jurusan</th>
                                    <th>Semester</th>
                                    <th>Angkatan</th>
                                    <th>Index Nilai</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>

                        </table>
                        <!--end::Table-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Form Penilaian Siswa</h5>
          <button type="button" class="btn" onclick="$('#editModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="formNilai" name="scopeForm" enctype="multipart/form-data" method="POST" action="" class="form-horizontal">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label class="col control-label" for="alamat">Nilai :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="number" name="nilai" id="nilai" class="form-control"required>
                    </div>
                </div>
                <div class="form-group mt-6">
                    <label class="col control-label">Index :</label>
                    <div class="col-sm-12 mt-2">
                       <select name="index" id="index" class="form-control">
                        <option value="A">A</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B">B</option>
                        <option value="B-">B-</option>
                        <option value="C+">C+</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                       </select>
                    </div>
                </div>
                <div class="form-group mt-6">
                    <label class="col control-label">Keterangan :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>
    var table;
    $(document).ready(function () {
        table = $('#table-perwalian').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'POST',
                url: '{{ route("penilaian.json") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_matkul: "{{ Crypt::encrypt($matkul->id) }}",
                    search: function(){
                    return document.getElementById('search').value;
                    },
                },
            },
            columns: [{
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'nama_mahasiswa',
                    name: 'nama_mahasiswa'
                },
                {
                    data: 'nama_jurusan',
                    name: 'nama_jurusan'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'angkatan',
                    name: 'angkatan'
                },
                {
                    data: 'index',
                    name: 'index',
                    render: function (data) {
                       if(data == null){
                            return '-';
                       }
                       else if(data == 'A'){
                        return '<div class="badge badge-light-primary">'+data+'</div>';
                       }
                       else if(data == 'B'){
                        return '<div class="badge badge-light-success">'+data+'</div>';
                       }
                       else{
                        return '<div class="badge badge-light-danger">'+data+'</div>';
                       }
                    }
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-center',
                    orderlable: false,
                    searchable: false
                },
            ],
        });
    });

    function search(){
        table.draw();
        console.log("search")
    }

    function openNilaiForm(id){
        $.get("{{url('penilaian/detail-nilai')}}" + "/" +id, function(data){
            $('#formNilai').attr('action', "{{ url('penilaian/submit') }}"+"/"+id);
            $('#nilai').val(data.response.nilai);
            $('#index').val(data.response.index);
            $('#keterangan').val(data.response.keterangan);
            $('#editModal').modal('show');
        });
    }
</script>
@endpush
