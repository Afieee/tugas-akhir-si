@extends('layouts.admin-layout')
@section('title', 'Masterdata Respon')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Masterdata Respon Kuisioner</h3>
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
                                    <th>Respon</th>
                                    <th>Nilai</th>
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
          <h5 class="modal-title" id="formModalLabel">Form Respon Kuisioner</h5>
          <button type="button" class="btn" onclick="$('#formModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="form-data" name="scopeForm" enctype="multipart/form-data" method="POST" action="" class="form-horizontal">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label class="col control-label">Respon :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="text" name="respon" id="respon" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="col control-label">Nilai :</label>
                    <div class="col-sm-12 mt-2">
                        <input type="number" name="nilai" id="nilai" class="form-control">
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
                url: '{{ route("masterdata.respon-kuisioner.json") }}',
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
                    data: 'respon',
                    name: 'respon'
                },
                {
                    data: 'nilai',
                    name: 'nilai'
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
        $('#form-data').attr('action', "{{ url('masterdata/respon-kuisioner/store') }}");
        $('#respon').val("");
        $('#nilai').val("");
        $('#formModal').modal('show');
    }
</script>

 {{-- AJAX EDIT --}}
 <script>
    function editData(id){
        $.get("{{url('masterdata/respon-kuisioner/detail')}}" + "/" +id, function(data){
            $('#form-data').attr('action', "{{ url('masterdata/respon-kuisioner/update') }}"+"/"+id);
            $('#respon').val(data.respon);
            $('#nilai').val(data.nilai);
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
                    url     : "{{url('masterdata/respon-kuisioner/delete')}}" +"/"+id,
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
