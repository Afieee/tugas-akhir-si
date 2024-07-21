@extends('layouts.admin-layout')
@section('title', 'Masterdata Matakuliah')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Masterdata Matakuliah</h3>
                    <div class="card-toolbar">
                        <div class="d-flex">
                            <input type="text" class="m-1 form-control" placeholder="Search" id="search">
                            <button onclick="search()" type="button" class="m-1 btn btn-sm btn-light-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button class="btn btn-success btn-sm text-white mt-3" onclick="tambahData()"><i class="fas fa-plus mr-2"></i>Tambah Data</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="table"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Matakuliah</th>
                                    <th>Dosen</th>
                                    <th>Jurusan</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
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

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModalLabel">Form Jurusan</h5>
          <button type="button" class="btn" onclick="$('#formModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="form-data" name="scopeForm" enctype="multipart/form-data" method="POST" action="" class="form-horizontal">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label class="col control-label">Nama Matakuliah :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="text" name="nama_matakuliah" id="nama_matakuliah" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Jurusan :</label>
                    <div class="col-sm-12 mt-2">
                        <select name="id_jurusan" id="id_jurusan" class="form-control" required>
                            @foreach ($jurusan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Dosen Pengampu :</label>
                    <div class="col-sm-12 mt-2">
                        <select name="id_dosen" id="id_dosen" class="form-control" required>
                            @foreach ($dosen as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_dosen }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Jumlah SKS :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="number" name="sks" id="sks" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Semester :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="number" name="semester" id="semester" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Perkuliahan :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="text" name="perkuliahan" id="perkuliahan" placeholder="Online/Offline" class="form-control" required>
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
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'POST',
                url: '{{ route("masterdata.matakuliah.json") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    search: function(){
                    return document.getElementById('search').value;
                    },
                },
            },
            columns: [
                {data   : 'DT_RowIndex', name: 'DT_RowIndex', orderlable: false, searchable: false},
                {
                    data: 'nama_matakuliah',
                    name: 'nama_matakuliah'
                },
                {
                    data: 'nama_dosen',
                    name: 'nama_dosen'
                },
                {
                    data: 'nama_jurusan',
                    name: 'nama_jurusan'
                },
                {
                    data: 'sks',
                    name: 'sks'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'action',
                    name: 'action',
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
</script>

{{-- AJAX PLUS --}}
<script>
    function tambahData(id){
        $('#form-data').attr('action', "{{ url('masterdata/matakuliah/store') }}");
        $('#nama_matakuliah').val("");
        $('#sks').val("");
        $('#semester').val("");
        $('#perkuliahan').val("");
        $('#formModal').modal('show');
    }
</script>

 {{-- AJAX EDIT --}}
 <script>
    function editData(id){
        $.get("{{url('masterdata/matakuliah/detail')}}" + "/" +id, function(data){
            $('#form-data').attr('action', "{{ url('masterdata/matakuliah/update') }}"+"/"+id);
            $('#nama_matakuliah').val(data.nama_matakuliah);
            $('#id_jurusan').val(data.id_jurusan);
            $('#id_dosen').val(data.id_dosen);
            $('#perkuliahan').val(data.perkuliahan);
            $('#semester').val(data.semester);
            $('#sks').val(data.sks);
            $('#formModal').modal('show');
        });
    }
</script>

{{-- AJAX DESTROY --}}
<script>
    function destroyData(id){
        Swal.fire({
        title: 'Delete Data?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) { 
                $.ajax({
                    type    : 'DELETE',
                    url     : "{{url('masterdata/matakuliah/delete')}}" +"/"+id,
                    data    : {_token   : "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data)
                        if(data.status == 'success'){
                            Swal.fire(
                            'Deleted!',
                            'Your data has been deleted.',
                            'success'
                            )}
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: data.message
                            });
                        }
                        $('#table').DataTable().ajax.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } 
            else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Dibatalkan',
                    'Data tidak jadi dihapus :)',
                    'error')
            }
        })
    }
</script>
@endpush
