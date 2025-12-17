@extends('layouts.app')

@section('title', 'Add Customer - Crystal Electronics CRM')

<style>
    .page-banner {
        padding: 16px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        color: #171616;
        background-color: #a2ceed;
    }
</style>

@section('content')
<div class="container">

    <!-- Page Banner -->
    <div class="page-banner d-flex justify-content-between align-items-center">
        <h3 class="m-0">
            <i class="fa-solid fa-user-plus me-2"></i> Add New Customer
        </h3>
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
            <form action="#" method="POST">
                @csrf

                <!-- Personal Details -->
                <h6 class="fw-bold mb-3">Personal Information</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email address">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mobile</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Alternative Mobile</label>
                        <input type="text" name="alter_phone" class="form-control" placeholder="Enter phone number">

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter address">
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
                            <option value="1">Starting</option>
                            <option value="2">Processing</option>
                            <option value="3">Complete</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Type Of Project</label>
                        <select name="type_of_project" id="type_of_project" class="form-control">
                            <option value="">Select project Type</option>
                            <option value="1">Starting</option>
                            <option value="2">Processing</option>
                            <option value="3">Complete</option>
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
                        <input type="text" name="aadhar_no" class="form-control" placeholder="Enter Aadhar number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">GST Number</label>
                        <input type="text" name="gst_no" class="form-control" placeholder="Enter GST number">
                    </div>

                    <!-- <div class="col-md-6">
                        <label class="form-label fw-bold">Company Name</label>
                        <input type="text" name="company_name" class="form-control" placeholder="Enter company name">
                    </div> -->
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-save me-1"></i> Submit
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


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
</script>
@endsection
