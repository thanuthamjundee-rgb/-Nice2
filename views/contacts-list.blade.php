@extends('layouts.master')
@section('title')
    Technicians
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            ระบบแจ้งซ่อมออนไลน์
        @endslot
        @slot('title')
            ข้อมูลประจำตัวผู้ใช้งาน
        @endslot
    @endcomponent
    <style>
    .user-info {
        display: flex;
        flex-direction: column; 
        align-items: center;
        text-align: left; 
    }
    </style>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="user-info">
                        <p>
                            <img src="{{ url('storage/images/' . Auth::user()->image) }}" alt="User Image" 
                                 class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                        </p>
                        <p><strong>ชื่อ - นามสกุล :</strong> {{ $data->firstname }} {{ $data->lastname }}</p>
                        <p><strong>ตำแหน่ง :</strong> {{ $data->position_name }}</p>
                        <p><strong>แผนก :</strong> {{ $data->dep_name }}</p>
                        <p><strong>ระดับสิทธิการใช้งาน :</strong> {{ $data->level_name }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">งานซ่อมที่ได้รับมอบหมาย</h4>
                    <div id="pie_chart" data-colors='["--bs-success", "--bs-primary", "--bs-warning" ,"--bs-info", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
   
    </div>
@endsection
@section('script') 
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var repairStatusData = @json($repairStatusCounts);

        var statusLabels = repairStatusData.map(item => item.s_status);
        var statusValues = repairStatusData.map(item => item.total);

        var pieOptions = {
            series: statusValues,
            chart: {
                type: 'pie',
                height: 300
            },
            labels: statusLabels,
            colors: ['#28a745', '#007bff', '#ffc107', '#17a2b8', '#dc3545'],
            legend: {
                position: 'bottom'
            }
        };

        var pieChart = new ApexCharts(document.querySelector("#pie_chart"), pieOptions);
        pieChart.render();
    });
</script>
@endsection