@extends('layouts.admin-layout')
@section('title', 'Penilaian')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (@$data->isEmpty())
            <div class="card shadow-sm mt-10">
                <div class="card-body text-center">
                    <h3 class="text-center">Belum ada penilaian</h3>
                </div>
            </div>
            @else
            @foreach ($data as $item)
                
            <div class="card shadow-sm mt-10">
                <div class="card-header">
                    <h3 class="card-title">Nilai Semester {{ @$item->semester }}</h3>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered gy-5 gs-7" id="table-matkul">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Matakuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Nama Dosen</th>
                                <th>Nilai</th>
                                <th>Index</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item->penilaian as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->nama_matakuliah }}</td>
                                <td>{{ $value->sks }}</td>
                                <td>{{ $value->semester }}</td>
                                <td>
                                    {{ $value->nama_dosen }}
                                    <br>
                                    <div class="badge badge-light-primary mt-2">NIP. {{ $value->nip }}</div>
                                </td>
                                <td>{{ ($value->nilai != null && $value->nilai != '') ? $value->nilai : '-' }}</td>
                                <td><h3>{{ ($value->index != null && $value->index != '') ? $value->index : '-' }}</h3></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
