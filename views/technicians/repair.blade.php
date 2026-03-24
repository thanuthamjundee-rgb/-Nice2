@extends('layouts.master')
@section('title')
    @lang('Repair')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            technicians
        @endslot
        @slot('title')
            Repair
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">

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
                                    <th scope="col" style="width: 5%;">ID</th>
                                    <th scope="col" style="width: 10%;">ประเภทอุปกรณ์</th>
                                    <th scope="col" style="width: 10%;">ชื่ออุปกรณ์</th>
                                    <th scope="col" style="width: 10%;">หมายเลขเครื่อง</th>
                                    <th scope="col" style="width: 20%;">ผู้แจ้งซ่อม</th>
                                    <th scope="col" style="width: 20%;">สถานที่แจ้งซ่อม</th>
                                    <th scope="col" style="width: 10%;">วันที่แจ้งซ่อม</th>
                                    <th scope="col" style="width: 10%;">สถานะ</th>
                                    <th scope="col" style="width: 10%;">ปรับสถานะ</th>
                                </tr>
                            </thead>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->eq_name }}</td>
                                    <td>{{ $item->r_name }}</td>
                                    <td>{{ $item->r_serialnumber }}</td>
                                    <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                                    <td>{{ $item->build_name }} ชั้น {{ $item->floor }} ห้อง {{ $item->room }}</td>
                                    <td>{{ $item->r_date ? \Carbon\Carbon::parse($item->r_date)->format('d/m/Y') : 'ไม่ระบุ' }}
                                    </td>
                                    <td>{{ $item->s_status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#statusModal" data-id="{{ $item->id }}">
                                            ปรับสถานะ
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    {!! $data->links('layouts.pagination') !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Bootstrap -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('technicians/update_status') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">ปรับสถานะงานแจ้งซ่อม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="item-id" name="item_id">
                        <div class="mb-4">
                            <select class="form-select"  name="status" required>
                                <option value="" selected disabled>เลือกสถานะ</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->s_status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @section('script');
    <script>
        // เมื่อ Modal ถูกเปิด
        document.getElementById('statusModal').addEventListener('show.bs.modal', function (event) {
            // ดึงปุ่มที่เปิด Modal
            const button = event.relatedTarget;
    
            // ดึงค่า data-id จากปุ่ม
            const itemId = button.getAttribute('data-id');
    
            // กำหนดค่าให้กับฟิลด์ที่ซ่อนอยู่ (item-id)
            document.getElementById('item-id').value = itemId;
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') }}',
                timer: 2000, // แสดง 1 วินาที
                showConfirmButton: false
            });
        @endif

        $('#search-input').change(function() {
            document.getElementById("search").submit();
        });
    </script>
@endsection
@endsection