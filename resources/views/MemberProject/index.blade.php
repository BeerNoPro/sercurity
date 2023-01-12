@extends('./layouts.layout')

@section('title', 'Member project')

@section('form-search')
    <form action="" method="post" class="col-md-10 d-flex ps-0 justify-content-between">
        <input class="form-control form-control-dark w-100 input-search" type="text" name="search" placeholder=" Search member project name..."
            autocomplete="off">
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
                    <a class="nav-link btn btn-outline-success" href="{{ route('register') }}">Register</a>
                </div>
            @endif
        </div>
    </form>
@endsection

@section('content')
    <div class="content">
        Hello Member project
    </div>
    <script>
        $('.member-project').addClass('sidebar-color');
    </script>
@endsection

