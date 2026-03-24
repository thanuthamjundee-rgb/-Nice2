@extends('layouts.master')
@section('title')
    Visitor
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Contacts @endslot
        @slot('title') Profile @endslot
    @endcomponent


    </style>
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="user-info">
                        <p>
                            <img src="{{ url('storage/images/' .Auth::user()->image )}}" alt="User Image"
                            class="img-fluid rounded-circle" style="width: 150px; hight: 150px" >
                        </p>
                        <p>
                           <strong>ชื่อ - นามสกุล :</strong> {{ $data->firstname }} {{ $data->lastname }}
                        </p>
                        <p>
                           <strong>ตำแหน่ง :</strong> {{ $data->position_name }}
                        </p>
                        <p>
                           <strong>แผนก :</strong> {{ $data->dep_name}}
                        </p>                     
                    </div>

                </div>
            </div>
            <!--end card-->
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Pie</h4>

                    <div id="pie_chart" data-colors='["--bs-success", "--bs-light", "--bs-warning"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!--end card-->
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Radial Chart</h4>

                    <div id="radial_chart" data-colors='["--bs-primary", "--bs-success", "--bs-info" ,"--bs-warning"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!--end card-->

        </div>
    </div>
    <!-- end row -->
    @endsection
    @section('script') 
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/apexcharts.init.js') }}"></script>
    @endsection
