@extends('layouts.admin-layout')
@section('title', 'Kuisioner')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kuisioner</h3>
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
                        <table id="table"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dosen</th>
                                    <th>NIP</th>
                                    <th>Matakuliah</th>
                                    <th>Semester</th>
                                    <th>SKS</th>
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
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'POST',
                url: '{{ route("kuisioner.json") }}',
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
                    data: 'nama_dosen',
                    name: 'nama_dosen'
                },
                {
                    data: 'nip',
                    name: 'nip'
                },
                {
                    data: 'nama_matakuliah',
                    name: 'nama_matakuliah'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'sks',
                    name: 'sks'
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

@endpush
