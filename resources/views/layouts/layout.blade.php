<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- custom css link -->
    <link rel="stylesheet" href="{{ asset('css/view_custom.css') }}">

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <?php
    $status = 100;
    ?>

</head>

<body>
    <!-- Icon completed -->
    <div id="icon-loading" class="text-primary d-none">
        <div class="spinner-border icon-loading" role="status"></div>
        <span class="sr-only content-loading">Loading...</span>
    </div>
    <!-- content -->
    <div class="container-fluid">
        <div class="header header-content">
            <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow p-3">
                <div class="row w-100">
                    <div class="col-md-2 text-center">
                        <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-center" href="#">
                            SECURITY
                        </a>
                    </div>
                    @yield('form-search')
                    {{-- <form action="" method="post" class="col-md-10 d-flex ps-0 justify-content-between">
                        <input class="form-control form-control-dark w-100 input-search" type="text" name="search"
                            placeholder=" Search..." autocomplete="off">
                        <div class="px-3 ms-3 d-flex">
                            <div class="">
                                <a class="nav-link btn btn-outline-info" href="">Search</a>
                            </div>
                            @if (session('name'))
                                <div class="ps-2">
                                    <a class="nav-link btn btn-outline-warning" href="{{ route('logout') }}">Logout</a>
                                </div>
                            @else
                                <div class="pe-2 ps-2">
                                    <a class="nav-link btn btn-outline-primary" href="{{ route('login') }}">Login</a>
                                </div>
                                <div class="">
                                    <a class="nav-link btn btn-outline-success"
                                        href="{{ route('register') }}">Register</a>
                                </div>
                            @endif
                        </div>
                    </form> --}}
                </div>
            </nav>
        </div>
        <div class="row row-content">
            <nav class="col-md-2 d-md-block bg-dark sidebar">
                <div class="sidebar-custom mt-2">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-1 home">
                            <a class="nav-link" href="/security">
                                <i class=""></i>
                                Home
                            </a>
                        </li>
                        <li class="nav-item mb-1 company">
                            <a class="nav-link" href="{{ route('company.home') }}">
                                <i class=""></i>
                                Company
                            </a>
                        </li>
                        <li class="nav-item mb-1 work-room">
                            <a class="nav-link" href="{{ route('work-room.home') }}">
                                <i class=""></i>
                                Work room
                            </a>
                        </li>
                        <li class="nav-item mb-1 member">
                            <a class="nav-link" href="{{ route('member.home') }}">
                                <i class=""></i>
                                Member
                            </a>
                        </li>
                        <li class="nav-item mb-1 project">
                            <a class="nav-link" href="{{ route('project.home') }}">
                                <i class=""></i>
                                Project
                            </a>
                        </li>
                        <li class="nav-item mb-1 member-project">
                            <a class="nav-link" href="{{ route('member-project.home') }}">
                                <i class=""></i>
                                Member project
                            </a>
                        </li>
                        <li class="nav-item mb-1 training">
                            <a class="nav-link" href="{{ route('training.home') }}">
                                <i class=""></i>
                                Training
                            </a>
                        </li>
                        <li class="nav-item mb-1 training-room">
                            <a class="nav-link" href="{{ route('training-room.home') }}">
                                <i class=""></i>
                                Training room
                            </a>
                        </li>
                        <li class="nav-item mb-1 device">
                            <a class="nav-link" href="{{ route('device.home') }}">
                                <i class=""></i>
                                Device
                            </a>
                        </li>
                        <li class="nav-item mb-1 cabinet">
                            <a class="nav-link" href="{{ route('cabinet.home') }}">
                                <i class=""></i>
                                Cabinet
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-10 content-all">
                @yield('content')
            </main>
        </div>

    </div>
</body>



</html>
