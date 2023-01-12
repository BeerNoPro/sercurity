@extends('./layouts.layout')

@section('title', 'Company')

<style>
    .border {
        border: 1px solid #a1adb98a;
    }
</style>

@section('content')
    <!-- Link css datepicker -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
        type="text/css" />
    <div class="content d-flex h-100">
        <form action="{{ route('company.add') }}" method="POST" id="form" class="w-50 p-2 m-auto border">
            <h3 class="d-flex justify-content-center">Create company</h3>
            <hr>
            @csrf
            <div class="form-group mt-3">
                <label for="" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" placeholder="Name..." value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Address:</label>
                <input type="text" class="form-control" name="address" placeholder="Address..." value="{{ old('address') }}">
                @if ($errors->has('address'))
                    <div class="text-danger">{{ $errors->first('address') }}</div>
                @endif
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Email..." value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Phone number:</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone number..." value="{{ old('phone') }}">
                @if ($errors->has('phone'))
                    <div class="text-danger">{{ $errors->first('phone') }}</div>
                @endif
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Date incorporation:</label>
                <input id="date-start" type="text" class="form-control" name="date_incorporation" placeholder="Date..." value="{{ old('date_incorporation') }}">
                @if ($errors->has('date_incorporation'))
                    <div class="text-danger">{{ $errors->first('date_incorporation') }}</div>
                @endif
            </div>
            <div class="form-group mt-3 d-flex justify-content-center">
                <a href="{{ route('company.home') }}" class="btn btn-primary me-3">Back</a>
                <button type="submit" class="btn btn-success btn-handel btn-add">Add</button>
            </div>
        </form>
    </div>
    <!-- Jquery ui datepicker -->
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- Import file common js -->
    <script src="{{ asset('js/common.js') }}"></script>
    <!-- Link file js handle -->
    <script src="{{ asset('js/company.js') }}"></script>
@endsection
