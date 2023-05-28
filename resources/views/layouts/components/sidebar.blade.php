@php
   $postsCount = Illuminate\Support\Facades\Cache::remember('postsCount', now()->addDays(1), function () {
       return App\Models\Post::count();
   });
   
   $usersCount = Illuminate\Support\Facades\Cache::remember('usersCount', now()->addDays(1), function () {
       return App\Models\User::count();
   });
   
   $karyawanCount = Illuminate\Support\Facades\Cache::remember('karyawanCount', now()->addDays(1), function () {
       return App\Models\Karyawan::count();
   });
   
   $markerCount = Illuminate\Support\Facades\Cache::remember('markerCount', now()->addDays(1), function () {
       return App\Models\Coordinate::count();
   });
@endphp
<div id="sidebar-menu">
   <!-- Left Menu Start -->
   <ul class="metismenu list-unstyled" id="side-menu">
      <li class="menu-title" data-key="t-menu">Menu</li>

      <li class="{{ Request::is('dashboard') ? 'mm-active' : '' }}">
         <a href="{{ route('home') }}">
            <i class="icon nav-icon" data-eva="grid-outline"></i>
            <span class="menu-item" data-key="t-dashboards">Dashboards</span>
         </a>
         {{-- <ul class="sub-menu" aria-expanded="false">
                <li><a href="index.html" data-key="t-ecommerce">Ecommerce</a></li>
                <li><a href="dashboard-saas.html" data-key="t-saas">Saas</a></li>
                <li><a href="dashboard-crypto.html" data-key="t-crypto">Crypto</a></li>
            </ul> --}}
      </li>
      <li class="{{ Request::is('chat') ? 'mm-active' : '' }}">
         <a href="{{ route('chat.index') }}">
            <i class="icon nav-icon" data-eva="grid-outline"></i>
            <span class="menu-item" data-key="t-chats">ChatApp</span>
         </a>
      </li>

      <li class="menu-title" data-key="t-applications">DATA</li>

      <li class="{{ Request::is('karyawan*') ? 'mm-active' : '' }}">
         <a href="{{ route('karyawan.index') }}">
            <i class="icon nav-icon" data-eva="people-outline"></i>
            <span class="menu-item" data-key="t-authentication">Karyawan</span>
            <span class="badge rounded-pill badge-soft-primary">{{ $karyawanCount }}</span>
         </a>
      </li>
      {{--  
        <li class="{{ Request::is('master*') ? 'mm-active' : '' }}">
            <a href="apps-calendar.html">
                <i class="icon nav-icon" data-eva="calendar-outline"></i>
                <span class="menu-item" data-key="t-calendar">Master Data</span>
            </a>
        </li> --}}

      <li class="{{ Request::is('map*') ? 'mm-active' : '' }}">
         <a href="{{ route('map.index') }}">
            <i class="icon nav-icon" data-eva="archive-outline"></i>
            <span class="menu-item" data-key="t-filemanager">Maps</span>
            <span class="badge rounded-pill badge-soft-primary">{{ $markerCount }}</span>
         </a>
      </li>

      <li class="{{ Request::is('post*') ? 'mm-active' : '' }}">
         <a href="#">
            <i class="icon nav-icon" data-eva="shopping-bag-outline"></i>
            <span class="menu-item" data-key="t-ecommerce">Posts</span>
            <span class="badge rounded-pill badge-soft-danger" data-key="t-hot">{{ $postsCount }}</span>
         </a>
      </li>
      <li class="{{ Request::is('log*') ? 'mm-active' : '' }}">
         <a href="{{ route('log.index') }}">
            <i class="icon nav-icon" data-eva="checkmark-square-outline"></i>
            <span class="menu-item" data-key="t-utility">Log</span>
         </a>
      </li>

      @can('admin')
         <li class="menu-title" data-key="t-pages">Admin</li>

         <li class="{{ Request::is('user*') ? 'mm-active' : '' }}">
            <a href="{{ route('users.index') }}">
               <i class="icon nav-icon" data-eva="people-outline"></i>
               <span class="menu-item" data-key="t-authentication">Users</span>
               <span class="badge rounded-pill badge-soft-primary">{{ $usersCount }}</span>
            </a>
         </li>
      @endcan
   </ul>
</div>
