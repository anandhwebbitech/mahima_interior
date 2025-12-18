@extends('layouts.app')

@section('title', 'Add Building - Mahima Interior CRM')

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
    <div class="page-banner d-flex justify-content-between align-items-center">
        <h5 class="m-0">
            <i class="fa-solid fa-user-plus me-2"></i> Add Building Stage
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
            Building Stage
        </div>

        <div class="card-body">
            <form action="#" method="POST" id="BuildingStageForm">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <!-- Personal Details -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Building Stage</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter full name">
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
                        <button type="submit" id="submitBtn" class="btn btn-primary px-4 m-4">
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
                            <th>Status</th>
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
    $('#BuildingStageForm').submit(function(e) {


        e.preventDefault();

        let id = $('#edit_id').val();
        let type = $('input[name="type"]').val();

        let url = id ?
            "{{ url('common/update') }}/" + type + "/" + id :
            "{{ route('common.store') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize(),

            success: function(res) {
                Swal.fire('Success', res.message, 'success');

                // Reset form
                $('#BuildingStageForm')[0].reset();
                $('#edit_id').val('');

                // Reset button
                $('#submitBtn')
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="fa fa-save me-1"></i> Submit');

                // Reload table
                $('#BuildingTable').DataTable().ajax.reload(null, false);
            },

            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Validation error', 'error');
            }
        });
    });
    $(document).ready(function() {
        // $('#BuildingTable').DataTable();
        $('#BuildingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('stage.datatable') }}",

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    function editCommon(id, type) {
        $.get("{{ url('common/edit') }}/" + type + "/" + id, function(data) {
            console.log(data);
            // Fill form values
            $('#edit_id').val(data.id);
            $('#name').val(data.name);
            $('#status').val(data.status);

            // Change button text
            $('#submitBtn')
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i class="fa fa-edit me-1"></i> Update');

            // Scroll to form
            $('html, body').animate({
                scrollTop: $("#BuildingStageForm").offset().top
            }, 500);
        });
    }
    function deleteCommon(id, type) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This record will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "{{ url('common/delete') }}/" + type + "/" + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');

                    $('#BuildingTable')
                        .DataTable().ajax.reload(null, false);
                },

                error: function () {
                    Swal.fire('Error', 'Unable to delete record', 'error');
                }
            });
        }
    });
}
</script>
@endpush

@endsection