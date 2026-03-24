@extends('layouts.master')
@section('title')
    @lang('Level')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Admin @endslot
        @slot('title') Level @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <a href="javascript:void(0);" onclick="openModal()" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-1"></i>สิทธิ์การใช้งาน</a>
                            </div>
                        </div>
                     
                            <div class="col-md-6">
                                <div class="form-inline float-md-end mb-3">
                                    <div class="search-box ms-2">
                                        <div class="position-relative">
                                            <form action="" id="search">
                                                <input type="text" class="form-control rounded bg-light border-0"
                                                    placeholder="Search..." id="search-input" name="search">
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
                                    <th scope="col" style="width: 90%;">สิทธิ์การใช้งาน</th>
                                    <th scope="col" style="width: 5%;">แก้ไข/ลบ</th>
                                </tr>
                            </thead>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->level_name}}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" 
                                                onclick="editModal(this)" 
                                                data-id="{{$item->id}}" 
                                                data-level-name="{{$item->level_name}}" 
                                                class="px-2 text-primary"><i
                                                class="uil uil-pen font-size-18"> </i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" 
                                                onclick="DeleteModal(this)"
                                                data-id="{{$item->id}}"
                                                data-level-name="{{$item->level_name}}" 
                                                class="px-2 text-danger"><i
                                                        class="uil uil-trash-alt font-size-18"></i></a>
                                            </li>
                                  
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="modal fade" tabindex="-1" id="exampleModal">
                        <form action="">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">จัดการข้อมูลสิทธิ์การใช้งาน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <input type="text" name="level_name" id="level_name" class="form-control" placeholder="กรอกข้อมูลสิทธิ์การใช้งาน">
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
    $('#id').val('');
    $('#level_name').val('');

    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();
}

function editModal(element){
    $('#id').val($(element).data('id'));
    $('#level_name').val($(element).data('level-name'));

    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();
}

function save(){
    let id = $('#id').val();
    let level_name = $('#level_name').val();

    let url = id === ''
        ? '{{ url("admins/level/add") }}'
        : '{{ url("admins/level/edit") }}';

    $.ajax({
        type:'POST',
        url: url,
        data: {
            id: id,
            name: level_name
        },
        success:function(data) {
            Swal.fire({
                title: data.mgs,
                icon: data.icon ?? 'success',
                timer: 1000,
                showConfirmButton: false,
                willClose: () => {
                    location.reload();
                }
            });
        }
    });
}

function DeleteModal(button){
    let id = $(button).data('id');
    let name = $(button).data('level-name');

    Swal.fire({
        title : 'ยืนยันการลบข้อมูลหรือไม่ ?',
        text  : name,
        icon  : 'warning',
        showCancelButton : true,
        confirmButtonText : 'ยืนยันลบ',
        cancelButtonText  : 'ยกเลิก',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type :'POST',
                url  :'{{ url("admins/level/del") }}',
                data : { id : id },
                success: function (data) {
                    Swal.fire({
                        title: data.mgs,
                        icon: data.icon,
                        timer: 1000,
                        showConfirmButton: false,
                        willClose: () => {
                            location.reload();
                        }
                    });
                }
            });
        }
    });
}

$('#search-input').change(function(){
    document.getElementById("search").submit();
});
</script>
@endsection
