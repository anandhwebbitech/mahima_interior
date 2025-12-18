@extends('layouts.app')

@section('title', 'Add Customer - Mahima Interior CRM')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .page-banner {
        padding: 10px 48px;
        margin-bottom: 27px;
        border-radius: 35px;
        color: #171616;
        background-color: #a2ceed;
    }
    /* Prevent table text from breaking */
    #customerTable th {
        white-space: nowrap;   /* Keep text on a single line */
        overflow: hidden;      /* Hide overflow if too long */
        text-overflow: ellipsis; /* Show ... if text is too long */
    }

    /* Optional: make table scroll horizontally if content is wide */
    .table-responsive {
        overflow-x: auto;
    }
    .action-col {
        white-space: nowrap;
        min-width: 110px;
    }
</style>

@section('content')
<div class="container">

    <!-- Page Banner -->
    <div class="page-banner d-flex justify-content-between align-items-center">
        <h5 class="m-0">
            <i class="fa-solid fa-user-plus me-2"></i> Add New Customer
        </h5>
        <a href="{{ route('customer') }}" class="btn btn-outline-dark">
            <i class="fa-solid fa-arrow-left me-1"></i> Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-light">
            Customer Details
        </div>

        <div class="card-body">
            <form action="#" id="CustomerForm" method="POST">
                @csrf
                
                <input type="hidden" name="edit_id" id="edit_id" value =''>
                <!-- Personal Details -->
                <h6 class="fw-bold mb-3">Personal Information</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name"id="name" class="form-control" placeholder="Enter full name">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email"class="form-control" placeholder="Enter email address">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mobile</label>
                        <input type="number"id="phone"  name="phone" class="form-control" maxlength="15"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"  placeholder="Enter phone number">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Alternative Mobile</label>
                        <input type="number" name="alternative_phone"id="alternative_phone" class="form-control" placeholder="Enter phone number">

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Address</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Enter address">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">State</label>
                        <select name="state" id="state" class="form-control">
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">City</label>
                        <select name="city" id="city" class="form-control">
                            <option value="">Select City</option>
                        </select>
                    </div>

                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Building Stage</label>
                        <select name="building_stage" id="building_stage" class="form-control">
                            <option value="">Select building Stage</option>
                            @foreach($buildingStages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Type Of Project</label>
                        <select name="type_of_project" id="type_of_project" class="form-control">
                            <option value="">Select project Type</option>
                            @foreach($projectTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estimate</label>
                        <select name="estimate" id="estimate" class="form-control">
                            <option value="">Select Estimate</option>
                            <option value="100000">100000</option>
                            <option value="200000">200000</option>
                            <option value="300000">300000</option>
                            <option value="400000">400000</option>
                            <option value="500000">500000</option>
                            <option value="600000">600000</option>
                            <option value="700000">700000</option>
                        </select>
                    </div>
                </div>

                <hr>

                <!-- Commercial Details -->
                <h6 class="fw-bold mb-3">Commercial Information</h6>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Aadhar Number</label>
                        <input type="text" name="aadhar_no" id="aadhar_no" class="form-control" placeholder="Enter Aadhar number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">GST Number</label>
                        <input type="text" name="gst_no" id="gst_no"class="form-control" placeholder="Enter GST number">
                    </div>

                    <!-- <div class="col-md-6">
                        <label class="form-label fw-bold">Company Name</label>
                        <input type="text" name="company_name" class="form-control" placeholder="Enter company name">
                    </div> -->
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" id="submitBtn" class="btn btn-primary px-4">
                        <i class="fa-solid fa-save me-1"></i> Submit
                    </button>
                </div>

            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-light">
            Customer Details
        </div>

        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="customerTable" class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th class="text-center action">Action</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Building Stage</th>
                            <th>Projact Type</th>
                            <th>Estimate</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
const stateSelect = document.getElementById('state');
const citySelect = document.getElementById('city');

// Fetch states dynamically
fetch('https://countriesnow.space/api/v0.1/countries/states', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ country: "India" })
})
.then(res => res.json())
.then(data => {
    data.data.states.forEach(state => {
        const option = document.createElement('option');
        option.value = state.name;
        option.textContent = state.name;
        stateSelect.appendChild(option);
    });
});

