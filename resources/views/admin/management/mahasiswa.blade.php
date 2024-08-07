@extends('layouts.admin-layout')
@section('title', 'Mahasiswa')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Mahasiswa</h3>
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
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Semester</th>
                                    <th>Angkatan</th>
                                    <th>Jurusan</th>
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
          <h5 class="modal-title" id="formModalLabel">Form Mahasiswa</h5>
          <button type="button" class="btn" onclick="$('#formModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="form-data" name="scopeForm" enctype="multipart/form-data" method="POST" action="" class="form-horizontal">
            <div class="modal-body">
                @csrf
                <div class="form-group mt-5">
                    <label class="col control-label">NIM :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="text" name="nim" id="nim" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Nama :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Email :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Gender :</label>
                    <div class="col-sm-12 mt-2">
                       <select name="gender" id="gender" class="form-control">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                       </select>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Telepon :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="text" name="telepon" id="telepon" class="form-control" required>
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
                    <label class="col control-label">Semester :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="number" name="semester" id="semester" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Angkatan :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="number" name="angkatan" id="angkatan" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5" id="form-password">
                    <label class="col control-label">Password :</label>
                    <div class="col-sm-12 mt-2">
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="input-group-append">
                                <button type="button" onclick="showPassword()" class="btn btn-light-primary btn-icon"><i id="icon-password" class="fas fa-eye"></i></button>
                            </div>
                          </div>
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
    let password = 'hide';
    var table;
    $(document).ready(function () {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'POST',
                url: '{{ route("management.mahasiswa.json") }}',
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
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'nama_mahasiswa',
                    name: 'nama_mahasiswa'
                },
                {
                    data: 'email',
                    name: 'email'
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
                    data: 'jurusan',
                    name: 'jurusan'
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
        $('#form-data').attr('action', "{{ url('management/mahasiswa/store') }}");
        $('#nim').val("");
        $('#nama_mahasiswa').val("");
        $('#email').val("");
        $('#telepon').val("");
        $('#gender').val("Laki-laki");
        $('#semester').val("");
        $('#angkatan').val("");
        $('#form-password').empty();
        $('#form-password').append(
            `  <label class="col control-label">Password :</label>
                    <div class="col-sm-12 mt-2">
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="input-group-append">
                                <button type="button" onclick="showPassword()" class="btn btn-light-primary btn-icon"><i id="icon-password" class="fas fa-eye"></i></button>
                            </div>
                          </div>
                    </div>`
        )
        $('#password').val("");
        $('#formModal').modal('show');
    }
</script>

 {{-- AJAX EDIT --}}
 <script>
    function editData(id){
        $.get("{{url('management/mahasiswa/detail')}}" + "/" +id, function(data){
            $('#form-data').attr('action', "{{ url('management/mahasiswa/update') }}"+"/"+id);
            $('#nim').val(data.nim);
            $('#nama_mahasiswa').val(data.nama_mahasiswa);
            $('#email').val(data.email);
            $('#telepon').val(data.telepon);
            $('#gender').val(data.gender);
            $('#semester').val(data.semester);
            $('#angkatan').val(data.angkatan);
            $('#id_jurusan').val(data.id_jurusan);
            $('#password').val("");
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
                    url     : "{{url('management/mahasiswa/delete')}}" +"/"+id,
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

    function showPassword(){
        if(password == 'hide'){
            password = 'show';
            $('#password').attr('type', 'text');
            $('#icon-password').removeClass('fa-eye');
            $('#icon-password').addClass('fa-eye-slash');
        }
        else{
            password = 'hide';
            $('#password').attr('type', 'password');
            $('#icon-password').removeClass('fa-eye-slash');
            $('#icon-password').addClass('fa-eye');
        }
    }
</script>
@endpush
