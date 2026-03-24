@extends('layouts.master')
@section('title')
    Manager
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Manager @endslot
        @slot('title') Technician List @endslot
    @endcomponent
   
    
    <div class="row">
        @foreach ($technicians as $technician)
            <div class="col-xl-3 col-sm-6">
                <form action="{{ url('managers/assign_work') }}" method="POST">
                    @csrf
                <div class="card text-center">
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <div class="mb-4">
                            @if ($technician->avatar)
                                <img src="{{ url('storage/images/'.$technician->image) }}" alt=""
                                    class="avatar-lg rounded-circle img-thumbnail">
                            @else
                                <img src="{{ url('storage/images/'.$technician->image) }}" alt=""
                                    class="avatar-lg rounded-circle img-thumbnail">
                            @endif
                        </div>
                        <h5 class="font-size-16 mb-1"><a href="#" class="text-reset">{{ $technician->firstname }} {{ $technician->lastname }}</a></h5>
                        <p class="text-muted mb-1">ตำแหน่ง {{ $technician->position_name }}</p>
                        <p class="text-muted mb-1">แผนก {{ $technician->dep_name }}</p>

                    </div>
                  
                    <div class="btn-group" role="group">
                        
                        <input type="hidden" name="repair_id" value="{{ $repair_id }}"> 
                        <input type="hidden" name="technician_id" value="{{ $technician->id }}">
                        <button type="submit" class="btn btn-outline-light text-truncate assign-btn" 
                             data-technician-id="{{ $technician->id }}">
                            <i class="uil-file-check-alt"></i> มอบงาน
                        </button>
                        
                        
                    </div>
                </div>
            </form>
            </div>
        @endforeach
    </div>

@endsection