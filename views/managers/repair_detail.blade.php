@extends('layouts.master')
@section('title', 'Repair Detail')

@section('content')
<style>
  .light-blue-header {
            background-color: #E0F7FA; /* Light blue background */
            padding: 10px;
            border-radius: 5px; /* Optional: Rounded corners */
        }
</style>

    <div class="col-md-12">
    <div class="card">
        <div class="card-header light-blue-header">
            <h4>รายละเอียดการแจ้งซ่อม</h4>
        </div>
        <div class="card-body">
            <p><strong>ใบแจ้งซ่อม:</strong> {{ $data->id }}</p>
            <p><strong>ประเภทอุปกรณ์:</strong> {{ $data->eq_name }}</p>
            <p><strong>ชื่ออุปกรณ์:</strong> {{ $data->r_name }}</p>
            <p><strong>ผู้แจ้งซ่อม:</strong> {{ $data->firstname }} {{ $data->lastname }}</p>
            <p><strong>หมายเลขเครื่อง:</strong> {{ $data->r_serialnumber }}</p>
            <p><strong>อาการ/สาเหตุ:</strong> {{ $data->r_detail }}</p>
            <p><strong>สถานที่แจ้งซ่อม:</strong> {{ $data->build_name }}, Floor: {{ $data->floor }}, Room: {{ $data->room }}</p>
            <p><strong>สถานะ:</strong> {{ $data->s_status }}</p>
            <p><strong>วันที่แจ้งซ่อม:</strong> {{ \Carbon\Carbon::parse($data->r_date)->format('d/m/Y') }}</p>
            <p><strong>ช่างผู้ดำเนินการซ่อม:</strong> </p>
            <a href="{{ url('managers/repair') }}" class="btn btn-primary">กลับหน้ารายการ</a>
            <button class="btn btn-success" onclick="window.print()">พิมพ์</button>
        </div>
    </div>
    </div>

@endsection