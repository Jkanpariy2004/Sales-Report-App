@extends('AdminDashboard.Particals.app')

@section('title', 'Products Page')

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
                                <h5 class="card-header">Create Product</h5>
                                <div class="card-body">
                                    <form id="CompanyForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="product_name" class="form-label">Product Name</label>
                                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                                        placeholder="Enter Product Name" />
                                                    <div class="invalid-feedback" id="product_name-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="product_sku" class="form-label">Product SKU</label>
                                                    <input type="text" class="form-control" name="product_sku" id="product_sku"
                                                        placeholder="Enter Product SKU" />
                                                    <div class="invalid-feedback" id="product_sku-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="product_price" class="form-label">Product Price</label>
                                                    <input type="number" class="form-control" name="product_price" id="product_price"
                                                        placeholder="Enter Product Price" />
                                                    <div class="invalid-feedback" id="product_price-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="product_stock" class="form-label">Stock</label>
                                                    <input type="text" class="form-control" name="product_stock" id="product_stock"
                                                        placeholder="Enter Stock" />
                                                    <div class="invalid-feedback" id="product_stock-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Add Product</button>
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
        $(document).ready(function() {
            $('input, select, textarea').on('input', function() {
                $(this).removeClass('is-invalid');
                $('#' + $(this).attr('id') + '-error').text('');
            });

            $('#CompanyForm').on('submit', function(e) {
                e.preventDefault();

                var isValid = true;

                var product_name = $('#product_name').val();
                if (product_name.trim() === '') {
                    $('#product_name').addClass('is-invalid');
                    $('#product_name-error').text('Product Name is required');
                    isValid = false;
                }

                var product_sku = $('#product_sku').val();
                if (product_sku.trim() === '') {
                    $('#product_sku').addClass('is-invalid');
                    $('#product_sku-error').text('Product SKU is required');
                    isValid = false;
                }

                var product_price = $('#product_price').val();
                if (product_price.trim() === '') {
                    $('#product_price').addClass('is-invalid');
                    $('#product_price-error').text('Product Price is required');
                    isValid = false;
                }

                var product_stock = $('#product_stock').val();
                if (product_stock.trim() === '') {
                    $('#product_stock').addClass('is-invalid');
                    $('#product_stock-error').text('Stock is required');
                    isValid = false;
                }

                if (isValid) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('insert.products') }}',
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
                                window.location.href = '{{ route('admin.products') }}';
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
        });
    </script>

@endsection
