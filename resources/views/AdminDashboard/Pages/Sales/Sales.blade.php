@extends('AdminDashboard.Particals.app')

@section('title', 'Sales Page')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('AdminDashboard.Layouts.Sidenavbar')

            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Sale
                            </h4>

                            <div class="card p-4">
                                <div class="card-datatable table-responsive pt-0">
                                    <div class="d-flex mb-3">
                                        <div class="w-50 text-start">
                                            <h3>Sale Report Data</h3>
                                        </div>

                                        <div class="w-50 text-end">
                                            <a href="{{ route('admin.add.sales') }}" class="btn btn-primary">
                                                <i class="ti ti-plus me-sm-1"></i>
                                                <span class="mt-1">Add Sale Report</span>
                                            </a>
                                        </div>
                                    </div>
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Bill No.</th>
                                                <th class="text-center">Bill Date</th>
                                                <th class="text-center">GST No.</th>
                                                <th class="text-center">Parcel</th>
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
                                            var saleId = $(this).data('id');
                                            var $tableBody = $(`#sales-item-table-${saleId} tbody`);

                                            $tableBody.empty();

                                            $.ajax({
                                                url: `/admin/sales/${saleId}/items`,
                                                method: 'GET',
                                                success: function(response) {
                                                    response.forEach(function(item, index) {
                                                        $tableBody.append(`
                                                            <tr>
                                                                <td>${index + 1}</td>
                                                                <td>${item.unit}</td>
                                                                <td>${item.quantity}</td>
                                                                <td>${item.item_name}</td>
                                                                <td>${item.item_detail}</td>
                                                                <td>${item.price}</td>
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
                                                        url: "{{ route('admin.fetch.sales') }}",
                                                        dataType: "json",
                                                        dataSrc: "sales"
                                                    },
                                                    columns: [{
                                                            data: "id"
                                                        },
                                                        {
                                                            data: "customer_name"
                                                        },
                                                        {
                                                            data: "bill_no"
                                                        },
                                                        {
                                                            data: "bill_date"
                                                        },
                                                        {
                                                            data: "gst_no"
                                                        },
                                                        {
                                                            data: "parcel"
                                                        },
                                                        {
                                                            data: null,
                                                            render: function(data, type, row) {
                                                                return `<div>
                                                                    <a href="/admin/sales/edit/${row.id}" class="btn btn-sm btn-icon item-edit">
                                                                        <i class="text-primary ti ti-pencil"></i>
                                                                    </a>
                                                                    <a class="btn btn-sm btn-icon item-delete" href="javascript:void(0)" data-id="${row.id}">
                                                                        <i class="text-danger ti ti-trash"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="btn-view-details" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#exampleModal${row.id}">
                                                                        <i class="text-success ti ti-eye mx-2 ti-sm"></i>
                                                                    </a>
                                                                    <a href="/admin/sales/invoice/${row.id}" target="_blank" class="btn btn-sm btn-icon item-print">
                                                                        <i class="text-info ti ti-printer"></i>
                                                                    </a>
                                                                    <a class="btn btn-sm btn-icon item-mail" href="#" data-email="${row.customer_email}">
                                                                        <i class="text-primary ti ti-mail"></i>
                                                                    </a>

                                                                    <div class="modal fade" id="exampleModal${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">${row.bill_no}</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body text-start" id="modal-body-content">
                                                                                    <div class="sales-data">
                                                                                        <div class="border-bottom">
                                                                                            <h3 class="mb-1">Sales Data</h3>
                                                                                        </div>
                                                                                        <div class="d-flex">
                                                                                            <table class="w-50">
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Bill No.:</th>
                                                                                                    <td>${row.bill_no}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Customer GST No.:</th>
                                                                                                    <td>${row.gst_no}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">State Code:</th>
                                                                                                    <td>${row.state_code}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Transport GST TIN No.:</th>
                                                                                                    <td>${row.transport_gst_tin_no}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Grand Total:</th>
                                                                                                    <td class="fw-bold"><span class="border-bottom border-dark">${row.grand_total}</span></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table class="w-50">
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Customer Name:</th>
                                                                                                    <td>${row.customer_name}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Bill Date:</th>
                                                                                                    <td>${row.bill_date}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Place:</th>
                                                                                                    <td>${row.place}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Transport No.:</th>
                                                                                                    <td>${row.transport_no}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">Parcel:</th>
                                                                                                    <td>${row.parcel}</td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="customers-data mt-5">
                                                                                        <div class="border-bottom">
                                                                                            <h3 class="mb-1">Sales Item Data</h3>
                                                                                        </div>
                                                                                        <table class="table table-bordered mt-3" id="sales-item-table-${row.id}">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th class="fw-bold">No.</th>
                                                                                                    <th class="fw-bold">Unit</th>
                                                                                                    <th class="fw-bold">Quantity</th>
                                                                                                    <th class="fw-bold">Item Name</th>
                                                                                                    <th class="fw-bold">Item Details</th>
                                                                                                    <th class="fw-bold">Price</th>
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
                                                    lengthMenu: [7, 10, 25, 50, 75, 100],
                                                    responsive: true,
                                                    paging: true,
                                                    searching: true,
                                                    ordering: true,
                                                    drawCallback: function(settings) {
                                                        $('.item-mail').off('click').on('click', function(event) {
                                                            event.preventDefault();
                                                            const customer_email = $(this).data('email');
                                                            const saleId = $(this).closest('div').find('.btn-view-details').data('id');

                                                            Swal.fire({
                                                                title: 'Send Invoice',
                                                                text: `Send an invoice to ${customer_email}?`,
                                                                icon: 'info',
                                                                showCancelButton: true,
                                                                confirmButtonText: 'Yes, send it!'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    Swal.fire({
                                                                        title: 'Processing...',
                                                                        text: 'Generating invoice PDF and sending email, please wait...',
                                                                        allowOutsideClick: false,
                                                                        didOpen: () => {
                                                                            Swal.showLoading();
                                                                        }
                                                                    });

                                                                    $.ajax({
                                                                        url: '/admin/sales/send-invoice-pdf',
                                                                        method: 'POST',
                                                                        data: {
                                                                            email: customer_email,
                                                                            sale_id: saleId,
                                                                            _token: '{{ csrf_token() }}'
                                                                        },
                                                                        success: function(response) {
                                                                            Swal.fire({
                                                                                icon: 'success',
                                                                                title: 'Sent!',
                                                                                text: 'Invoice email has been sent with the PDF attachment.',
                                                                                confirmButtonText: 'OK'
                                                                            });
                                                                        },
                                                                        error: function(xhr, status, error) {
                                                                            Swal.fire({
                                                                                icon: 'error',
                                                                                title: 'Error!',
                                                                                text: 'An error occurred while sending the invoice.',
                                                                                confirmButtonText: 'OK'
                                                                            });
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        });

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
                                                                        url: '{{ route('admin.sales.delete', ':id') }}'
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
