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
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <h5 class="card-header">Create Customer</h5>
                                <div class="card-body">
                                    <form id="CompanyForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="customer_name" class="form-label">Customer Name</label>
                                                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                                                        placeholder="Enter Customer Name" value="{{ $new->customer_name }}" />
                                                    <div class="invalid-feedback" id="customer_name-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="customer_email" class="form-label">Customer Email</label>
                                                    <input type="text" class="form-control" name="customer_email" id="customer_email"
                                                        placeholder="Enter Customer Name" value="{{ $new->customer_email }}" />
                                                    <div class="invalid-feedback" id="customer_email-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="gst_no" class="form-label">GST No.</label>
                                                    <input type="text" class="form-control" name="gst_no" id="gst_no"
                                                        placeholder="Enter GST No." value="{{ $new->gst_no }}" />
                                                    <div class="invalid-feedback" id="gst_no-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="place" class="form-label">Place</label>
                                                    <textarea type="text" class="form-control" name="place" id="place"
                                                        placeholder="Enter Place">{{ $new->place }}</textarea>
                                                    <div class="invalid-feedback" id="place-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="state_code" class="form-label">State Code</label>
                                                    <input type="text" class="form-control" name="state_code" id="state_code"
                                                        placeholder="Enter State Code" value="{{ $new->state_code }}" />
                                                    <div class="invalid-feedback" id="state_code-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="transport_no" class="form-label">Transport No.</label>
                                                    <input type="text" class="form-control" name="transport_no" id="transport_no"
                                                        placeholder="Enter Transport No." value="{{ $new->transport_no }}" />
                                                    <div class="invalid-feedback" id="transport_no-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="transport_gst_tin_no" class="form-label">Transport GST TIN No.</label>
                                                    <input type="text" class="form-control" name="transport_gst_tin_no" id="transport_gst_tin_no" placeholder="Enter GST TIN No." value="{{ $new->transport_gst_tin_no }}" />
                                                    <div class="invalid-feedback" id="transport_gst_tin_no-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="parcel" class="form-label">Parcel</label>
                                                    <input type="text" class="form-control" name="parcel" id="parcel"
                                                        placeholder="Enter Parcel" value="{{ $new->parcel }}" />
                                                    <div class="invalid-feedback" id="parcel-error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Update Customer</button>
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

                var customer_name = $('#customer_name').val();
                if (customer_name.trim() === '') {
                    $('#customer_name').addClass('is-invalid');
                    $('#customer_name-error').text('Customer Name is required');
                    isValid = false;
                }

                var customer_email = $('#customer_email').val();
                if (customer_email.trim() === '') {
                    $('#customer_email').addClass('is-invalid');
                    $('#customer_email-error').text('Customer Email is required');
                    isValid = false;
                }

                var gst_no = $('#gst_no').val();
                if (gst_no.trim() === '') {
                    $('#gst_no').addClass('is-invalid');
                    $('#gst_no-error').text('GST No. is required');
                    isValid = false;
                }

                var place = $('#place').val();
                if (place.trim() === '') {
                    $('#place').addClass('is-invalid');
                    $('#place-error').text('Place is required');
                    isValid = false;
                }

                var state_code = $('#state_code').val();
                if (state_code.trim() === '') {
                    $('#state_code').addClass('is-invalid');
                    $('#state_code-error').text('State Code is required');
                    isValid = false;
                }

                var transport_no = $('#transport_no').val();
                if (transport_no.trim() === '') {
                    $('#transport_no').addClass('is-invalid');
                    $('#transport_no-error').text('Transport No is required');
                    isValid = false;
                }

                var transport_gst_tin_no = $('#transport_gst_tin_no').val();
                if (transport_gst_tin_no.trim() === '') {
                    $('#transport_gst_tin_no').addClass('is-invalid');
                    $('#transport_gst_tin_no-error').text('Transport GST TIN No. is required');
                    isValid = false;
                }

                var parcel = $('#parcel').val();
                if (parcel.trim() === '') {
                    $('#parcel').addClass('is-invalid');
                    $('#parcel-error').text('Parcel is required');
                    isValid = false;
                }

                if (isValid) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('update.customers', $new->id) }}',
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
                                window.location.href = '{{ route('admin.customer') }}';
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
