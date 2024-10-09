@extends('AdminDashboard.Particals.app')

@section('title', 'Customer Page')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('AdminDashboard.Layouts.Sidenavbar')

            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Customers
                            </h4>

                            <div class="card p-4">
                                <div class="card-datatable table-responsive pt-0">
                                    <div class="d-flex mb-3">
                                        <div class="w-50 text-start">
                                            <h3>Customers Data</h3>
                                        </div>

                                        <div class="w-50 text-end">
                                            <a href="{{ route('admin.add.customers') }}" class="btn btn-primary">
                                                <i class="ti ti-plus me-sm-1"></i>
                                                <span class="mt-1">Add Customers</span>
                                            </a>
                                        </div>
                                    </div>
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">GST No.</th>
                                                <th class="text-center">Place</th>
                                                <th class="text-center">State Code</th>
                                                <th class="text-center">Transport No.</th>
                                                <th class="text-center">Transport GST TIN No.</th>
                                                <th class="text-center">Parcel</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        </tbody>
                                    </table>

                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            @if (session('success'))
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success!',
                                                    text: "{{ session('success') }}",
                                                    confirmButtonText: 'OK'
                                                });
                                            @endif

                                            @if (session('error'))
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error!',
                                                    text: "{{ session('error') }}",
                                                    confirmButtonText: 'OK'
                                                });
                                            @endif

                                            $(document).ready(function() {
                                                $('#example').DataTable({
                                                    processing: true,
                                                    ajax: {
                                                        url: "{{ route('admin.fetch.customers') }}",
                                                        dataType: "json",
                                                        dataSrc: "customers"
                                                    },
                                                    columns: [{
                                                            data: "id"
                                                        },
                                                        {
                                                            data: "customer_name"
                                                        },
                                                        {
                                                            data: "gst_no"
                                                        },
                                                        {
                                                            data: "place"
                                                        },
                                                        {
                                                            data: "state_code"
                                                        },
                                                        {
                                                            data: "transport_no"
                                                        },
                                                        {
                                                            data: "transport_gst_tin_no"
                                                        },
                                                        {
                                                            data: "parcel"
                                                        },
                                                        {
                                                            data: null,
                                                            render: function(data, type, row) {
                                                                return `<div>
                                                                    <a href="/admin/customers/edit/${row.id}" class="btn btn-sm btn-icon item-edit">
                                                                        <i class="text-primary ti ti-pencil"></i>
                                                                    </a>
                                                                    <a class="btn btn-sm btn-icon item-delete" href="javascript:void(0)" data-id="${row.id}">
                                                                        <i class="text-danger ti ti-trash"></i>
                                                                    </a>
                                                                </div>`;
                                                            }
                                                        }
                                                    ],
                                                    lengthMenu: [7, 10, 25, 50, 75, 100],
                                                    responsive: true,
                                                    paging: true,
                                                    searching: true,
                                                    ordering: true,
                                                    drawCallback: function(settings) {
                                                        $('.item-delete').off('click').on('click', function(event) {
                                                            event.preventDefault();
                                                            const id = $(this).data('id');

                                                            Swal.fire({
                                                                title: 'Are you sure?',
                                                                text: "You won't be able to revert this!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Yes, delete it!'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    $.ajax({
                                                                        url: '{{ route('admin.customers.delete', ':id') }}'
                                                                            .replace(':id', id),
                                                                        method: 'GET',
                                                                        data: {
                                                                            _token: '{{ csrf_token() }}'
                                                                        },
                                                                        success: function(response) {
                                                                            Swal.fire({
                                                                                icon: 'success',
                                                                                title: 'Deleted!',
                                                                                text: 'The Customer has been deleted.',
                                                                                confirmButtonText: 'OK'
                                                                            }).then(() => {
                                                                                $('#example')
                                                                                    .DataTable()
                                                                                    .row($(event
                                                                                            .target
                                                                                        )
                                                                                        .closest(
                                                                                            'tr'
                                                                                        )
                                                                                    )
                                                                                    .remove()
                                                                                    .draw();
                                                                            });
                                                                        },
                                                                        error: function(xhr, status,
                                                                            error) {
                                                                            console.error(
                                                                                'Error deleting post:',
                                                                                xhr, status,
                                                                                error);
                                                                            Swal.fire({
                                                                                icon: 'error',
                                                                                title: 'Error!',
                                                                                text: 'An error occurred while deleting the Customer.',
                                                                                confirmButtonText: 'OK'
                                                                            });
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    }
                                                });

                                            });
                                        });
                                    </script>
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
