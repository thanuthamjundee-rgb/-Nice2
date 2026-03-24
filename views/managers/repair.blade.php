@extends('layouts.master')

@section('title')
    @lang('Repair')
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('pagetitle') Manager @endslot
        @slot('title') รายการแจ้งซ่อม @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    {{-- Search --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="float-md-end">
                                <form method="GET">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control bg-light border-0"
                                               placeholder="Search..."
                                               name="search"
                                               value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            ค้นหา
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>ประเภทอุปกรณ์</th>
                                    <th>ชื่ออุปกรณ์</th>
                                    <th>หมายเลขเครื่อง</th>
                                    <th>ผู้แจ้งซ่อม</th>
                                    <th>สถานที่แจ้งซ่อม</th>
                                    <th>วันที่แจ้งซ่อม</th>
                                    <th>สถานะ</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->eq_name }}</td>
                                        <td>{{ $item->r_name }}</td>
                                        <td>{{ $item->r_serialnumber }}</td>
                                        <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                                        <td>
                                            {{ $item->build_name }}
                                            ชั้น {{ $item->floor }}
                                            ห้อง {{ $item->room }}
                                        </td>
                                        <td>
                                            {{ $item->r_date 
                                                ? \Carbon\Carbon::parse($item->r_date)->format('d/m/Y') 
                                                : '-' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $item->s_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">

                                                <a href="{{ url('managers/repair_detail', $item->id) }}"
                                                   class="text-primary">
                                                    <i class="uil uil-file-search-alt font-size-18"></i>
                                                </a>

                                                <a href="{{ url('managers/repair_assign', $item->id) }}"
                                                   class="text-success">
                                                    <i class="uil uil-check-square font-size-18"></i>
                                                </a>

                                                <a href="{{ route('managers.repair_edit', $item->id) }}"
                                                   class="text-warning">
                                                    <i class="uil uil-pen font-size-18"></i>
                                                </a>

                                                <a href="javascript:void(0);"
                                                   class="text-danger"
                                                   onclick="DeleteModal(this)"
                                                   data-id="{{ $item->id }}"
                                                   data-r_name="{{ $item->r_name }}">
                                                    <i class="uil uil-trash-alt font-size-18"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            ยังไม่มีรายการแจ้งซ่อม
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {!! $data->links('layouts.pagination') !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')

<script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<script>
function DeleteModal(button) {

    let id = $(button).data('id');
    let name = $(button).data('r_name');

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
                url: '/managers/del',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
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
                },

                error: function () {
                    Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                }
            });

        }
    });
}
</script>

@endsection