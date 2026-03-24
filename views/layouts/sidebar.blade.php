<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

@php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$levelName = optional($user->level)->level_name;

if ($levelName == 'Admins') {
    $homeUrl = url('/index');
} elseif ($levelName == 'manager') {
    $homeUrl = url('/managers/index');
} elseif ($levelName == 'employee') {
    $homeUrl = url('/employees/index');
} elseif ($levelName == 'technician') {
    $homeUrl = url('/technicians/index');
} elseif ($levelName == 'visitor') {
    $homeUrl = url('/visitor/index');
} else {
    abort(403);
}
@endphp

    <div class="navbar-brand-box">
        <a href="{{ $homeUrl }}" class="logo logo-dark">
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/Screenshot 2024-06-29 161319.png') }}" alt="" height="60">
            </span>
        </a>

        <a href="{{ $homeUrl }}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo-devthai02.jpg') }}" alt="" height="20">
            </span>
        </a>
    </div>

    <button type="button"
        class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        <div id="sidebar-menu">

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">ระบบแจ้งซ่อมออนไลน์</li>

                {{-- ================= ADMIN ================= --}}
                @if($levelName == 'Admins')

                    <li><a href="{{ url('/index') }}"><i class="uil-home-alt"></i><span>หน้าหลัก</span></a></li>
                    <li><a href="{{ url('admins/user') }}"><i class="uil-users-alt"></i><span>จัดการสมาชิก</span></a></li>
                    <li><a href="{{ url('admins/level') }}"><i class="uil-edit-alt"></i><span>จัดการสิทธิ์</span></a></li>
                    <li><a href="{{ url('admins/position') }}"><i class="uil-edit-alt"></i><span>จัดการตำแหน่ง</span></a></li>
                    <li><a href="{{ url('admins/department') }}"><i class="uil-edit-alt"></i><span>จัดการแผนก</span></a></li>
                    <li><a href="{{ url('admins/building') }}"><i class="uil-building"></i><span>จัดการอาคาร</span></a></li>
                    <li><a href="{{ url('admins/equipment') }}"><i class="uil-desktop"></i><span>จัดการอุปกรณ์</span></a></li>

                {{-- ================= MANAGER ================= --}}
                @elseif($levelName == 'manager')

                    <li><a href="{{ url('/managers/index') }}"><i class="uil-home-alt"></i><span>หน้าหลัก</span></a></li>
                    <li><a href="{{ url('/managers/form_repair') }}"><i class="uil-chart-pie"></i><span>การแจ้งซ่อม</span></a></li>
                    <li><a href="{{ url('managers/repair') }}"><i class="uil-print"></i><span>รายงานแจ้งซ่อม</span></a></li>
                    <li><a href="{{ url('managers/dashboard') }}"><i class="uil-print"></i><span>Dashboard</span></a></li>

                {{-- ================= EMPLOYEE ================= --}}
                @elseif($levelName == 'employee')

                    <li><a href="{{ url('/employees/index') }}"><i class="uil-home-alt"></i><span>หน้าหลัก</span></a></li>
                    <li><a href="{{ url('/employees/form_repair') }}"><i class="uil-chart-pie"></i><span>แจ้งซ่อม</span></a></li>
                    <li><a href="{{ url('employees/repair') }}"><i class="uil-print"></i><span>รายการแจ้งซ่อม</span></a></li>

                {{-- ================= TECHNICIAN ================= --}}
                @elseif($levelName == 'technician')

                    <li><a href="{{ url('/technicians/index') }}"><i class="uil-home-alt"></i><span>หน้าหลัก</span></a></li>
                    <li><a href="{{ url('technicians/repair') }}"><i class="uil-print"></i><span>งานซ่อม</span></a></li>

                {{-- ================= VISITOR ================= --}}
                @elseif($levelName == 'visitor')

                    <li><a href="{{ url('/visitor/index') }}"><i class="uil-home-alt"></i><span>หน้าหลัก</span></a></li>
                    <li><a href="{{ url('/visitor/form_repair') }}"><i class="uil-chart-pie"></i><span>แจ้งซ่อม</span></a></li>
                    <li><a href="{{ url('/visitor/repair') }}"><i class="uil-print"></i><span>รายการแจ้งซ่อม</span></a></li>

                @endif

            </ul>

        </div>
    </div>

</div>
<!-- ========== Left Sidebar End ========== -->