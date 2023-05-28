@extends('layouts.app')
@section('title')
   <h4 class="page-title">Dashboard</h4>
@endsection
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
   
   $logsCount = Illuminate\Support\Facades\Cache::remember('logsCount', now()->addDays(1), function () {
       return App\Models\Log::count();
   });
@endphp
@section('content')
   <div class="row">
      <div class="col-xxl-9">
         <div class="row d-flex justify-content-center">
            <div class="col-xl-2 col-lg-6">
               <div class="card">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                           <div class="avatar">
                              <div class="avatar-title rounded bg-primary bg-gradient">
                                 <i data-eva="pie-chart-2" class="fill-white"></i>
                              </div>
                           </div>
                        </div>
                        <div class="flex-grow-1">
                           <p class="text-muted mb-1">Users</p>
                           <h4 class="mb-0">{{ $usersCount }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-end ms-2">
                           <div class="badge rounded-pill font-size-13 badge-soft-success">+3
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
            <div class="col-xl-2 col-lg-6">
               <div class="card">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                           <div class="avatar">
                              <div class="avatar-title rounded bg-primary bg-gradient">
                                 <i data-eva="shopping-bag" class="fill-white"></i>
                              </div>
                           </div>
                        </div>
                        <div class="flex-grow-1">
                           <p class="text-muted mb-1">Karyawan</p>
                           <h4 class="mb-0">{{ $karyawanCount }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end ms-2">
                           <div class="badge rounded-pill font-size-13 badge-soft-success">+2
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
            <div class="col-xl-2">
               <div class="card">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                           <div class="avatar">
                              <div class="avatar-title rounded bg-primary bg-gradient">
                                 <i data-eva="people" class="fill-white"></i>
                              </div>
                           </div>
                        </div>
                        <div class="flex-grow-1">
                           <p class="text-muted mb-1">Marker</p>
                           <h4 class="mb-0">{{ $markerCount }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end ms-2">
                           <div class="badge rounded-pill font-size-13 badge-soft-danger">+3
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
            <!-- end col -->
            <div class="col-xl-2">
               <div class="card">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                           <div class="avatar">
                              <div class="avatar-title rounded bg-primary bg-gradient">
                                 <i data-eva="people" class="fill-white"></i>
                              </div>
                           </div>
                        </div>
                        <div class="flex-grow-1">
                           <p class="text-muted mb-1">Post</p>
                           <h4 class="mb-0">{{ $postsCount }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end ms-2">
                           <div class="badge rounded-pill font-size-13 badge-soft-danger">+3
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
            <!-- end col -->
            <div class="col-xl-2">
               <div class="card">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                           <div class="avatar">
                              <div class="avatar-title rounded bg-primary bg-gradient">
                                 <i data-eva="people" class="fill-white"></i>
                              </div>
                           </div>
                        </div>
                        <div class="flex-grow-1">
                           <p class="text-muted mb-1">Logs</p>
                           <h4 class="mb-0">{{ $logsCount }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end ms-2">
                           <div class="badge rounded-pill font-size-13 badge-soft-danger">+3
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
         </div>
      </div>
   </div>
   <!-- end row -->
@endsection
@push('scripts')
   <!-- apexcharts -->
   <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
   <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
@endpush
