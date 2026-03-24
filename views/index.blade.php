@extends('layouts.master')
@section('title')
    @lang('translation.User_List')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Contacts @endslot
        @slot('title') User List @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light"><i
                                        class="mdi mdi-plus me-2"></i> Add New</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-inline float-md-end mb-3">
                                <div class="search-box ms-2">
                                    <div class="position-relative">
                                        <input type="text" class="form-control rounded bg-light border-0"
                                            placeholder="Search...">
                                        <i class="mdi mdi-magnify search-icon"></i>
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
                                    <th scope="col">username</th>
                                    <th scope="col">first name</th>
                                    <th scope="col">last name</th>
                                    <th scope="col">gender</th>
                                    <th scope="col">status</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{$item->user_id}}</td>
                                    <td>{{$item->username}}</td>
                                    <td>{{$item->first_name}}</td>
                                    <td>{{$item->last_name}}</td>
                                    <td>{{$item->gender}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="px-2 text-primary"><i
                                                        class="uil uil-pen font-size-18"> </i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="px-2 text-danger"><i
                                                        class="uil uil-trash-alt font-size-18"></i></a>
                                            </li>
                                  
                                        </ul>
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
    <!-- end row -->
    @endsection
    @section('script') 
    dd(Auth::user()->level->level_name);

@endsection
