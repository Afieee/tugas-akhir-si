@extends('layouts.admin-layout')
@section('title', 'Penilaian')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Penilaian Matakuliah</h3>
                </div>
                <div class="card-body">
                    <div class="border border-primary border-3 mb-10 p-5" style="border-radius: 20px">
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>Nama Dosen</h4>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ Auth::user()->dosen->nama_dosen }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>NIP</h4>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ Auth::user()->dosen->nip }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h4>Status Dosen</h4>
                            </div>
                            <div class="col-md-8">
                                : <div class="badge badge-light-success">Aktif</div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered gy-5 gs-7" id="table-matkul">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Matakuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Nama Dosen</th>
                                <th>Perkuliahan</th>
                                <th class="td-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matkul as $item)
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
                                <td><a href="{{ url('penilaian/detail/'.Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-primary"><i class="fas fa-sign-in-alt"></i> Detail</a></td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
