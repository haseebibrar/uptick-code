@extends('layouts.auth')

@section('content')
    <div class="col-md-5">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Edit Student Record</h1>
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
                if(!empty($users->image))
                    $myImage = asset('images/users/'.$users->image);

                if($myImage <> ""){
                    echo '<div class="row mb-4">
                            <div class="col-md-12 mx-auto mt-5">
                                <img class="d-block mx-auto" style="width:200px;" src="'.$myImage.'" alt="'.$users->name.'" title="'.$users->name.'" />
                            </div>
                        </div>';
                }
            @endphp
            <form class="mt-4 mb-4" method="POST" action="/admin/users/update" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $users->id }}">
                <div class="row mb-4">
                    <div class="col-md-6"><label for="expertise">Company</label></div>
                    <div class="col-md-6">
                        <select name="company_id" class="form-control">
                            <option value="0">Please Select</option>
                            @foreach($companies as $company)
                                <option <?php echo($users->company_id === $company->id ? 'selected="selected"' : '') ?> value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ $users->name }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Email</label></div>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" value="{{ $users->email }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Phone</label></div>
                    <div class="col-md-6">
                        <input type="tel" name="phone" class="form-control" value="{{ $users->phone }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="image">Image</label></div>
                    <div class="col-md-6">
                        <input type="file" name="image" class="form-control" value="{{ $users->image }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="image">Password</label></div>
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" value="">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/admin/users/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-6">
    </div>
@endsection