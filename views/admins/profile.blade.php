@extends('layouts.master')
@section('title')
    @lang('User Profile')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') User @endslot
        @slot('title') Profile @endslot
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
                    <h5 class="mb-3">ข้อมูลส่วนตัว</h5>
                    
                    <form action="{{ url('admins/profile/update') }}" method="POST" id="saveData" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                        
                        <!-- Email and Password Row -->
                        <div class="row mt-1">
                            <div class="col-6">
                                <label for="email" class="col-form-label">อีเมล:</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="col-6">
                                <label for="password" class="col-form-label">รหัสผ่านใหม่:</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่">
                            </div>
                        </div>

                        <!-- Name Row -->
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="firstname" class="col-form-label">ชื่อ:</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ $user->firstname }}">
                            </div>
                            <div class="col-6">
                                <label for="lastname" class="col-form-label">นามสกุล:</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname }}">
                            </div>
                        </div>

                        <!-- Phone Number and Position Row -->
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="mobile" class="col-form-label">เบอร์โทร:</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $user->mobile }}">
                            </div>
                            <!-- Image Upload -->
                            <div class="col-6">
                                <label for="image" class="col-form-label">อัปโหลดภาพ:</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        </div>
                            
                        

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script>
        @if(session('mgs'))
            Swal.fire({
                title: "{{ session('mgs') }}",
                html: '',
                icon: "{{ session('icon') }}",
                timer: 1000,
                showConfirmButton: false,
                willClose: () => {
                    window.location.href = '';
                    clearInterval(timerInterval);
                }
            });
        @endif
    </script>
@endsection