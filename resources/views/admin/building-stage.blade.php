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
            <i class="fa-solid fa-user-plus me-2"></i> Add Building Stage
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
            Building Stage
        </div>

        <div class="card-body">
            <form action="#" method="POST">
                @csrf

                <!-- Personal Details -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Building Stage</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name">
                        <input type="hidden" name="type" value="building_stage">

                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select status</option>
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 m-4">
                            <i class="fa-solid fa-save me-1"></i> Submit
                        </button>
                    </div>
                    
                </div>

                <!-- Submit -->
                

            </form>

        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-light">
            Building Stage Type 
        </div>

        <div class="card-body">
           <div class="table-responsive mt-3">
                <table id="BuildingTable" class="table table-bordered table-striped align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Building Stage Name</th>
                            <th class="text-center">Action</th>
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

<script>

 $(document).ready(function () {
    $('#BuildingTable').DataTable();
});
</script>
@endpush

@endsection
