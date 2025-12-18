@extends('layouts.app')

@section('title', 'Followup - Mahima Interior CRM')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>
     .page-banner {
        padding: 10px 48px;
        margin-bottom: 27px;
        border-radius: 35px;
        color: #171616;
        background-color: #a2ceed;
    }
</style>
@section('content')
<div class="container">

    <!-- Page Banner -->
    <div class="page-banner d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">
            <i class="fa-solid fa-user-clock me-2"></i> Followup List
        </h5>
        <a href="{{ route('customer') }}" class="btn btn-outline-dark">
            <i class="fa-solid fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="fw-bold">Filter by Customer</label>
                    <select id="customerFilter" class="form-control select2">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }} ({{ $customer->phone }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="FollowupTables" class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Followup Date</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script>
$(document).ready(function () {

    $('.select2').select2({
        placeholder: "Select Customer",
        allowClear: true,
        width: '100%'
    });

    let table = $('#FollowupTables').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('followup.datatable') }}",
        data: function (d) {
            d.customer_id = $('#customerFilter').val();
        }
    },
    columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'customer_name' },
        { data: 'phone' },
        { data: 'followup_date' },
        { data: 'description' }
    ]
});
    $('#customerFilter').change(function () {
        table.draw();
    });

});
</script>
@endpush
