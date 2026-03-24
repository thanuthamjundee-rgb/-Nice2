@extends('layouts.master')

@section('title')
    @lang('Position')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Admin @endslot
        @slot('title') position @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <a href="javascript:void(0);"
                                   onclick="openModal()"
                                   class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-plus me-1"></i>ตำแหน่งงาน
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-inline float-md-end mb-3">
                                <div class="search-box ms-2">
                                    <div class="position-relative">
                                        <form action="" id="search">
                                        <input type="text"
                                               class="form-control rounded bg-light border-0"
                                               placeholder="Search..."name="search">
                                        </form>
                                        <i class="mdi mdi-magnify search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0" id="userTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="width: 90%">ตำแหน่งงาน</th>
                                    <th style="width: 200px;">แก้ไข/ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->position_name }}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" 
                                                    onclick="editModal(this)"
                                                    data-id="{{$item->id}}"
                                                    data-position-name="{{$item->position_name}}"
                                                    class="px-2 text-primary">
                                                        <i class="uil uil-pen font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" 
                                                    onclick="DeleteModal(this)"
                                                    data-id="{{$item->id}}"
                                                    data-position-name="{{$item->position_name}}"
                                                    class="px-2 text-danger">

                                                        <i class="uil uil-trash-alt font-size-18"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {!! $data->links('layouts.pagination') !!}

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">จัดการข้อมูลตำแหน่งงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text"
                           id="position_name"
                           class="form-control"
                           placeholder="กรอกข้อมูลตำแหน่งงาน">

                    <input type="hidden" id="id">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" onclick="save()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
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
    $('#position_name').val('');

    const modal = new bootstrap.Modal(
        document.getElementById('exampleModal')
    );
    modal.show();
}

function editModal(element) {
    $('#id').val($(element).data('id'));
    $('#position_name').val($(element).data('position-name'));

    const modal = new bootstrap.Modal(
        document.getElementById('exampleModal')
    );
    modal.show();
}

function save() {
    let id = $('#id').val();
    let position_name = $('#position_name').val();

    let url = id === ''
        ? '{{ url("admins/position/add") }}'
        : '{{ url("admins/position/edit") }}';

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id: id,
            name: position_name
        },
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

function DeleteModal(button) {
    let id = $(button).data('id');
    let name = $(button).data('position-name');

    Swal.fire({
        title: 'ยืนยันการลบข้อมูลหรือไม่ ?',
        text: name,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยันลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ url("admins/position/del") }}',
                type: 'POST',
                data: { id: id },
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

// 🔍 submit search อัตโนมัติ
$('#search-input').on('change', function () {
    document.getElementById('search').submit();
});
</script>
@endsection
