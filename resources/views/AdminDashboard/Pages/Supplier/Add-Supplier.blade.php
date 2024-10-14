@extends('AdminDashboard.Particals.app')

@section('title', 'Add Supplier Page')

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
                                <h5 class="card-header">Create Supplier</h5>
                                <div class="card-body">
                                    <form id="SupplierForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="company_name" class="form-label">Company Name</label>
                                                    <input type="text" class="form-control" name="company_name"
                                                        id="company_name" placeholder="Enter Supplier Company Name" />
                                                    <div class="invalid-feedback" id="company_name-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="supplier_name" class="form-label">Supplier Name</label>
                                                    <input type="text" class="form-control" name="supplier_name"
                                                        id="supplier_name" placeholder="Enter Supplier Name" />
                                                    <div class="invalid-feedback" id="supplier_name-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="gst_no" class="form-label">GST No.</label>
                                                    <input type="text" class="form-control" name="gst_no" id="gst_no"
                                                        placeholder="Enter Product Price" />
                                                    <div class="invalid-feedback" id="gst_no-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder="Enter Email" />
                                                    <div class="invalid-feedback" id="email-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone No.</label>
                                                    <input type="text" class="form-control" name="phone" id="phone"
                                                        placeholder="Enter Phone No." />
                                                    <div class="invalid-feedback" id="phone-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea type="text" class="form-control" name="address" id="address" placeholder="Enter Address"></textarea>
                                                    <div class="invalid-feedback" id="address-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="city" class="form-label">City</label>
                                                    <input type="text" class="form-control" name="city" id="city"
                                                        placeholder="Enter city" />
                                                    <div class="invalid-feedback" id="city-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Add Supplier</button>
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

            $('#SupplierForm').on('submit', function(e) {
                e.preventDefault();

                var isValid = true;

                var company_name = $('#company_name').val();
                if (company_name.trim() === '') {
                    $('#company_name').addClass('is-invalid');
                    $('#company_name-error').text('Supplier Company Name is required');
                    isValid = false;
                }

                var supplier_name = $('#supplier_name').val();
                if (supplier_name.trim() === '') {
                    $('#supplier_name').addClass('is-invalid');
                    $('#supplier_name-error').text('Supplier Name is required');
                    isValid = false;
                }

                var gst_no = $('#gst_no').val();
                if (gst_no.trim() === '') {
                    $('#gst_no').addClass('is-invalid');
                    $('#gst_no-error').text('GST No. is required');
                    isValid = false;
                }

                var email = $('#email').val();
                if (email.trim() === '') {
                    $('#email').addClass('is-invalid');
                    $('#email-error').text('Email is required');
                    isValid = false;
                }

                var phone = $('#phone').val();
                if (phone.trim() === '') {
                    $('#phone').addClass('is-invalid');
                    $('#phone-error').text('Phone No. is required');
                    isValid = false;
                }

                var address = $('#address').val();
                if (address.trim() === '') {
                    $('#address').addClass('is-invalid');
                    $('#address-error').text('Address is required');
                    isValid = false;
                }

                var city = $('#city').val();
                if (city.trim() === '') {
                    $('#city').addClass('is-invalid');
                    $('#city-error').text('City is required');
                    isValid = false;
                }

                if (isValid) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('insert.supplier') }}',
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
                                window.location.href = '{{ route('admin.supplier') }}';
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
