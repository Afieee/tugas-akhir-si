@extends('layouts.admin-layout')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Auth::user()->role->key == 'mahasiswa')
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Jumlah Perolehan Nilai</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <div id="chart"></div>
                </div>
                <!--begin::Body-->
            </div>
            @else
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Data Counting</span>
                    </h3>
                    <div class="card-toolbar">
                        @if (Auth::user()->role->key == 'sekretariat')
                        <button class="btn btn-sm btn-primary" onclick="syncSemester()"><i class="fas fa-sync"></i>
                            Sinkronisasi Semester Selanjutnya</button>
                        @endif
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    @php
                    $dataloop = [
                    ['title' => 'Jumlah Data Dosen','counting' => $data['dosen'], 'icon' => 'fa-user-graduate'],
                    ['title' => 'Jumlah Data Mahasiswa','counting' => $data['mahasiswa'], 'icon' => 'fa-users'],
                    ['title' => 'Jumlah Data Jurusan','counting' => $data['jurusan'], 'icon' => 'fa-building'],
                    ['title' => 'Jumlah Data Matakuliah','counting' => $data['matakuliah'], 'icon' =>
                    'fa-file-signature']
                    ];
                    @endphp
                    <div class="row mt-5">
                        <!-- Earnings (Monthly) Card Example -->
                        @foreach ($dataloop as $item)

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                {{ $item['title'] }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item['counting'] }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas {{ $item['icon'] }} fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>
                <!--begin::Body-->
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Log Activity</span>
                    </h3>
                    <div class="card-toolbar">
                        <div class="d-flex">
                            <input type="text" class="m-1 form-control" placeholder="Search" id="search">
                            <button onclick="search()" type="button" class="m-1 btn btn-sm btn-light-primary"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="table" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Event</th>
                                    {{-- <th>Fitur</th> --}}
                                    <th>Url</th>
                                    <th>IP Adress</th>
                                    <th>User Agent</th>
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
                url: '{{ route("audit-trail") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    search: function () {
                        return document.getElementById('search').value;
                    },
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderlable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'event',
                    name: 'event'
                },
                // {
                //     data: 'auditable_type',
                //     name: 'auditable_type',
                //     render: function(data){
                //         return data.replace(`App\Models\Matakuliah`, '');
                //     }
                // },
                {
                    data: 'url',
                    name: 'url'
                },
                {
                    data: 'ip_address',
                    name: 'ip_address'
                },
                {
                    data: 'user_agent',
                    name: 'user_agent'
                },
            ],
        });
    });

    function search() {
        table.draw();
        console.log("search")
    }

    function syncSemester() {
        Swal.fire({
            title: 'Anda Yakin ingin Mengsinkronisasi ke Semester selanjutnya?',
            text: "Tindakan ini tidak dapat diurungkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'info',
                    title: "Mohon Tunggu!",
                    html: "Data sedang dalam proses upload",
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                $.ajax({
                    type: 'POST',
                    url: "{{url('sync-semester')}}",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.metadata.status == 'success') {
                            Swal.fire({
                                title: 'Sukses',
                                text: "Sukses mengsinkronisasi",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: data.metadata.message
                            });
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Dibatalkan',
                    'Proses dibatalkan',
                    'warning')
            }
        })
    }

</script>
<script>
    var options = {
        series: [{
            name: 'Jumlah Perolehan Nilai',
            data: []
        }],
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val;
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },

        xaxis: {
            categories: ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'E'],
            position: 'top',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val;
                }
            }

        },
        title: {
            text: 'Jumlah Perolehan Nilai',
            floating: true,
            offsetY: 330,
            align: 'center',
            style: {
                color: '#444'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    $.ajax({
        type: 'POST',
        url: "{{url('trend-nilai')}}",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (data) {
            let raw = [];
           raw.push(data.response['A']);
           raw.push(data.response['A-']);
           raw.push(data.response['B+']);
           raw.push(data.response['B']);
           raw.push(data.response['B-']);
           raw.push(data.response['C+']);
           raw.push(data.response['C']);
           raw.push(data.response['D']);
           raw.push(data.response['E']);
            chart.updateSeries([{
                data: raw
            }])
            console.log(raw)
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });

</script>
@endpush
