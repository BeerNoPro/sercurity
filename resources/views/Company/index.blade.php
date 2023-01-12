@extends('./layouts.layout')

@section('title', 'Company')

@section('form-search')
    <form action="{{ route('company.search') }}" method="post" class="col-md-10 d-flex ps-0 justify-content-between">
        @csrf
        <input class="form-control form-control-dark w-100 input-search" type="text" name="name" placeholder=" Search company name..."
            autocomplete="off">
        <div class="px-3 ms-3 d-flex">
            <div class="">
                {{-- <a class="nav-link btn btn-outline-info" href="">Search</a> --}}
                <button type="submit" class="nav-link btn btn-outline-info">Search</button>
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
        <!-- Link css datepicker -->
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
            type="text/css" />
        <!-- Link css alertify -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

        <div class="row">
            <div class="col-md-12">
                <div class="row-top mt-3 mb-3 d-flex justify-content-between align-items-center">
                    <h1 class="">Lists content companies</h1>
                    <a href="{{ route('company.form.add') }}" class="btn btn-success show-modal">
                        Add new data
                    </a>
                </div>
                <h3 class="alert alert-warning d-none" id="error"></h3>
                @if (session('error'))
                    <div class="alert alert-danger text-center">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Date incorporation</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-show-lists">
                        @isset($data)
                            @foreach ($data as $key => $item)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td data-id="{{ $item->id }}" class="table-name hover-text-click">
                                        {{ $item->name }}
                                    </td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->date_incorporation }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('company-show', $item->id) }}" class="btn btn-sm btn-edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('company-delete', $item->id) }}" method="post">
                                            @csrf
                                            {{ @method_field('delete') }}
                                            <button type="submit" class="btn btn-sm btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
                <!-- Div show list suggestions  -->
                <div id="contentSearch"></div>
                <!-- Pagination -->
                <div aria-label="..." id="show-pagination" class="custom-pagination">
                    <ul class="pagination justify-content-center mt-4"></ul>
                </div>
            </div>
        </div>

        <!-- Jquery ui datepicker -->
        <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <!-- Alertify link -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <!-- Import file common js -->
        <script src="{{ asset('js/common.js') }}"></script>
        <!-- Link file js handle -->
        {{-- <script src="{{ asset('js/company.js') }}"></script> --}}
        <script>
            // Add background color sidebar 
            $('.company').addClass('sidebar-color');
        </script>
    </div>
@endsection
