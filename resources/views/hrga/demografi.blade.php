@extends('layouts.apps.master')
@section('title')
    Demografi Karyawan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @yield('title')
        @endslot
        @slot('title')
            @yield('title')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mt-3 mb-3">
                        Periode {{ $periode }}
                    </h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Berdasarkan Tingkatan</h4>
                                    <div id="berdasarkan-tingkatan"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Berdasarkan Gender</h4>
                                    <div id="berdasarkan-gender"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Berdasarkan Status Karyawan</h4>
                                    <div id="berdasarkan-status-karyawan"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div id="berdasarkan-departemen"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    {{-- <h4 class="card-title text-center">Berdasarkan Pendidikan</h4> --}}
                                    <div id="berdasarkan-pendidikan"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    {{-- <h4 class="card-title text-center">Berdasarkan Usia</h4> --}}
                                    <div id="berdasarkan-usia"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/apex-charts/apexcharts.min.js') }}"></script>

    <script>
        var options = {
            chart: {
                height: 320,
                type: 'pie',
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{{ $berdasarkan_tingkatan[0]->total_berdasarkan_tingkat.','.$berdasarkan_tingkatan[1]->total_berdasarkan_tingkat }}],
            labels: ["Staff", "Operator"],
            colors: ["#E85C0D", "#C7253E"],
            dataLabels: {
                formatter: (val, { seriesIndex, w }) => w.config.series[seriesIndex] // <--- HERE
            },
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '14px',
                offsetX: 0,
                offsetY: 6
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#berdasarkan-tingkatan"),
            options
        );

        chart.render();

        var options = {
            chart: {
                height: 320,
                type: 'pie',
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{{ $berdasarkan_gender[0]->jenis_kelamin.','.$berdasarkan_gender[1]->jenis_kelamin }}],
            labels: ["Laki - Laki", "Perempuan"],
            colors: ["#134B70", "#508C9B"],
            dataLabels: {
                formatter: (val, { seriesIndex, w }) => w.config.series[seriesIndex] // <--- HERE
            },
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '14px',
                offsetX: 0,
                offsetY: 6
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#berdasarkan-gender"),
            options
        );

        chart.render();

        var options = {
            chart: {
                height: 320,
                type: 'pie',
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{{ $berdasarkan_status_karyawan[0]->status_karyawan.','.$berdasarkan_status_karyawan[1]->status_karyawan }}],
            labels: ["Pekerja Tetap", "Pekerja Kontrak"],
            colors: ["#597445", "#F4CE14"],
            dataLabels: {
                formatter: (val, { seriesIndex, w }) => w.config.series[seriesIndex] // <--- HERE
            },
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '14px',
                offsetX: 0,
                offsetY: 6
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#berdasarkan-status-karyawan"),
            options
        );

        chart.render();

        var options = {
            series: [{
                data: [
                    {{ 
                        $berdasarkan_departemen[0]->id_departemen.','.
                        $berdasarkan_departemen[1]->id_departemen.','.
                        $berdasarkan_departemen[2]->id_departemen.','.
                        $berdasarkan_departemen[3]->id_departemen.','.
                        $berdasarkan_departemen[4]->id_departemen.','.
                        $berdasarkan_departemen[5]->id_departemen.','.
                        $berdasarkan_departemen[6]->id_departemen.','.
                        $berdasarkan_departemen[7]->id_departemen
                    }}
                ]
            }],
            labels: ["Finance & Accounting", "HRGA", "Marketing", "Purchasing", "PPIC", "Production", "QC", "IT"],
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    horizontal: true,
                    dataLabels: {
                        position: 'top',
                        colors: ['#F96E2A']
                    }
                }
            },
            title: {
                text: 'Berdasarkan Departemen'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                    return val
                    }
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#F96E2A']
                },
                offsetX: 30
            },
            xaxis: {
                categories: ["Finance & Accounting", "HRGA", "Marketing", "Purchasing", "PPIC", "Production", "QC", "IT"],
                labels: {
                    formatter: function (val) {
                    return val
                    }
                }
            },
            colors: ["#FF8000"]
        };

        var chart = new ApexCharts(
            document.querySelector("#berdasarkan-departemen"),
            options
        );

        chart.render();

        // ----------------------------------------------------

        var options = {
            series: [{
                data: [
                    {{ 
                        $berdasarkan_pendidikan[5]->pendidikan.','.
                        $berdasarkan_pendidikan[4]->pendidikan.','.
                        $berdasarkan_pendidikan[3]->pendidikan.','.
                        $berdasarkan_pendidikan[2]->pendidikan.','.
                        $berdasarkan_pendidikan[1]->pendidikan.','.
                        $berdasarkan_pendidikan[0]->pendidikan
                    }}
                ]
            }],
            labels: ["Pascasarjana","D4/S1","D1 s.d D3","SMA","SMP","SD"],
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    horizontal: true,
                    dataLabels: {
                        position: 'top',
                        colors: ['#F96E2A']
                    }
                }
            },
            title: {
                text: 'Berdasarkan Pendidikan'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                    return val
                    }
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#F96E2A']
                },
                offsetX: 30
            },
            xaxis: {
                categories: ["Pascasarjana","D4/S1","D1 s.d D3","SMA","SMP","SD"],
                labels: {
                    formatter: function (val) {
                    return val
                    }
                }
            },
            colors: ["#1679AB"]
        };

        var chart = new ApexCharts(document.querySelector("#berdasarkan-pendidikan"), options);
        chart.render();

        // ----------------------------------------------------
        var options = {
            series: [{
                data: [
                    {{ 
                        $berdasarkan_usia[1]->total_age.','.
                        $berdasarkan_usia[2]->total_age.','.
                        $berdasarkan_usia[3]->total_age.','.
                        $berdasarkan_usia[4]->total_age
                    }}
                ]
            }],
            labels: ["<19 Tahun","19 Tahun - 30 Tahun","31 Tahun - 45 Tahun",">46 Tahun"],
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    horizontal: true,
                    dataLabels: {
                        position: 'top',
                        colors: ['#F96E2A']
                    }
                }
            },
            title: {
                text: 'Berdasarkan Usia'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                    return val
                    }
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#F96E2A']
                },
                offsetX: 30
            },
            xaxis: {
                categories: ["<19 Tahun","19 Tahun - 30 Tahun","31 Tahun - 45 Tahun",">46 Tahun"],
                labels: {
                    formatter: function (val) {
                    return val
                    }
                }
            },
            colors: ["#2A3663"]
        };

        var chart = new ApexCharts(document.querySelector("#berdasarkan-usia"), options);
        chart.render();
    </script>
@endsection
