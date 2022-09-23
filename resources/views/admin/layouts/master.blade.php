<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
 @include('admin.layouts.partials._head')
</head>

<body data-sidebar="dark">

<div id="app">
    <!-- Begin page -->
    <div id="layout-wrapper">

    @include('admin.layouts.partials._header')

    <!-- ========== Left Sidebar Start ========== -->
    @include('admin.layouts.partials._sidebar')
    <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                @include('admin.layouts.partials._breadcrumb')
                <!-- end page title -->


                    <!-- Start Your Main Content Here-->
                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('admin.layouts.partials._footer')

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
</div>

<!-- JAVASCRIPT -->
@include('admin.layouts.partials._footer-script')

</body>
</html>
