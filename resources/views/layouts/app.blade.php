<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <title>{{ $title . ' - ' . config('app.name') }}</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta content="Mutlipurpose App" name="description" />
   <meta content="Multipurpose App" name="ilhamprabuzakys" />
   <!-- App favicon -->
   <link rel="shortcut icon" href="{{ asset('icon.png') }}">

   {{-- Box Icons Css --}}
   <link rel="stylesheet" href="{{ asset('assets/libs/box-icons/css/boxicons.min.css') }}">
   <!-- Bootstrap Css -->
   <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-style"/>
   <!-- Icons Css -->
   <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- App Css-->
   <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
   @stack('style')
   @stack('head')
   @vite('resources/css/app.css')
</head>


<body data-sidebar="dark">

   @php
      $auth = cache()->remember('auth-user', 60*60*24, function() {
         return auth()->user();
      })
   @endphp
   <!-- <body data-layout="horizontal"> -->

   <!-- Begin page -->
   <div id="layout-wrapper">


      @include('layouts.components.header')
      <!-- ========== Left Sidebar Start ========== -->
      <div class="vertical-menu">

         <!-- LOGO -->
         <div class="navbar-brand-box">
            {{-- <a href="{{ route('home') }}" class="logo logo-dark">
               <span class="logo-sm">
                  <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="" height="22">
               </span>
               <span class="logo-lg">
                  <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="22">
               </span>
            </a> --}}

            <a href="{{ route('home') }}" class="logo logo-light">
               <span class="logo-lg">
                  <img src="{{ asset('assets/images/logo-combine.png') }}" alt="" width="155">
               </span>
               <span class="logo-sm ">
                  <img src="{{ asset('icon.png') }}" alt="" width="30" class="me-2">
               </span>
            </a>
         </div>

         <button type="button" class="btn btn-sm px-3 header-item vertical-menu-btn topnav-hamburger">
            <div class="hamburger-icon">
               <span></span>
               <span></span>
               <span></span>
            </div>
         </button>

         <div data-simplebar class="sidebar-menu-scroll">

            <!--- Sidemenu -->
            @include('layouts.components.sidebar')
            <!-- Sidebar -->

            {{-- <div class="p-3 px-4 sidebar-footer">
                        <p class="mb-1 main-title"><script>document.write(new Date().getFullYear())</script> &copy; Borex.</p>
                        <p class="mb-0">Design & Develop by Themesbrand</p>
                    </div> --}}
         </div>
      </div>
      <!-- Left Sidebar End -->
      @include('layouts.components.sidebar-end')

      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="main-content">
         <div class="page-content">
            <div class="container-fluid" id="app">
               @include('components.session')

               @yield('content')
            </div>
            <!-- container-fluid -->
         </div>
         <!-- End Page-content -->

         <footer class="footer">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12">
                     <script>
                        document.write(new Date().getFullYear())
                     </script> &copy; Borex. Design & Develop by Themesbrand
                  </div>
               </div>
            </div>
         </footer>
      </div>
      <!-- end main content-->

   </div>
   <!-- END layout-wrapper -->

   <!-- Right Sidebar -->
   @include('layouts.components.customizer')
   <!-- /Right-bar -->

   <!-- Right bar overlay-->
   <div class="rightbar-overlay"></div>

   <!-- chat offcanvas -->
   <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasActivity" aria-labelledby="offcanvasActivityLabel">
      <div class="offcanvas-header border-bottom">
         <h5 id="offcanvasActivityLabel">Offcanvas right</h5>
         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
         ...
      </div>
   </div>

   @stack('modal')

   <!-- JAVASCRIPT -->
   <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
   <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
   <script src="{{ asset('assets/libs/eva-icons/eva.min.js') }}"></script>

   @stack('scripts')

   <script src="{{ asset('assets/js/app.js') }}"></script>
   @vite('resources/js/app.js')

</body>

</html>
