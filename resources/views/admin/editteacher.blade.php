@extends('layouts.auth')

@section('content')
    <div class="col-md-5">
        <div class="topSection px-4 py-4 myHeight bgWhite">
            <h1 class="txtLeft">Edit Tutors Record</h1>
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
            @php
                $myImage = '';
                if(!empty($teachers->image))
                    $myImage = asset('images/users/'.$teachers->image);

                if($myImage <> ""){
                    echo '<div class="row mb-4">
                            <div class="col-md-12 mx-auto mt-5">
                                <img class="d-block mx-auto" style="width:200px;" src="'.$myImage.'" alt="'.$teachers->name.'" title="'.$teachers->name.'" />
                            </div>
                        </div>';
                }
            @endphp
            <form class="mt-4 mb-4" method="POST" action="/admin/teachers/update" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $teachers->id }}">
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ $teachers->name }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Email</label></div>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" value="{{ $teachers->email }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Phone</label></div>
                    <div class="col-md-6">
                        <input type="tel" name="phone" class="form-control" value="{{ $teachers->phone }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="expertise">Expertise</label></div>
                    <div class="col-md-6">
                        <input type="text" name="expertise" class="form-control" value="{{ $teachers->expertise }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="image">Image</label></div>
                    <div class="col-md-6">
                        <input type="file" name="image" class="form-control" value="{{ $teachers->image }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="zoom_link">Zoom Link</label></div>
                    <div class="col-md-6">
                        <input type="url" name="zoom_link" class="form-control" value="{{ $teachers->zoom_link }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="image">Password</label></div>
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" value="">
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