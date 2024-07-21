@extends('layouts.admin-layout')
@section('title', 'Validasi Perwalian')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Perwalian Mahasiswa</h3>
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
                                    <th>Status</th>
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
                url: '{{ route("validasi-perwalian.json") }}',
                data: {
                    _token: "{{ csrf_token() }}",
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
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        return (data == 'Tervalidasi') ? '<div class="badge badge-light-success">'+data+'</div>' : '<div class="badge badge-light-warning">'+data+'</div>';
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

    function validasi(id){
        Swal.fire({
                title: 'Validasi Perwalian?',
                text: "Tindakan ini tidak dapat diurungkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type    : 'POST',
                        url     : '{{ url("validasi-perwalian/validasi") }}' + '/' + id,
                        data    : {_token   : "{{ csrf_token() }}"},
                        success: function (data) {
                            Swal.fire({
                            title: 'sukses',
                            text: "Data berhasil divalidasi!",
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false,
                            });

                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Dibatalkan',
                        'Data tidak jadi dihapus :',
                        'error')
                }
            })
    }

    function tolak(id){
        Swal.fire({
                title: 'Tolak Perwalian?',
                text: "Tindakan ini tidak dapat diurungkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type    : 'POST',
                        url     : '{{ url("validasi-perwalian/tolak") }}' + '/' + id,
                        data    : {_token   : "{{ csrf_token() }}"},
                        success: function (data) {
                            Swal.fire({
                            title: 'sukses',
                            text: "Data berhasil ditolak!",
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false,
                            });

                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Dibatalkan',
                        'Data tidak jadi dihapus :',
                        'error')
                }
            })
    }
</script>
@endpush
