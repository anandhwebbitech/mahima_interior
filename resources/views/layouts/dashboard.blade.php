@extends('layouts.app')

@section('title', 'Admin Dashboard')
<style>
    .row-cols-lg-5>* {
        flex: 0 0 auto;
        width: 17% !important;
    }
</style>
@section('content')
<div class="container-fluid">

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3 mb-4">
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white bg-primary shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">7</h4>
                        <p class="m-0 small">Enquiry</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white bg-warning shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$customer}}</h4>
                        <p class="m-0 small">Totla Customer</p>
                    </div>
                </div>
            </a>
        </div>


        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white bg-success shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$followups}}</h4>
                        <p class="m-0 small">Total Followup</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white bg-info shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$todayfollowup}}</h4>
                        <p class="m-0 small">Today Followup</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white bg-danger shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$oneWeekFollowup}}</h4>
                        <p class="m-0 small">One Week Followup</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white bg-secondary shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$oneMonthFollowup}}</h4>
                        <p class="m-0 small">One Month Followup</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white  bg-dark shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$threeMonthFollowup}}</h4>
                        <p class="m-0 small">Three Month Followup</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white  bg-dark shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$threeMonthFollowup}}</h4>
                        <p class="m-0 small">Six Month Followup</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card text-white  bg-dark shadow-sm rounded-4 text-center h-100">
                    <div class="card-body py-3">
                        <h4 class="fw-bold">{{$threeMonthFollowup}}</h4>
                        <p class="m-0 small">One Year Followup</p>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-light">
            Customer's List
        </div>

        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="customerTable" class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Building Stage</th>
                            <th>Projact Type</th>
                            <th>Estimate</th>
                            <th>Action</th>
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
    $(document).ready(function() {
        // Initialize DataTable and store in variable
        var table = $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('customer.datatable') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        let url = "{{ route('followup.edit', ':id') }}";
                        url = url.replace(':id', row.id);

                        return `<a href="${url}" class="fw-bold text-primary">${data}</a>`;
                    }
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'state',
                    name: 'state'
                },
                {
                    data: 'city',
                    name: 'city'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'building_stage_name',
                    name: 'building_stage_name'
                },
                {
                    data: 'project_type_name',
                    name: 'project_type_name'
                },
                {
                    data: 'estimate',
                    name: 'estimate'
                },
                {
                    data: 'followup',
                    name: 'followup',
                    orderable: false,
                    searchable: false
                }
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
</script>
@endpush

@endsection