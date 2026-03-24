@extends('layouts.master')

@section('title')
    @lang('Repair')
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('pagetitle') Visitor @endslot
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
                                <form action="" method="GET">
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
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
<script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- end row -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') }}',
                timer: 1000,  // แสดง 1 วินาที
                showConfirmButton: false
            });


        $('#search-input').change(function(){
            document.getElementById("search").submit();
        })

        </script>
    @endif
    @endsection
   
    @section('script') 

@endsection