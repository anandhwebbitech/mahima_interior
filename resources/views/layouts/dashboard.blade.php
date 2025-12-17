@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid">

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">

    <div class="col">
        <a href="#" class="text-decoration-none">
            <div class="card text-white bg-warning shadow-sm rounded-4 text-center h-100">
                <div class="card-body py-3">
                    <h4 class="fw-bold"></h4>
                    <p class="m-0 small">Processing</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col">
        <a href="#" class="text-decoration-none">
            <div class="card text-white bg-secondary shadow-sm rounded-4 text-center h-100">
                <div class="card-body py-3">
                    <h4 class="fw-bold">5</h4>
                    <p class="m-0 small">Pending</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col">
        <a href="#" class="text-decoration-none">
            <div class="card text-white bg-info shadow-sm rounded-4 text-center h-100">
                <div class="card-body py-3">
                    <h4 class="fw-bold">
                        7
                    </h4>
                    <p class="m-0 small">Confirmed</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col">
        <a href="#" class="text-decoration-none">
            <div class="card text-white bg-success shadow-sm rounded-4 text-center h-100">
                <div class="card-body py-3">
                    <h4 class="fw-bold">7</h4>
                    <p class="m-0 small">Approved</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col">
        <a href="#" class="text-decoration-none">
            <div class="card text-white bg-primary shadow-sm rounded-4 text-center h-100">
                <div class="card-body py-3">
                    <h4 class="fw-bold">7</h4>
                    <p class="m-0 small">Future</p>
                </div>
            </div>
        </a>
    </div>

</div>


       
            <div class="table-responsive mt-3">
                <table id="customerTable" class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Building Stage</th>
                            <th>Projact Type</th>
                            <th>Estimate</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                    </tbody>
                </table>
            </div>



    </div>
    @push('scripts')

    <script>
    $(document).ready(function () {
        $('#customerTable').DataTable();
    });
    </script>
    @endpush

@endsection