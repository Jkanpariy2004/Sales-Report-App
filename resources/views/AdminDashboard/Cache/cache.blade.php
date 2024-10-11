@extends('AdminDashboard.Particals.app')

@section('title', 'Cache Setting')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('AdminDashboard.Layouts.Sidenavbar')

            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Cache
                            </h4>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-statistics p-3 rounded">
                                        <div class="text-center">
                                            <h3>Cache Setting</h3>
                                        </div>
                                        <div id="alert-container">
                                            @if (session('success'))
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success!',
                                                            text: "{{ session('success') }}",
                                                            showConfirmButton: true
                                                        });
                                                    });
                                                </script>
                                            @endif
                                            @if (session('error'))
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error!',
                                                            text: "{{ session('error') }}",
                                                            showConfirmButton: true
                                                        });
                                                    });
                                                </script>
                                            @endif
                                        </div>
                                        <div>
                                            <button class="btn btn-primary mt-2"
                                                onclick="clearCache('admin/cache/cache-clear')">Cache
                                                Clear</button>
                                            <button class="btn btn-primary mt-2"
                                                onclick="clearCache('admin/cache/route-cache-clear')">Route
                                                Cache Clear</button>
                                            <button class="btn btn-primary mt-2"
                                                onclick="clearCache('admin/cache/config-cache-clear')">Config
                                                Cache Clear</button>
                                            <button class="btn btn-primary mt-2"
                                                onclick="clearCache('admin/cache/view-cache-clear')">View Cache
                                                Clear</button>
                                            <button class="btn btn-primary mt-2"
                                                onclick="clearCache('admin/cache/compiled-cache-clear')">Compiled File
                                                Clear</button>
                                            <button class="btn btn-primary mt-2"
                                                onclick="clearCache('admin/cache/optimize-cache-clear')">Optimize Cache
                                                Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                function clearCache(action) {
                                    $.ajax({
                                        url: '/' + action,
                                        type: 'GET',
                                        success: function(response) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: response.success,
                                                showConfirmButton: true
                                            });
                                        },
                                        error: function(xhr) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error!',
                                                text: 'An error occurred while clearing the cache.',
                                                showConfirmButton: true
                                            });
                                        }
                                    });
                                }
                            </script>


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
