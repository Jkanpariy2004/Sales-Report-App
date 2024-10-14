@extends('AdminDashboard.Particals.app')

@section('title', 'Purchase Page')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('AdminDashboard.Layouts.Sidenavbar')

            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Purchase
                            </h4>

                            <div class="card p-4">
                                <div class="d-flex mb-3">
                                    <div class="w-50 text-start">
                                        <h3>Purchase Data</h3>
                                    </div>

                                    <div class="w-50 text-end">
                                        <a href="{{ route('admin.add.purchase') }}" class="btn btn-primary">
                                            <i class="ti ti-plus me-sm-1"></i>
                                            <span class="mt-1">Add Purchase</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Supplier Name</th>
                                                <th class="text-center">Grand Total</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center" id="tbody_data">
                                        </tbody>
                                    </table>

                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $('#tbody_data').delegate('.btn-view-details', 'click', function() {
                                            console.log('dddd');

                                            var saleId = $(this).data('id');
                                            var $tableBody = $(`#sales-item-table-${saleId} tbody`);

                                            $tableBody.empty();

                                            $.ajax({
                                                url: `/admin/purchase/${saleId}/items`,
                                                method: 'GET',
                                                success: function(response) {
                                                    response.forEach(function(item, index) {
                                                        $tableBody.append(`
                                                            <tr>
                                                                <td>${index + 1}</td>
                                                                <td>${item.unit}</td>
                                                                <td>${item.quantity}</td>
                                                                <td>${item.item_name}</td>
                                                                <td>${item.item_details}</td>
                                                                <td>${item.cost}</td>
                                                                <td>${item.hsn_code}</td>
                                                                <td>${item.tax_type}</td>
                                                                <td>${item.tax}</td>
                                                                <td>${item.total}</td>
                                                            </tr>
                                                        `);
                                                    });

                                                    var grandTotal = response.reduce((total,
                                                        item) => total + parseFloat(
                                                        item
                                                        .total), 0);
                                                    $tableBody.append(`
                                                        <tr>
                                                            <th colspan="9" class="text-end fw-bold">Grand Total:</th>
                                                            <td><span class="fw-bold">${grandTotal}</span></td>
                                                        </tr>
                                                    `);
                                                },
                                                error: function() {
                                                    $tableBody.append(
                                                        `<tr><td colspan="10">Failed to load sales items.</td></tr>`
                                                    );
                                                }
                                            });
                                        });

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
                                                        url: "{{ route('fetch.purchase') }}",
                                                        dataType: "json",
                                                        dataSrc: "purchases"
                                                    },
                                                    columns: [{
                                                            data: "id"
                                                        },
                                                        {
                                                            data: "name"
                                                        },
                                                        {
                                                            data: "grand_total"
                                                        },
                                                        {
                                                            data: null,
                                                            render: function(data, type, row) {
                                                                return `<div>
                                                                    <a href="javascript:void(0)" class="btn-view-details" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#exampleModal${row.id}">
                                                                        <i class="text-success ti ti-eye mx-2 ti-sm"></i>
                                                                    </a>

                                                                    <a href="/admin/purchase/edit/${row.id}" class="btn btn-sm btn-icon item-edit">
                                                                        <i class="text-primary ti ti-pencil"></i>
                                                                    </a>

                                                                    <a class="btn btn-sm btn-icon item-delete" href="javascript:void(0)" data-id="${row.id}">
                                                                        <i class="text-danger ti ti-trash"></i>
                                                                    </a>

                                                                    <div class="modal fade" id="exampleModal${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">${row.name}</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body text-start" id="modal-body-content">
                                                                                    <div class="sales-data">
                                                                                        <div class="border-bottom">
                                                                                            <h3 class="mb-1">Purchase Data</h3>
                                                                                        </div>
                                                                                        <div class="d-flex">
                                                                                            <table class="w-50">
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Supplier Name:</th>
                                                                                                    <td>${row.name}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Supplier GST No.:</th>
                                                                                                    <td>${row.gst_no}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Grand Total:</th>
                                                                                                    <td class="fw-bold"><span class="border-bottom border-dark">${row.grand_total}</span></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table class="w-50">
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Supplier Email:</th>
                                                                                                    <td>${row.email}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Address:</th>
                                                                                                    <td>${row.address}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th></th>
                                                                                                    <th></th>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="customers-data mt-5">
                                                                                        <div class="border-bottom">
                                                                                            <h3 class="mb-1">Purchase Items Data</h3>
                                                                                        </div>
                                                                                        <table class="table table-bordered mt-3" id="sales-item-table-${row.id}">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">No.</th>
                                                                                                    <th class="fw-bold">Unit</th>
                                                                                                    <th class="fw-bold">Quantity</th>
                                                                                                    <th class="fw-bold">Item Name</th>
                                                                                                    <th class="fw-bold">Item Details</th>
                                                                                                    <th class="fw-bold">Cost</th>
                                                                                                    <th class="fw-bold">HSN Code</th>
                                                                                                    <th class="fw-bold">Tax Type</th>
                                                                                                    <th class="fw-bold">Tax(%)</th>
                                                                                                    <th class="fw-bold">Total</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <!-- Sales items will be injected here -->
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`;
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
                                                                        url: '{{ route('admin.purchase.producta.delete', ':id') }}'
                                                                            .replace(':id', id),
                                                                        method: 'GET',
                                                                        data: {
                                                                            _token: '{{ csrf_token() }}'
                                                                        },
                                                                        success: function(response) {
                                                                            Swal.fire({
                                                                                icon: 'success',
                                                                                title: 'Deleted!',
                                                                                text: response
                                                                                    .message,
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
