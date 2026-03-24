@extends('layouts.master')
@section('title')
    @lang('Repair')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Employee @endslot
        @slot('title') Repair @endslot
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
                                    <th scope="col" style="width: 10%;">จัดการข้อมูลแจ้งซ่อม</th>     
                                </tr>
                            </thead>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->eq_name }}</td>
                                    <td>{{ $item->r_name }}</td>
                                    <td>{{ $item->r_serialnumber }}</td>
                                    <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                                    <td>{{ $item->build_name }} ชั้น {{ $item->floor}} ห้อง {{ $item->room}}</td>
                                    <td>{{ $item->r_date ? \Carbon\Carbon::parse($item->r_date)->format('d/m/Y') : 'ไม่ระบุ' }}</td>
                                    <td>{{ $item->s_status }}</td>
                                    <td>{{ $item->technician_firstname }} {{ $item->technician_lastname }}</td>
                                    <td>
                               
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    {!! $data->links('layouts.pagination') !!}
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