// When state changes, fetch cities
stateSelect.addEventListener('change', function() {
    citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities
    if (!this.value) return;

    fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ country: "India", state: this.value })
    })
    .then(res => res.json())
    .then(data => {
        if (data.data && data.data.length > 0) {
            data.data.forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }
    });
});
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%'
    });
});
$('#CustomerForm').submit(function (e) {
    e.preventDefault();

    let editId = $('#edit_id').val(); // Check if it's edit or add
    let url = editId 
        ? "{{ url('customer/update') }}/" + editId  // Update route
        : "{{ route('customer.store') }}";          // Store route

    let method = editId ? "POST" : "POST"; // Use POST for both, Laravel handles update via route

    $.ajax({
        url: url,
        type: method,
        data: $(this).serialize(),
        success: function (res) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message,
                timer: 2000,
                showConfirmButton: false
            });

            $('#CustomerForm')[0].reset();
            $('#edit_id').val(''); // Reset edit ID
            $('#submitBtn').removeClass('btn-warning').addClass('btn-primary').html('<i class="fa-solid fa-save me-1"></i> Submit');

            // Reload DataTable
            $('#customerTable').DataTable().ajax.reload(null, false);
        },
        error: function (xhr) {
            let msg = 'Something went wrong';
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                msg = Object.values(errors)[0][0];
            }
            Swal.fire('Error', msg, 'error');
        }
    });
});

    $(document).ready(function() {
    var table = $('#customerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('customer.datatable') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'action-col text-center'
            },
            {
                    data: 'name',
                    name: 'name',
                    render: function (data, type, row) {
                        let url = "{{ route('followup.edit', ':id') }}";
                        url = url.replace(':id', row.id);

                        return `<a href="${url}" class="fw-bold text-primary">${data}</a>`;
                    }
                },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'state', name: 'state' },
            { data: 'city', name: 'city' },
            { data: 'building_stage_name', name: 'building_stage_name' },
            { data: 'project_type_name', name: 'project_type_name' },
            { data: 'estimate', name: 'estimate' },
            { data: 'status', name: 'status', render: function(data) {
                return data == 1 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-danger">Inactive</span>';
            }},
        ]
    });
    let followUpRoute = "{{ route('customers.followups', ':id') }}";

        // Click handler for follow-up button
        $('#customerTable tbody').on('click', '.toggleFollowUp', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr); // table is defined here
            var customerId = $(this).data('id');
            var url = followUpRoute.replace(':id', customerId);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(followups) {
                        let html = `<table class="table table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Followup Date</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody> `;

                        if (followups.length > 0) {
                            followups.forEach(function(fu, index) {
                                let formattedDate = new Date(fu.followup_date).toLocaleDateString('en-GB'); // DD/MM/YYYY
                                html += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${formattedDate}</td>
                                        <td>${fu.followup_description}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            html += `<tr>
                                        <td colspan="3" class="text-center">No follow-ups found.</td>
                                    </tr>
                                `;
                        }

                        html += `
                                </tbody>
                            </table>
                        `;

                        row.child(html).show();
                        tr.addClass('shown');
                    },
                    error: function() {
                        row.child('<p>Error loading follow-ups.</p>').show();
                        tr.addClass('shown');
                    }
                });
            }
        });
});
function editCustomer(id) {
    $.get("{{ url('customer/edit') }}/" + id, function(data){
        // Populate fields
        $('#edit_id').val(data.id);
        $('#name').val(data.name);
        $('#phone').val(data.phone);
        $('#alternative_phone').val(data.alternative_phone);
        $('#email').val(data.email);
        $('#address').val(data.address);
        $('#building_stage').val(data.building_stage);
        $('#type_of_project').val(data.project_type);
        $('#estimate').val(data.estimate);
        $('#status').val(data.status);
        $('#aadhar_no').val(data.aadhar_no);
        $('#gst_no').val(data.gst_no);

        // Set state first
        $('#state').val(data.state).trigger('change');

        // Fetch cities for the state and set city
        if (data.state) {
            fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ country: "India", state: data.state })
            })
            .then(res => res.json())
            .then(cityData => {
                $('#city').empty().append('<option value="">Select City</option>');
                cityData.data.forEach(city => {
                    $('#city').append('<option value="' + city + '">' + city + '</option>');
                });
                $('#city').val(data.city).trigger('change');
            });
        }

        // Change submit button to Update
        $('#submitBtn').removeClass('btn-primary').addClass('btn-warning').html('<i class="fa-solid fa-edit me-1"></i> Update');

        // Scroll to form
        $('html, body').animate({ scrollTop: $("#CustomerForm").offset().top }, 500);
    });
}

function deleteCustomer(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the customer permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('customer/delete') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function(res){
                    Swal.fire('Deleted!', res.message, 'success');
                    $('#customerTable').DataTable().ajax.reload(null, false);
                },
                error: function(xhr){
                    Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong', 'error');
                }
            });
        }
    });
}
</script>
@endpush

@endsection
