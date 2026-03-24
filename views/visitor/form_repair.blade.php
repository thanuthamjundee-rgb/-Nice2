@extends('layouts.master')
@section('title')
    @lang('Repair')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') ลูกบ้าน @endslot
        @slot('title') แบบฟอร์มแจ้งซ่อม @endslot
    @endcomponent
 
    <style>
        .form-control {
            border: 1px solid rgba(0, 0, 0, 0.073);
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('visitor.repair.add') }}" method="POST">
                        @csrf
                          <!-- Firstname and Lastname (read-only) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">ผู้แจ้งซ่อม</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $fullName }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="eq_id" class="form-label">ประเภทอุปกรณ์</label>
                                <select class="form-select" id="eq_id" name="eq_id" required>
                                    <option value="" selected disabled>เลือกอุปกรณ์</option>
                                    @foreach($equipment as $eq)
                                        <option value="{{ $eq->id }}">{{ $eq->eq_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="r_name" class="form-label">ชื่ออุปกรณ์</label>
                                <input type="text" class="form-control" id="r_name" name="r_name" required placeholder="เช่น MacBook Pro">
                            </div>
                            <div class="col-md-3">
                                <label for="r_serialnumber" class="form-label">หมายเลขเครื่อง</label>
                                <input type="text" class="form-control" id="r_serialnumber" name="r_serialnumber" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="r_detail" class="form-label">อาการ/สาเหตุ</label>
                                <textarea class="form-control" id="r_detail" name="r_detail" rows="3" required></textarea>
                            </div>
    
                            <div class="col-md-3">
                                <label for="build_id" class="form-label">อาคาร/ตึก</label>
                                <select class="form-select" id="build_id" name="build_id" required>
                                    <option value="" selected disabled>เลือกอาคาร/ตึก</option>
                                    @foreach($buildings as $building)
                                        <option value="{{ $building->id }}">{{ $building->build_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="floor" class="form-label">ชั้น</label>
                                <input type="text" class="form-control" id="floor" name="floor">
                            </div>
                            <div class="col-md-2">
                                <label for="room" class="form-label">ห้อง</label>
                                <input type="text" class="form-control" id="room" name="room">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection

@section('script')
    <script>
        // Optional JavaScript for form enhancements can go here.
    </script>
@endsection