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
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <h5 class="card-header">Create Sales Report</h5>
                                <div class="card-body">
                                    <form id="SalesForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="customer" class="form-label">Select Customer</label>
                                                    <div class="dropdown">
                                                        <input type="text" id="customerSearch" class="form-control"
                                                            placeholder="Search Customer" onkeyup="filterCustomers()"
                                                            value="{{ $new->customer_id ? $customers->firstWhere('id', $new->customer_id)->customer_name : '' }}">
                                                        <select class="form-select" id="customer" name="customer"
                                                            size="5" onchange="fetchCustomerDetails()">
                                                            <option value="" hidden>Select Customer</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->id }}"
                                                                    {{ $new->customer_id == $customer->id ? 'selected' : '' }}>
                                                                    {{ $customer->customer_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback" id="customer-error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="bill_no" class="form-label">Bill No.</label>
                                                    <input type="text" class="form-control" name="bill_no" id="bill_no"
                                                        placeholder="Enter Bill No." value="{{ $new->bill_no }}" />
                                                    <div class="invalid-feedback" id="bill_no-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="bill_date" class="form-label">Bill Date</label>
                                                    <input type="text" class="form-control" name="bill_date"
                                                        id="bill_date" placeholder="Select Bill Date" id="bill_date"
                                                        value="{{ $new->bill_date }}" />
                                                    <div class="invalid-feedback" id="bill_date-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="gst_no" class="form-label">GST No.</label>
                                                    <input type="text" class="form-control" name="gst_no" id="gst_no"
                                                        placeholder="Enter GST No." value="{{ $new->gst_no }}" />
                                                    <div class="invalid-feedback" id="gst_no-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="place" class="form-label">Place</label>
                                                    <textarea type="text" class="form-control" name="place" id="place" placeholder="Enter Place">{{ $new->place }}</textarea>
                                                    <div class="invalid-feedback" id="place-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="state_code" class="form-label">State Code</label>
                                                    <input type="text" class="form-control" name="state_code"
                                                        id="state_code" placeholder="Enter State Code"
                                                        value="{{ $new->state_code }}" />
                                                    <div class="invalid-feedback" id="state_code-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="transport_no" class="form-label">Transport No.</label>
                                                    <input type="text" class="form-control" name="transport_no"
                                                        id="transport_no" placeholder="Enter Transport No."
                                                        value="{{ $new->transport_no }}" />
                                                    <div class="invalid-feedback" id="transport_no-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="transport_gst_tin_no" class="form-label">Tranport GST TIN
                                                        No.</label>
                                                    <input type="text" class="form-control"
                                                        name="transport_gst_tin_no" id="transport_gst_tin_no"
                                                        placeholder="Enter Transport GST TIN No."
                                                        value="{{ $new->transport_gst_tin_no }}" />
                                                    <div class="invalid-feedback" id="transport_gst_tin_no-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="parcel" class="form-label">Parcel</label>
                                                    <input type="text" class="form-control" name="parcel"
                                                        id="parcel" placeholder="Enter Parcel"
                                                        value="{{ $new->parcel }}" />
                                                    <div class="invalid-feedback" id="parcel-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card mb-4">
                                                <h5 class="card-header">Sales Items</h5>
                                                <table class="table table-bordered" id="salesReportTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Unit</th>
                                                            <th>Quantity</th>
                                                            <th>Item Name</th>
                                                            <th>Item Details</th>
                                                            <th>Price</th>
                                                            <th>HSN Code</th>
                                                            <th>Tax Type</th>
                                                            <th>Tax(%)</th>
                                                            <th>Total</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($SalesItems as $SalesItem)
                                                            <tr data-id="{{ $SalesItem->id }}" class="sales-item-row">
                                                                <td>
                                                                    <span class="view-mode">{{ $SalesItem->unit }}</span>
                                                                    <select class="form-select edit-mode" name="unit"
                                                                        style="display:none;">
                                                                        <option value="" hidden>Select Unit</option>
                                                                        <option value="P"
                                                                            {{ $SalesItem->unit == 'P' ? 'selected' : '' }}>
                                                                            P</option>
                                                                        <option value="M"
                                                                            {{ $SalesItem->unit == 'M' ? 'selected' : '' }}>
                                                                            M</option>
                                                                        <option value="K"
                                                                            {{ $SalesItem->unit == 'K' ? 'selected' : '' }}>
                                                                            K</option>
                                                                        <option value="G"
                                                                            {{ $SalesItem->unit == 'G' ? 'selected' : '' }}>
                                                                            G</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="view-mode">{{ $SalesItem->quantity }}</span>
                                                                    <input type="number" class="form-control edit-mode"
                                                                        name="quantity"
                                                                        value="{{ $SalesItem->quantity }}"
                                                                        style="display:none;" />
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="view-mode">{{ $SalesItem->item_name }}</span>
                                                                    <input type="text" class="form-control edit-mode"
                                                                        name="item_name"
                                                                        value="{{ $SalesItem->item_name }}"
                                                                        style="display:none;" />
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="view-mode">{{ $SalesItem->item_detail }}</span>
                                                                    <input type="text" class="form-control edit-mode"
                                                                        name="item_detail"
                                                                        value="{{ $SalesItem->item_detail }}"
                                                                        style="display:none;" />
                                                                </td>
                                                                <td>
                                                                    <span class="view-mode">{{ $SalesItem->price }}</span>
                                                                    <input type="number" class="form-control edit-mode"
                                                                        name="price" value="{{ $SalesItem->price }}"
                                                                        style="display:none;" />
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="view-mode">{{ $SalesItem->hsn_code }}</span>
                                                                    <input type="text" class="form-control edit-mode"
                                                                        name="hsn_code"
                                                                        value="{{ $SalesItem->hsn_code }}"
                                                                        style="display:none;" />
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="view-mode">{{ $SalesItem->tax_type }}</span>
                                                                    <select class="form-select edit-mode" name="tax_type"
                                                                        style="display:none;">
                                                                        <option value="" hidden>Select Tax Type
                                                                        </option>
                                                                        <option value="CGST/SGST"
                                                                            {{ $SalesItem->tax_type == 'CGST/SGST' ? 'selected' : '' }}>
                                                                            CGST/SGST
                                                                        </option>
                                                                        <option value="IGST"
                                                                            {{ $SalesItem->tax_type == 'IGST' ? 'selected' : '' }}>
                                                                            IGST</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <span class="view-mode">{{ $SalesItem->tax }}</span>
                                                                    <input type="number" class="form-control edit-mode"
                                                                        name="tax" value="{{ $SalesItem->tax }}"
                                                                        style="display:none;" />
                                                                </td>
                                                                <td>
                                                                    <span class="view-mode">{{ $SalesItem->total }}</span>
                                                                    <input type="number" class="form-control edit-mode"
                                                                        name="total" value="{{ $SalesItem->total }}"
                                                                        id="OldTotal" style="display:none;"
                                                                        onchange="calculateGrandTotal()" />
                                                                </td>
                                                                <td class="action-buttons">
                                                                    <a href="javascript:void(0);" class="edit-item"
                                                                        onclick="toggleEdit(this)">
                                                                        <i class="text-primary ti ti-pencil"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="confirmDelete({{ $SalesItem->id }})">
                                                                        <i class="text-danger ti ti-trash"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="7" class="text-end">Grand Total:</td>
                                                            <td colspan="2">
                                                                <input type="number" class="form-control"
                                                                    id="grandTotal" name="grandTotal" readonly />
                                                            </td>
                                                            <td>
                                                                <button type="button" id="addRow"
                                                                    class="btn btn-primary">Add</button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Update Sales Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('AdminDashboard.Layouts.footer')

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>

        <div class="drag-target"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        function confirmDelete(SalesItemId) {
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
                        url: '/admin/sales/delete-sales-item/' + SalesItemId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The sales item has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the sales item.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function toggleEdit(element) {
            const row = element.closest('tr');
            const units = row.querySelectorAll('.view-mode');
            const edits = row.querySelectorAll('.edit-mode');
            const actionButtons = row.querySelector('.action-buttons');

            units.forEach((unit, index) => {
                unit.style.display = unit.style.display === 'none' ? 'inline' : 'none';
                edits[index].style.display = edits[index].style.display === 'none' ? 'inline' : 'none';
            });

            actionButtons.innerHTML = `
                <button class="btn btn-success save-item" onclick="saveItem(${row.dataset.id}, this)">Save</button>
            `;

            calculateRowTotal(row);
        }

        function saveItem(id, element) {
            const row = element.closest('tr');
            const data = {
                unit: row.querySelector('select[name="unit"]').value,
                quantity: row.querySelector('input[name="quantity"]').value,
                item_name: row.querySelector('input[name="item_name"]').value,
                item_detail: row.querySelector('input[name="item_detail"]').value,
                price: row.querySelector('input[name="price"]').value,
                hsn_code: row.querySelector('input[name="hsn_code"]').value,
                tax_type: row.querySelector('select[name="tax_type"]').value,
                tax: row.querySelector('input[name="tax"]').value,
                total: row.querySelector('input[name="total"]').value,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '/admin/sales/update-sales-item/' + id,
                method: 'POST',
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Item updated successfully.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.responseJSON?.message || 'Something went wrong. Please try again.';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }

            });
        }

        function calculateRowTotal(row) {
            const price = parseFloat(row.querySelector('input[name="price"]').value) || 0;
            const quantity = parseFloat(row.querySelector('input[name="quantity"]').value) || 0;
            const tax = parseFloat(row.querySelector('input[name="tax"]').value) || 0;

            const total = (price * quantity) + ((price * quantity) * (tax / 100));

            row.querySelector('input[name="total"]').value = total.toFixed(2);

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('input[name="total"]').forEach(function(input) {
                const total = parseFloat(input.value) || 0;
                grandTotal += total;
            });
            document.getElementById('grandTotal').value = grandTotal.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculateGrandTotal();

            document.querySelectorAll('input[name="price"], input[name="quantity"], input[name="tax"]')
                .forEach(function(input) {
                    input.addEventListener('input', function() {
                        const row = input.closest('tr');
                        calculateRowTotal(row);
                    });
                });
        });

        function filterCustomers() {
            const input = document.getElementById('customerSearch').value.toLowerCase();
            const dropdown = document.getElementById('customer');
            const options = dropdown.options;

            for (let i = 1; i < options.length; i++) {
                const option = options[i];
                option.style.display = option.text.toLowerCase().includes(input) ? '' : 'none';
            }
        }

        function fillSearchTextbox() {
            const dropdown = document.getElementById('customer');
            const selectedOption = dropdown.options[dropdown.selectedIndex];
            const searchTextbox = document.getElementById('customerSearch');

            searchTextbox.value = selectedOption.text;
        }

        document.getElementById('customer').addEventListener('change', fillSearchTextbox);

        $(document).ready(function() {
            $('input, select, textarea').on('input', function() {
                $(this).removeClass('is-invalid');
                $('#' + $(this).attr('id') + '-error').text('');
            });

            $('#SalesForm').on('submit', function(e) {
                e.preventDefault();

                var isValid = true;

                if (isValid) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('update.sales', $new->id) }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href = '{{ route('admin.sales') }}';
                            });
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').text('');

                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '-error').text(value[0]);
                            });
                        }
                    });
                }
            });

            flatpickr("#bill_date", {
                dateFormat: "d-m-Y"
            });

            function calculateGrandTotal() {
                let grandTotal = 0;

                $('#salesReportTable tbody tr').each(function() {
                    let rowTotal = parseFloat($(this).find('input[name="total[]"]').val()) || 0;
                    let OldTotal = parseFloat($(this).find('input[id="OldTotal"]').val()) || 0;
                    grandTotal = rowTotal + grandTotal + OldTotal;
                });

                $('#grandTotal').val(grandTotal.toFixed(2));
            }

            $('#salesReportTable').on('input',
                'input[name="quantity[]"], input[name="price[]"], input[name="tax[]"]',
                function() {
                    let row = $(this).closest('tr');
                    let quantity = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
                    let price = parseFloat(row.find('input[name="price[]"]').val()) || 0;
                    let taxPercentage = parseFloat(row.find('input[name="tax[]"]').val()) || 0;

                    let subtotal = quantity * price;

                    let taxAmount = (subtotal * taxPercentage) / 100;

                    let total = subtotal + taxAmount;

                    row.find('input[name="total[]"]').val(total.toFixed(2));

                    calculateGrandTotal();
                });

            $('#addRow').click(function() {
                addRow();
            });

            function addRow() {
                $('#salesReportTable tbody').append(`
                    <tr>
                        <td>
                            <select class="form-select" name="unit[]">
                                <option value="" hidden>Select Unit</option>
                                <option value="P">P</option>
                                <option value="M">M</option>
                                <option value="K">K</option>
                                <option value="G">G</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control" name="quantity[]" placeholder="Enter Quantity"></td>
                        <td><input type="text" class="form-control" name="item_name[]" placeholder="Enter Item Name"></td>
                        <td><input type="text" class="form-control" name="item_details[]" placeholder="Enter Item Details"></td>
                        <td><input type="number" class="form-control" name="price[]" placeholder="Enter Item Price"></td>
                        <td><input type="text" class="form-control" name="hsn_code[]" placeholder="Enter Item HSN Code"></td>
                        <td>
                            <select class="form-select" name="tax_type[]">
                                <option value="" hidden>Select Tax Type</option>
                                <option value="CGST/SGST">CGST/SGST</option>
                                <option value="IGST">IGST</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control" name="tax[]" placeholder="Enter Tax Percentage"></td>
                        <td><input type="number" class="form-control" name="total[]" placeholder="Total" readonly></td>
                        <td>
                            <button type="button" class="btn removeRow"><i class="text-danger ti ti-trash"></i></button>
                        </td>
                    </tr>
                `);

                calculateGrandTotal();
            }

            $('#salesReportTable').on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
                calculateGrandTotal();
            });

        });

        function fetchCustomerDetails() {
            var customerId = $('#customer').val();
            if (customerId) {
                $.ajax({
                    url: '{{ route('customer.details', '') }}/' + customerId,
                    type: 'GET',
                    success: function(response) {
                        $('#gst_no').val(response.gst_no);
                        $('#place').val(response.place);
                        $('#transport_no').val(response.transport_no);
                        $('#state_code').val(response.state_code);
                        $('#transport_gst_tin_no').val(response.transport_gst_tin_no);
                    },
                    error: function(xhr) {
                        console.error('Error fetching customer details:', xhr);
                    }
                });
            } else {
                $('#gst_no').val('');
                $('#place').val('');
                $('#transport_no').val('');
                $('#state_code').val('');
                $('#transport_gst_tin_no').val('');
            }
        }
    </script>

@endsection
