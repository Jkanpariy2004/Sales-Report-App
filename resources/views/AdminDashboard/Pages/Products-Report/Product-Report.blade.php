@extends('AdminDashboard.Particals.app')

@section('title', 'Product Report Page')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('AdminDashboard.Layouts.Sidenavbar')

            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Products Report
                            </h4>

                            <div class="card p-4">
                                <div class="d-flex mb-3">
                                    <div class="w-50 text-start">
                                        <h3>Products Report Data</h3>
                                    </div>

                                </div>
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Product SKU</th>
                                                <th class="text-center">Product Name</th>
                                                <th class="text-center">Purchased Price</th>
                                                <th class="text-center">Sale Price</th>
                                                <th class="text-center">Profit & Loss</th>
                                                <th class="text-center">Available Stock</th>
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
                                                        url: "{{ route('fetch.product.report.data') }}",
                                                        dataType: "json",
                                                        dataSrc: "productsReport"
                                                    },
                                                    columns: [{
                                                            data: null,
                                                            render: function(data, type, row, meta) {
                                                                return meta.row + meta.settings._iDisplayStart + 1;
                                                            }
                                                        },
                                                        {
                                                            data: "product_sku"
                                                        },
                                                        {
                                                            data: "product_name"
                                                        },
                                                        {
                                                            data: null,
                                                            render: function(data, type, row) {
                                                                const P_Quantity = row.total_purchase_quantity;
                                                                const P_Price = row.purchase_cost;
                                                                return `(Q:- ${P_Quantity}) P:- ${P_Price}`;
                                                            }
                                                        },
                                                        {
                                                            data: null,
                                                            render: function(data, type, row) {
                                                                const S_Quantity = row.total_sale_quantity;
                                                                const S_Price = row.sale_price;

                                                                return `(Q:- ${S_Quantity}) P:- ${S_Price}`;
                                                            }
                                                        },
                                                        {
                                                            data: null,
                                                            render: function(data, type, row) {
                                                                const profitLoss = row.total_sale_quantity * row.sale_price - row.total_purchase_quantity * row.purchase_cost;
                                                                return `<b style="color: ${profitLoss >= 0 ? 'green' : 'red'};">${profitLoss}</b>`;
                                                            }
                                                        },
                                                        {
                                                            data: null,
                                                            render: function(data, type, row) {
                                                                return row.total_purchase_quantity - row
                                                                .total_sale_quantity;
                                                            }
                                                        }
                                                    ],
                                                    lengthMenu: [5, 10, 25, 50, 75, 100],
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
                                                                        url: '{{ route('admin.products.delete', ':id') }}'
                                                                            .replace(':id', id),
                                                                        method: 'GET',
                                                                        data: {
                                                                            _token: '{{ csrf_token() }}'
                                                                        },
                                                                        success: function(response) {
                                                                            Swal.fire({
                                                                                icon: 'success',
                                                                                title: 'Deleted!',
                                                                                text: 'The Product has been deleted.',
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
