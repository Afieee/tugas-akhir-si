@extends('layouts.admin-layout')
@section('title', 'Detail Kuisioner')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hasil Kuisioner</h3>
                    {{-- <div class="card-toolbar">
                       <button class="btn btn-sm btn-primary" type="button" onclick="submitForm()"><i class="fas fa-upload"></i> Kirim</button>
                    </div> --}}
                </div>

                <div class="card-body">
                    <div class="border border-primary border-3 mb-10 p-5" style="border-radius: 20px">
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>Nama Dosen</h4>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ @$header->nama_dosen }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>NIP</h4>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ @$header->nip }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>Matakuliah</h4>
                            </div>
                            <div class="col-md-8">
                              <p>: {{ @$header->nama_matakuliah }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Respon</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kuisioner }}</td>
                                    <td>{{ $item->respon }}</td>
                                </tr>
                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <label for="" class="mb-3 fw-bolder">Kritik dan Saran</label>
                    <textarea name="" readonly id="" class="form-control" cols="30" rows="10">{{ @$header->keterangan }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
