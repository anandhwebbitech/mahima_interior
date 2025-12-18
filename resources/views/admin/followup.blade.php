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
    #customerTable td:last-child,
    #customerTable th {
        white-space: nowrap;
        /* Keep text on a single line */
        overflow: hidden;
        /* Hide overflow if too long */
        text-overflow: ellipsis;
        /* Show ... if text is too long */
    }

    /* Optional: make table scroll horizontally if content is wide */
    .table-responsive {
        overflow-x: auto;
    }
</style>

@section('content')
<div class="container">

    <!-- Page Banner -->
    <div class="page-banner d-flex justify-content-between align-items-center">
        <h5 class="m-0">
            <i class="fa-solid fa-user-plus me-2"></i> Customer Followup
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
            <form id="CustomerfollowupForm" method="POST">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="row mb-3">
                    <!-- Customer Name Dropdown -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Customer Name</label>
                        <select name="customer_id" id="customer_id" class="form-control">
                            <option value="">Select Customer</option>

                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ isset($selectedCustomer) && $selectedCustomer->id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ $selectedCustomer->phone ?? '' }}" class="form-control" placeholder="Enter phone number">
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Building Stage -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Building Stage</label>
                        <select name="building_stage_id" id="building_stage_id" class="form-control">
                            <option value="">Select Building Stage</option>

                            @foreach($buildingStages as $stage)
                            <option value="{{ $stage->id }}"
                                {{ isset($selectedCustomer) && $selectedCustomer->building_stage == $stage->id ? 'selected' : '' }}>
                                {{ $stage->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Project Type -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Project Type</label>
                        <select name="project_type_id" id="project_type_id" class="form-control">
                            <option value="">Select Project Type</option>

                            @foreach($projectTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ isset($selectedCustomer) && $selectedCustomer->project_type == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Estimate -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estimate Amount</label>
                        <input type="number" name="estimate" id="estimate" value="{{ $selectedCustomer->estimate ?? '' }}" class="form-control" placeholder="Enter estimate amount">
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <!-- <button type="submit" id="submitBtn" class="btn btn-primary px-4">
                        <i class="fa-solid fa-save me-1"></i> Submit
                    </button> -->
                    <!-- <div class="d-flex align-items-center justify-content-between"> -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-success" id="addNoteBtn">+</button>
                    </div>
                    <!-- </div> -->
                </div>
                <div id="noteSection">
                    @if ($followup)
                    <div class="row align-items-end mb-3 note-row">
                        <h5>Previous Followup </h5>
                        <br>
                        <hr>
                        <div class="col-md-4">
                            <label>Date</label>
                            <input type="date" name="followup_date" class="form-control" value="{{ \Carbon\Carbon::parse($followup->followup_date)->format('Y-m-d') }}" readonly>
                        </div>

                        <div class="col-md-5">
                            <label>Description</label>
                            <input type="text" name="followupdescription" class="form-control" readonly value="{{ $followup->followup_description }}">
                        </div>
                    </div>

                    @endif
                    <hr>
                </div>
                <div class="text-end">
                    <button type="submit" id="submitBtn" class="btn btn-primary px-4">
                        <i class="fa-solid fa-save me-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.getElementById("addNoteBtn").addEventListener("click", function() {
        let html = `
                <div class="row align-items-end mb-3 note-row">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="followup_date[]" class="form-control">
                    </div>

                    <div class="col-md-5">
                        <label>Description</label>
                        <input type="text" name="followup_description[]" class="form-control">
                    </div>

                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-danger remove-note">−</button>
                    </div>
                </div>
            `;
        document.getElementById('noteSection').insertAdjacentHTML('beforeend', html);
    });
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-note')) {
            e.target.closest('.note-row').remove();
        }
    });
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true,
            width: '100%'
        });
    });

   
    $('#CustomerfollowupForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('followup.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire('Success', res.message, 'success');
                $('#CustomerfollowupForm')[0].reset();
                $('#noteSection').html('');
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Error', 'error');
            }
        });
    });

    
</script>
@endpush

@endsection