@extends('layouts.admin-layout')
@section('title', 'Perwalian')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (empty(@$perwalian))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Isian Rencana Studi (Perwalian) Semester
                        {{ Auth::user()->mahasiswa->semester }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('perwalian.kirim') }}" enctype="multipart/form-data" method="POST"
                        id="form-perwalian">
                        @csrf
                        @if (!empty(@$perwalian))
                        <input type="hidden" name="id_perwalian" value="{{ Crypt::encrypt($perwalian->id); }}">
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered gy-5 gs-7" id="table-matkul">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Matakuliah</th>
                                        <th>SKS</th>
                                        <th>Semester</th>
                                        <th>Nama Dosen</th>
                                        <th>Perkuliahan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matakuliah as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_matakuliah }}</td>
                                        <td>{{ $item->sks }}</td>
                                        <td>{{ $item->semester }}</td>
                                        <td>
                                            {{ $item->nama_dosen }}
                                            <br>
                                            <div class="badge badge-light-primary mt-2">NIP. {{ $item->nip }}</div>
                                        </td>
                                        <td>{{ $item->perkuliahan }}</td>
                                        <td>
                                            <input type="checkbox" class="form-check check-matkul"
                                                value="{{ Crypt::encrypt($item->id); }}" name="matakuliah[]">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-end">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-primary btn-sm m-1" onclick="clearForm()"
                                                    type="button"><i class="fas fa-eraser"></i> Clear</button>
                                                <button class="btn btn-danger btn-sm m-1" onclick="submitForm()"
                                                    type="button"><i class="fas fa-upload"></i> Kirim</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Isian Rencana Studi (Perwalian) Semester
                        {{ Auth::user()->mahasiswa->semester }}</h3>
                    <div class="card-toolbar">
                        @if(@$perwalian->status != 'Tervalidasi')
                        <div id="top-btn">
                            <button class="btn btn-success btn-sm" type="button" onclick="openEditForm()"><i class="fas fa-edit"></i> Edit</button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="border border-primary border-3 mb-10 p-5" style="border-radius: 20px">
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>Nama Mahasiswa</h4>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ Auth::user()->mahasiswa->nama_mahasiswa }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>Semester</h4>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ @$perwalian->semester }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>Status</h4>
                            </div>
                            <div class="col-md-8">
                               @if (@$perwalian->status == 'Tervalidasi')
                                    : <div class="badge badge-light-success">{{ @$perwalian->status }}</div>
                               @elseif(@$perwalian->status == 'Ditolak')
                                    : <div class="badge badge-light-danger">{{ @$perwalian->status }}</div>
                                @else
                                    : <div class="badge badge-light-warning">{{ @$perwalian->status }}</div>
                               @endif
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered gy-5 gs-7" id="table-matkul">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Matakuliah</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
                                    <th>Nama Dosen</th>
                                    <th>Perkuliahan</th>
                                    <th class="d-none td-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail_perwalian as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_matakuliah }}</td>
                                    <td>{{ $item->sks }}</td>
                                    <td>{{ $item->semester }}</td>
                                    <td>
                                        {{ $item->nama_dosen }}
                                        <br>
                                        <div class="badge badge-light-primary mt-2">NIP. {{ $item->nip }}</div>
                                    </td>
                                    <td>{{ $item->perkuliahan }}</td>
                                    @if (@$perwalian->status != 'Tervalidasi')
                                    <th class="td-aksi d-none"><button class="btn btn-danger btn-sm btn-icon" onclick="deleteMatkul('{{Crypt::encrypt($item->id)}}')" type="button"><i class="fas fa-trash-alt"></i></button></th>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-10" id="empty-field">

            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function clearForm() {
        $('.check-matkul').prop('checked', false);
        console.log('clear')
    }

    function submitForm() {
        Swal.fire({
            title: 'Anda Yakin ingin Mengirim data Perwalian?',
            text: "Tindakan ini tidak dapat diurungkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-perwalian').submit();
                Swal.fire({
                    icon: 'info',
                    title: "Mohon Tunggu!",
                    html: "Data sedang dalam proses upload",
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Dibatalkan',
                    'Silahkan lengkapi data yang akan anda kirim',
                    'warning')
            }
        })
    }

    function openEditForm(){
        $('.td-aksi').removeClass('d-none');
        $('#top-btn').empty();
        $('#top-btn').append(`<button class="btn btn-secondary btn-sm" type="button" onclick="hideEditForm()"><i class="fas fa-edit"></i> Batalkan Edit</button>`)
        $('#empty-field').empty();
        $('#empty-field').append(
            `   
                <div class="card shadow-sm">
                    <div class="card-body">
                    <form action="{{ route('perwalian.kirim') }}" enctype="multipart/form-data" method="POST"
                        id="form-perwalian">
                        @csrf
                        @if (!empty(@$perwalian))
                        <input type="hidden" name="id_perwalian" value="{{ Crypt::encrypt($perwalian->id); }}">
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered gy-5 gs-7" id="table-matkul">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Matakuliah</th>
                                        <th>SKS</th>
                                        <th>Semester</th>
                                        <th>Nama Dosen</th>
                                        <th>Perkuliahan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matakuliah as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_matakuliah }}</td>
                                        <td>{{ $item->sks }}</td>
                                        <td>{{ $item->semester }}</td>
                                        <td>
                                            {{ $item->nama_dosen }}
                                            <br>
                                            <div class="badge badge-light-primary mt-2">NIP. {{ $item->nip }}</div>
                                        </td>
                                        <td>{{ $item->perkuliahan }}</td>
                                        <td>
                                            <input type="checkbox" class="form-check check-matkul"
                                                value="{{ Crypt::encrypt($item->id); }}" name="matakuliah[]">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-end">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-primary btn-sm m-1" onclick="clearForm()"
                                                    type="button"><i class="fas fa-eraser"></i> Clear</button>
                                                <button class="btn btn-danger btn-sm m-1" onclick="submitForm()"
                                                    type="button"><i class="fas fa-upload"></i> Kirim</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
                </div>
            `
        )
    }

    function hideEditForm(){
        $('.td-aksi').addClass('d-none')
        $('#empty-field').empty();
        $('#top-btn').empty();
        $('#top-btn').append(`<button class="btn btn-success btn-sm" type="button" onclick="openEditForm()"><i class="fas fa-edit"></i> Edit</button>`)
    }

    function deleteMatkul(id){
        Swal.fire({
                title: 'Hapus Matakuliah?',
                text: "Tindakan ini tidak dapat diurungkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type    : 'DELETE',
                        url     : '{{ url("perwalian/matkul/delete") }}' + '/' + id,
                        data    : {_token   : "{{ csrf_token() }}"},
                        success: function (data) {
                            Swal.fire({
                            title: 'sukses',
                            text: "Data berhasil dihapus!",
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false,
                            }).then((result) => {
                            if (result.isConfirmed) {
                               location.reload();
                            }
                        })
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
