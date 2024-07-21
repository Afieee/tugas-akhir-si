@extends('layouts.admin-layout')
@section('title', 'Pengisian Kuisioner')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ url('kuisioner/kirim/'.$id) }}" id="form-submit" enctype="multipart/form-data"
                method="POST">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kuisioner</h3>
                        <div class="card-toolbar">
                            <button class="btn btn-sm btn-primary" type="button" onclick="submitForm()"><i
                                    class="fas fa-upload"></i> Kirim</button>
                        </div>
                    </div>

                    <div class="card-body">
                        @csrf
                        @if (!$pertanyaan->isEmpty())
                        @foreach ($pertanyaan as $item)

                        <div class="row mt-8">
                            <div class="col-12">
                                <h3>{{ $loop->iteration }}. {{ $item->kuisioner }}</h3>
                                <div class="answer d-flex">
                                    @foreach ($jawaban as $value)
                                    <div class="form-check m-5">
                                        <input type="radio" class="form-check-input"
                                            {{ ($value->id == 3) ? 'checked' : '' }}
                                            name="id_masterdata_respon_kuisioner[{{ $item->id }}]"
                                            value="{{ $value->id }}">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            {{ $value->respon }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @endforeach
                        @endif

                    </div>
                    <div class="card-footer">
                        <label for="" class="mb-3 fw-bolder">Isikan Kritik ataupun Saran yang Membangun</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function submitForm() {
        Swal.fire({
            title: 'Anda Yakin ingin Mengirim data Kuisioner?',
            text: "Tindakan ini tidak dapat diurungkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-submit').submit();
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

</script>
@endpush
