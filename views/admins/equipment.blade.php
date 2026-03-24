@extends('layouts.master')

@section('title')
    @lang('Equipment')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Admin @endslot
        @slot('title') Equipment @endslot
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
                                    <i class="mdi mdi-plus me-1"></i> อุปกรณ์
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
                                                   placeholder="Search..."
                                                   name="search"
                                                   value="{{ request('search') }}">
                                        </form>
                                        <i class="mdi mdi-magnify search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="width: 90%">ชื่ออุปกรณ์</th>
                                    <th style="width: 200px;">แก้ไข/ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->eq_name }}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);"
                                                       onclick="editModal(this)"
                                                       data-id="{{ $item->id }}"
                                                       data-equip-name="{{ $item->eq_name }}"
                                                       class="px-2 text-primary">
                                                        <i class="uil uil-pen font-size-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);"
                                                       onclick="DeleteModal(this)"
                                                       data-id="{{ $item->id }}"
                                                       data-equip-name="{{ $item->eq_name }}"
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
                    <h5 class="modal-title">จัดการข้อมูลอุปกรณ์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text"
                           id="eq_name"
                           class="form-control"
                           placeholder="กรอกชื่ออุปกรณ์">

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
    $('#eq_name').val('');
    new bootstrap.Modal(document.getElementById('exampleModal')).show();
}

function editModal(el) {
    $('#id').val($(el).data('id'));
    $('#eq_name').val($(el).data('eq-name'));
    new bootstrap.Modal(document.getElementById('exampleModal')).show();
}

function save() {
    let id = $('#id').val();
    let eq_name = $('#eq_name').val();

    let url = id === ''
        ? '{{ url("admins/equipment/add") }}'
        : '{{ url("admins/equipment/edit") }}';

    $.post(url, {
        id: id,
        name: eq_name
    }, function (data) {
        Swal.fire({
            title: data.mgs,
            icon: data.icon,
            timer: 1000,
            showConfirmButton: false,
            willClose: () => location.reload()
        });
    });
}


function DeleteModal(el) {
    let id = $(el).data('id');
    let name = $(el).data('equip-name');

    Swal.fire({
        title: 'ยืนยันการลบข้อมูลหรือไม่ ?',
        text: name,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยันลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('{{ url("admins/equipment/del") }}', { id: id }, function (data) {
                Swal.fire({
                    title: data.mgs,
                    icon: data.icon,
                    timer: 1000,
                    showConfirmButton: false,
                    willClose: () => location.reload()
                });
            });
        }
    });
}
</script>
@endsection
