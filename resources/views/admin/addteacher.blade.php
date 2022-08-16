@extends('layouts.auth')

@section('content')
    <div class="col-md-5">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Add Tutor</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="mt-4 mb-4" method="POST" action="/admin/teachers/add" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Email</label></div>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Phone</label></div>
                    <div class="col-md-6">
                        <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="expertise">Expertise</label></div>
                    <div class="col-md-6">
                        <input type="text" name="expertise" class="form-control" value="{{ old('expertise') }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="image">Image</label></div>
                    <div class="col-md-6">
                        <input type="file" name="image" class="form-control" value="{{ old('image') }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="zoom_link">Zoom Link</label></div>
                    <div class="col-md-6">
                        <input type="url" name="zoom_link" class="form-control" value="{{ old('zoom_link') }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="password">Password</label></div>
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" value="{{ old('password') }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="password_confirmation ">Confirm Password</label></div>
                    <div class="col-md-6">
                        <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/admin/teachers/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-6">
    </div>
@endsection
@section('scripts')
    <script>
        
    </script>
@endsection