<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
          
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="@lang('translation.Search')...">
                    <span class="uil-search"></span>
                </div>
            </form>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="uil-minus-path"></i>
                </button>
            </div>


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ url('storage/images/' . Auth::user()->image) }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">{{Str::ucfirst(Auth::user()->firstname)}} {{Str::ucfirst(Auth::user()->lastname)}}</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{url('admins/profile')}}"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">@lang('translation.View_Profile')</span></a>
                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">@lang('translation.Sign_out')</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
