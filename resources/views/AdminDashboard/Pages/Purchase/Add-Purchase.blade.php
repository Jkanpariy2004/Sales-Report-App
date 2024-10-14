@extends('AdminDashboard.Particals.app')

@section('title', 'Add Purchase Page')

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
                                <h5 class="card-header">Create Purchase</h5>
                                <div class="card-body">
                                    <form id="SupplierForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="supplier" class="form-label">Select Supplier</label>
                                                    <div class="dropdown">
                                                        <input type="text" id="supplierSearch" class="form-control"
                                                            placeholder="Search Supplier" onkeyup="filterSupplier()">
                                                        <select class="form-select" id="supplier" name="supplier"
                                                            size="5">
                                                            <option value="" hidden>Select Supplier</option>
                                                            @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}">
                                                                    {{ $supplier->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback" id="supplier-error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card mb-4 p-1">
                                                <h5 class="card-header">Purchase Items</h5>
                                                <div style="overflow-x: auto">
                                                    <table class="table table-bordered" id="PurchaseItemTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Unit</th>
                                                                <th>Quantity</th>
                                                                <th>Item Name</th>
                                                                <th>Item Details</th>
                                                                <th>Cost</th>
                                                                <th>HSN Code</th>
                                                                <th>Tax Type</th>
                                                                <th>Tax(%)</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

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
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Add Purchase</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        function filterSupplier() {
            const input = document.getElementById('supplierSearch').value.toLowerCase();
            const dropdown = document.getElementById('supplier');
            const options = dropdown.options;

            for (let i = 1; i < options.length; i++) {
                const option = options[i];
                option.style.display = option.text.toLowerCase().includes(input) ? '' : 'none';
            }
        }

        function fillSearchTextbox() {
            const dropdown = document.getElementById('supplier');
            const selectedOption = dropdown.options[dropdown.selectedIndex];
            const searchTextbox = document.getElementById('supplierSearch');

            searchTextbox.value = selectedOption.text;
        }

        document.getElementById('supplier').addEventListener('change', fillSearchTextbox);

        $(document).ready(function() {
            $('input, select, textarea').on('input', function() {
                $(this).removeClass('is-invalid');
                $('#' + $(this).attr('id') + '-error').text('');
            });

            addRow();

            $('#SupplierForm').on('submit', function(e) {
                e.preventDefault();

                var isValid = true;

                

                if (isValid) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('insert.purchase') }}',
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
                                window.location.href = '{{ route('admin.purchase') }}';
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

            function calculateGrandTotal() {
                let grandTotal = 0;

                $('#PurchaseItemTable tbody tr').each(function() {
                    let rowTotal = parseFloat($(this).find('input[name="total[]"]').val()) || 0;
                    grandTotal += rowTotal;
                });

                $('#grandTotal').val(grandTotal.toFixed(2));
            }

            $('#PurchaseItemTable').on('input',
                'input[name="quantity[]"], input[name="cost[]"], input[name="tax[]"]',
                function() {
                    let row = $(this).closest('tr');
                    let quantity = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
                    let cost = parseFloat(row.find('input[name="cost[]"]').val()) || 0;
                    let taxPercentage = parseFloat(row.find('input[name="tax[]"]').val()) || 0;

                    let subtotal = quantity * cost;

                    let taxAmount = (subtotal * taxPercentage) / 100;

                    let total = subtotal + taxAmount;

                    row.find('input[name="total[]"]').val(total.toFixed(2));

                    calculateGrandTotal();
                });

            $('#addRow').click(function() {
                addRow();
            });

            function addRow() {
                $('#PurchaseItemTable tbody').append(`
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
                        <td>
                            <select class="form-select" name="item_name[]" onchange="fetchItemCost(this)">
                                <option value="" hidden>Select Item</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" class="form-control" name="item_details[]" placeholder="Enter Item Details"></td>
                        <td><input type="number" class="form-control" name="cost[]" placeholder="Enter Item cost" readonly></td>
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

            $('#PurchaseItemTable').on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
                calculateGrandTotal();
            });
        });

        function fetchItemCost(selectElement) {
            const itemId = selectElement.value;
            const costInput = $(selectElement).closest('tr').find('input[name="cost[]"]');

            if (itemId) {
                $.ajax({
                    url: '{{ route('item.purchase.cost', '') }}/' + itemId,
                    type: 'GET',
                    success: function(response) {
                        costInput.val(response.cost);
                    },
                    error: function(xhr) {
                        console.error('Error fetching item cost:', xhr);
                    }
                });
            } else {
                costInput.val('');
            }
        }
    </script>

@endsection
