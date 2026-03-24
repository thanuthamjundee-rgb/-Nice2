@extends('layouts.master')
@section('title')
    @lang('User')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Admin @endslot
        @slot('title') User List @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <a href="javascript:void(0);" onclick="openModal()" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-1"></i>สมาชิก</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-inline float-md-end mb-3">
                                <div class="search-box ms-2">
                                    <div class="position-relative">
                                        <form action="" id="search">
                                        <input type="text" class="form-control rounded bg-light border-0" name="search"
                                            placeholder="Search...">
                                        <i class="mdi mdi-magnify search-icon"></i>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <!-- end row -->
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0" id="userTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">ชื่อ-นามสกุล</th>
                                    <th scope="col">อีเมล์</th>
                                    <th scope="col">เบอร์โทร</th>
                                    <th scope="col">ตำแหน่ง</th>
                                    <th scope="col">แผนก</th>
                                    <th scope="col">สิทธิ์</th>
                                    <th scope="col" style="width: 200px;">แก้ไข/ลบ</th>
                                </tr>
                            </thead>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>   
                                    <td><img src="{{ url('storage/images/'.$item->image) }}" alt=""class="avatar-xs rounded-circle me-2">
                                        {{$item->firstname}} {{$item->lastname}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->mobile}}</td>
                                    <td>{{$item->position_name}}</td>
                                    <td>{{$item->dep_name}}</td>
                                    <td>{{$item->level_name}}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="px-2 text-primary"
                                                onclick="editModal(this)" 
                                                data-id="{{$item->id}}" 
                                                data-email="{{$item->email}}" 
                                                data-password="{{$item->password}}" 
                                                data-first-name="{{$item->firstname}}" 
                                                data-last-name="{{$item->lastname}}" 
                                                data-mobile="{{$item->mobile}}" 
                                                data-p-id="{{$item->p_id}}" 
                                                data-dep-id="{{$item->dep_id}}" 
                                                data-level-id="{{$item->level_id}}"
                                          
                                               >
                                                    <i class="uil uil-pen font-size-18"> </i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" 
                                                onclick="DeleteModal(this)"
                                                data-id="{{$item->id}}"
                                                data-first-name="{{$item->firstname}}"
                                                data-last-name="{{$item->lastname}}" 
                                                class="px-2 text-danger"><i
                                                        class="uil uil-trash-alt font-size-18"></i></a>
                                            </li>
                                  
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <style>
                        .form-control {
                            border: 1px solid black;
                        }
                    </style>
                    
                    <div class="modal fade" tabindex="-1" id="exampleModal">
                        <form id="saveData" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-dialog modal-lg"> <!-- Set to large modal -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">จัดการข้อมูลสมาชิก</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Row 1: Email and Password -->
                                        <div class="row mt-1">
                                            <div class="col-6">
                                                <label for="email" class="col-form-label">อีเมล:</label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="กรอกอีเมล" required>
                                            </div>
                                            <div class="col-6" id="password-input">
                                                <label for="password" class="col-form-label">รหัสผ่าน:</label>
                                                <input type="password" name="password" id="password" class="form-control" placeholder="กรอกรหัสผ่าน">
                                            </div>
                                        </div>
                                          <!-- Row 4: Name -->
                                          <div class="row mt-2">
                                            <div class="col-6">
                                                <label for="firstname" class="col-form-label">ชื่อ:</label>
                                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="กรอกชื่อ">
                                            </div>
                                            <div class="col-6">
                                                <label for="lastname" class="col-form-label">นามสกุล:</label>
                                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="กรอกนามสกุล">
                                            </div>
                                        </div>
                                        <!-- Row 2: Phone Number and Position -->
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <label for="mobile" class="col-form-label">เบอร์โทร:</label>
                                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="กรอกเบอร์โทร">
                                            </div>
                                            <div class="col-6">
                                                <label for="position" class="col-form-label">ตำแหน่ง:</label>
                                                <select name="p_id" id="position" class="form-control">
                                                    <option value="" selected>-เลือกตำแหน่ง-</option>
                                                    @foreach($positions as $position)
                                                        <option value="{{ $position->id }}">{{ $position->position_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                    
                                        <!-- Row 3: Department and Permissions -->
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <label for="department" class="col-form-label">แผนก:</label>
                                                <select name="dep_id" id="department" class="form-control">
                                                    <option value="" selected>-เลือกแผนก-</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label for="userLevel" class="col-form-label">สิทธิ์การใช้งาน:</label>
                                                <select name="level_id" id="userLevel" class="form-control">
                                                    <option value="" selected>-เลือกสิทธิ์การใช้งาน-</option>
                                                    @foreach($userLevels as $userLevel)
                                                        <option value="{{ $userLevel->id }}">{{ $userLevel->level_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Image Upload -->
                                            <div class="row mt-1">
                                                <div class="col-12">
                                                    <label for="image" class="col-form-label">อัปโหลดภาพ:</label>
                                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" id="id" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="button" onclick="save()" class="btn btn-primary">บันทึกข้อมูล</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    
                    {!! $data->links('layouts.pagination') !!}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection
    @section('script') 
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    function openModal() {
    $('#password-input').show();
    $('#saveData')[0].reset();
    $('#id').val('');
    $('#exampleModal').modal('show');
}

function editModal(element){
    $('#password-input').hide();
    $('#id').val($(element).data('id'));
    $('#email').val($(element).data('email'));
    $('#password').val('');
    $('#firstname').val($(element).data('first-name'));
    $('#lastname').val($(element).data('last-name'));
    $('#mobile').val($(element).data('mobile'));
    $('#position').val($(element).data('p-id'));
    $('#department').val($(element).data('dep-id'));
    $('#userLevel').val($(element).data('level-id'));
    $('#exampleModal').modal('show');
}

function save() {
    let form = document.getElementById('saveData');
    let formData = new FormData(form);

    let id = document.getElementById('id').value;
    let url = id 
    ? "{{ url('admins/user/edit') }}"
    : "{{ url('admins/user/add') }}";


    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            Swal.fire({
                icon: res.icon,
                text: res.mgs
            }).then(() => {
                location.reload();
            });
        },
        error: function (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                text: 'เกิดข้อผิดพลาด'
            });
        }
    });
}


        function DeleteModal(button){
            id = $(button).data('id');
            name = $(button).data('first-name');
            lastname = $(button).data('last-name');
            const fullName = `${name} ${lastname}`;
            Swal.fire({
                title   : 'ยืนยันการลบข้อมูลหรือไม่ ?',
                text    : `${fullName}`, 
                icon    : 'warning',
                showCancelButton    : true,
                confirmButtonColor  : '#3085d6',
                cancelButtonColor   : '#d33',
                confirmButtonText   : 'ยืนยันลบ',
                cancelButtonText    : 'ยกเลิก',
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        url : '{{url('admins/user/del')}}',
                        type :'POST',
                        data : { 
                            id : id,
                           
                        },
                        success: function (data) {
                            Swal.fire({
                                title: data.mgs,
                                html: '',
                                icon: data.icon,
                                timer: 1000,
                                showConfirmButton: false,
                                willClose: () => {
                                        window.location.href = '';
                                    clearInterval(timerInterval);
                                }
                            });
                        }, error: function (data) {
                            // console.log(response);
                        }
                    });

                }

            });
        }
        $('#search-input').change(function(){
            document.getElementById("search").submit();
        })

    </script>
@endsection