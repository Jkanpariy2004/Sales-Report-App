@extends('AdminDashboard.Particals.app')

@section('title', 'Update Purchase Page')

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
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="supplier" class="form-label">Select Supplier</label>
                                                    <div class="dropdown">
                                                        <input type="text" id="supplierSearch" class="form-control"
                                                            placeholder="Search Supplier" onkeyup="filterSupplier()"
                                                            value="{{ $new->supplier ? $suppliers->firstWhere('id', $new->supplier)->name : '' }}">
                                                        <select class="form-select" id="supplier" name="supplier"
                                                            size="5">
                                                            <option value="" hidden>Select Supplier</option>
                                                            @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}"
                                                                    {{ $new->supplier == $supplier->id ? 'selected' : '' }}>
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
                                                            @foreach ($SalesItems as $SalesItem)
                                                                <tr data-id="{{ $SalesItem->id }}" class="sales-item-row">
                                                                    <td>
                                                                        <span
                                                                            class="view-mode">{{ $SalesItem->unit }}</span>
                                                                        <select class="form-select edit-mode" name="unit"
                                                                            style="display:none;">
                                                                            <option value="" hidden>Select Unit
                                                                            </option>
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
                                                                            class="view-mode">{{ $SalesItem->product_name }}</span>
                                                                        <select class="form-select edit-mode"
                                                                            name="item_name" style="display: none;" onchange="fetchItemCost1(this)">
                                                                            <option value="" hidden>Select Item
                                                                            </option>
                                                                            @foreach ($products as $product)
                                                                                <option value="{{ $product->id }}"
                                                                                    {{ $SalesItem->item_name == $product->id ? 'selected' : '' }}>
                                                                                    {{ $product->product_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="view-mode">{{ $SalesItem->item_details }}</span>
                                                                        <input type="text" class="form-control edit-mode"
                                                                            name="item_detail"
                                                                            value="{{ $SalesItem->item_details }}"
                                                                            style="display:none;" />
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="view-mode">{{ $SalesItem->cost }}</span>
                                                                        <input type="number" class="form-control edit-mode"
                                                                            name="cost" value="{{ $SalesItem->cost }}" id="cost"
                                                                            style="display:none;" readonly />
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
                                                                        <select class="form-select edit-mode"
                                                                            name="tax_type" style="display:none;">
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
                                                                        <span
                                                                            class="view-mode">{{ $SalesItem->tax }}</span>
                                                                        <input type="number" class="form-control edit-mode"
                                                                            name="tax" value="{{ $SalesItem->tax }}"
                                                                            style="display:none;" />
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="view-mode">{{ $SalesItem->total }}</span>
                                                                        <input type="number" class="form-control edit-mode"
                                                                            name="total" value="{{ $SalesItem->total }}"
                                                                            id="OldTotal" style="display:none;"
                                                                            onchange="calculateGrandTotal()" readonly />
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
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Update Purchase</button>
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
                        url: '/admin/purchase/delete-purchase-item/' + SalesItemId,
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
                <button class="btn btn-success save-item">Save</button>
            `;

            calculateRowTotal(row);
        }

        function calculateRowTotal(row) {
            const cost = parseFloat(row.querySelector('input[name="cost"]').value) || 0;
            const quantity = parseFloat(row.querySelector('input[name="quantity"]').value) || 0;
            const tax = parseFloat(row.querySelector('input[name="tax"]').value) || 0;

            const total = (cost * quantity) + ((cost * quantity) * (tax / 100));

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

            document.querySelectorAll('input[name="cost"], input[name="quantity"], input[name="tax"]')
                .forEach(function(input) {
                    input.addEventListener('input', function() {
                        const row = input.closest('tr');
                        calculateRowTotal(row);
                    });
                });
        });

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

            // addRow();

            $('#SupplierForm').on('submit', function(e) {
                e.preventDefault();

                var isValid = true;

                if (isValid) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('update.purchase', $new->id) }}',
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

            $('#PurchaseItemTable').on('click', '.save-item', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const button = $(this);
                const row = button.closest('tr');
                const id = row.data('id');

                if (button.prop('disabled')) {
                    return;
                }

                // button.prop('disabled', true);

                const data = {
                    unit: row.find('select[name="unit"]').val(),
                    quantity: row.find('input[name="quantity"]').val(),
                    item_name: row.find('select[name="item_name"]').val(),
                    item_detail: row.find('input[name="item_detail"]').val(),
                    cost: row.find('input[name="cost"]').val(),
                    hsn_code: row.find('input[name="hsn_code"]').val(),
                    tax_type: row.find('select[name="tax_type"]').val(),
                    tax: row.find('input[name="tax"]').val(),
                    total: row.find('input[name="total"]').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: '/admin/purchase/update-purchase-item/' + id,
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
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message ||
                            'Something went wrong. Please try again.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function() {
                        // Optionally, you can re-enable the button here if you want to allow further edits
                        // button.prop('disabled', false);
                    }
                });
            });

            function calculateGrandTotal() {
                let grandTotal = 0;

                $('#PurchaseItemTable tbody tr').each(function() {
                    let rowTotal = parseFloat($(this).find('input[name="total[]"]').val()) || 0;
                    let OldTotal = parseFloat($(this).find('input[id="OldTotal"]').val()) || 0;
                    grandTotal = rowTotal + grandTotal + OldTotal;
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

        function fetchItemCost1(selectElement) {
            const itemId = selectElement.value;
            const costInput = $(selectElement).closest('tr').find('input[name="cost"]');

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
