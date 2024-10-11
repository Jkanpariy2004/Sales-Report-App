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
                            <div class="col-xl-2 col-md-4 col-6 mb-4">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h3 class="card-title mb-0">Customers</h3>
                                    </div>
                                    <div id="salesLastYear"></div>
                                    <div class="card-body pt-0">
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0 text-primary" id="customerCount">{{ $Customer }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-md-4 col-6 mb-4">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h3 class="card-title mb-0">Bills</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="sessionsLastMonth"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0 text-primary" id="billCount">{{ $Bill }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function animateCount(element, start, end, duration) {
                            let startTimestamp = null;
                            const step = (timestamp) => {
                                if (!startTimestamp) startTimestamp = timestamp;
                                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                                element.innerText = Math.floor(progress * (end - start) + start);
                                if (progress < 1) {
                                    window.requestAnimationFrame(step);
                                }
                            };
                            window.requestAnimationFrame(step);
                        }

                        document.addEventListener('DOMContentLoaded', () => {
                            animateCount(document.getElementById('customerCount'), 0, {{ $Customer }}, 2000);
                            animateCount(document.getElementById('billCount'), 0, {{ $Bill }}, 2000);
                        });
                    </script>

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
