@extends('AdminDashboard.Particals.app')

@section('title', 'Home Page')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('AdminDashboard.Layouts.Sidenavbar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <!-- Sales last year -->
                            <div class="col-xl-2 col-md-4 col-6 mb-4">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5 class="card-title mb-0">Sales</h5>
                                        <small class="text-muted">Last Year</small>
                                    </div>
                                    <div id="salesLastYear"></div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0">175k</h4>
                                            <small class="text-danger">-16.2%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sessions Last month -->
                            <div class="col-xl-2 col-md-4 col-6 mb-4">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5 class="card-title mb-0">Sessions</h5>
                                        <small class="text-muted">Last Month</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="sessionsLastMonth"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0">45.1k</h4>
                                            <small class="text-success">+12.6%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- / Content -->

                    @include('AdminDashboard.Layouts.footer')

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
@endsection
