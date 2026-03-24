@extends('layouts.master')
@section('title', 'Manager')

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') ระบบแจ้งซ่อมออนไลน์ @endslot
        @slot('title') รายงานภาพรวม Dashboard @endslot
    @endcomponent

    <style>
        .card {
            min-height: 400px; /* ทำให้ทุกการ์ดสูงเท่ากัน */
        }
        .apex-charts {
            height: 320px !important; /* ทำให้กราฟสูงเท่ากัน */
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>

    <div class="row">
        <!-- ประเภทอุปกรณ์ -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">ประเภทอุปกรณ์</h4>
                    <div id="equipment_chart" data-colors='["--bs-success", "--bs-primary", "--bs-warning", "--bs-info", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                    <!-- ตารางข้อมูลประเภทอุปกรณ์ -->
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>ประเภทอุปกรณ์</th>
                                <th style="text-align: center;">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipmentData as $item)
                                <tr>
                                    <td>{{ $item->eq_name }}</td>
                                    <td style="text-align: center;">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- สถานะ -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">สถานะ</h4>
                    <div id="status_chart" data-colors='["--bs-success", "--bs-primary", "--bs-warning", "--bs-info", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                    <!-- ตารางข้อมูลสถานะ -->
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>สถานะ</th>
                                <th style="text-align: center;">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statusData as $item)
                                <tr>
                                    <td>{{ $item->s_status }}</td>
                                    <td style="text-align: center;">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- แผนก -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">แผนก</h4>
                    <div id="department_chart" data-colors='["--bs-success", "--bs-primary", "--bs-warning", "--bs-info", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                    <!-- ตารางข้อมูลแผนก -->
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>แผนก</th>
                                <th style="text-align: center;">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departmentData as $item)
                                <tr>
                                    <td>{{ $item->dep_name }}</td>
                                    <td style="text-align: center;">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script') 
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<script>
    function getChartColorsArray(chartId) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        return JSON.parse(colors).map(color => getComputedStyle(document.documentElement).getPropertyValue(color).trim());
    }

    // ประเภทอุปกรณ์
    var equipmentOptions = {
        series: @json($equipmentData->pluck('total')),
        chart: { type: 'pie', height: 320 },
        labels: @json($equipmentData->pluck('eq_name')),
        colors: getChartColorsArray("equipment_chart"),
        legend: { position: 'bottom', fontSize: '12px' } // ตัวหนังสือไว้ด้านล่าง
    };
    new ApexCharts(document.querySelector("#equipment_chart"), equipmentOptions).render();

    // สถานะ
    var statusOptions = {
        series: @json($statusData->pluck('total')),
        chart: { type: 'pie', height: 320 },
        labels: @json($statusData->pluck('s_status')),
        colors: getChartColorsArray("status_chart"),
        legend: { position: 'bottom', fontSize: '12px' } // ตัวหนังสือไว้ด้านล่าง
    };
    new ApexCharts(document.querySelector("#status_chart"), statusOptions).render();

    // แผนก
    var departmentOptions = {
        series: @json($departmentData->pluck('total')),
        chart: { type: 'pie', height: 320 },
        labels: @json($departmentData->pluck('dep_name')),
        colors: getChartColorsArray("department_chart"),
        legend: { position: 'bottom', fontSize: '12px' } // ตัวหนังสือไว้ด้านล่าง
    };
    new ApexCharts(document.querySelector("#department_chart"), departmentOptions).render();
</script>
@endsection