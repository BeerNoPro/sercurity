@extends('./layouts.layout')

@section('title', 'view home')

<style>
    .height-fit-content {
        height: fit-content;
    }
</style>

@section('content')
    <!-- Link css alertify -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

    <div class="content">
        <div class="header mt-3 mb-4">
            {{-- @isset($status) --}}
                @if (session('name'))
                    <h1 class="text-center">Welcome <b>{{ session('name') }}</b></h1>
                @else
                    <h1 class="text-center">Welcome to page</h1>
                @endif
            {{-- @endisset --}}
        </div>
        <div class="row pe-2 ps-2 justify-content-around">
            <div class="col-md-2 border rounded pt-2 height-fit-content">
                <div class="box-header text-center">
                    <h6 class="border p-2 rounded-3 fw-bold">Work rooms</h6>
                </div>
                <div class="box-body-wr"></div>
            </div>
            <div class="col-md-2 border rounded pt-2 ml-3 mr-3 height-fit-content">
                <div class="box-header text-center">
                    <h6 class="border p-2 rounded-3 fw-bold">Projects</h6>
                </div>
                <div class="box-body">
                    <div class="mt-3 fw-bold">Project doing:</div>
                    <div class="mt-2 project-doing"></div>
                    <div class="mt-3 fw-bold">Project done:</div>
                    <div class="mt-2 project-done"></div>
                </div>
            </div>
            <div class="col-md-7 border rounded pt-2">
                <div class="card mb-2">
                    <div class="card-header text-center">
                        <h6 class="fw-bold">Work room details</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive border mb-0 fs-14">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-work-room"></tbody>
                        </table>
                    </div>
                </div>
                <div class="card mb-2 card-project">
                    <div class="card-header text-center">
                        <h6 class="fw-bold">Project details</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive border mb-0 fs-14">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Name</th>
                                    <th>Time start</th>
                                    <th>Time completed</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-project"></tbody>
                        </table>
                    </div>
                </div>
                <div class="card mb-2 card-member">
                    <div class="card-header text-center">
                        <h6 class="fw-bold">Members</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive border mb-0 fs-14">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Full name</th>
                                    <th>Name company</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-member"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start modal show detail -->
        <div class="modal" tabindex="-1" id="modalShowDetail">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="mt-2 p-2 rounded-3" class="modal-title">Show content detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-show-detail"></table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal show detail -->
    </div>

    <!-- Jquery ui datepicker -->
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- Alertify link -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- Import file common js -->
    <script src="{{ asset('js/common.js') }}"></script>
    <!-- Link file js handle -->
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
