@extends('./layouts.layout')

@section('title', 'Rgister')

<style>
    .form-register {
        background-color: #e9ecef;
        width: 300px;
    }
</style>

@section('content')
    <div class="content m-auto">
        <form action="{{ route('custom_register') }}" method="POST" class="form-register p-3 rounded-3">
            @csrf
            <div class="form-group">
                <label for="">Name address</label>
                <input type="name" class="form-control" name="name" placeholder="Enter your name">
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="form-group mt-2 mb-2">
                <label for="">Email address</label>
                <input type="text" class="form-control" name="email"
                    placeholder="Enter your email">
                @if ($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                @if ($errors->has('password'))
                    <div class="text-danger">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="modal-footer justify-content-center">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <button type="submit" class="btn btn-success">Register</button>
            </div>
        </form>
    </div>
    <script>
        $('.content-all').addClass('d-flex justify-content-center')
    </script>
@endsection

