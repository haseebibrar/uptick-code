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
                if(!empty($students->image))
                    $myImage = asset('images/users/'.$students->image);

                if($myImage <> ""){
                    echo '<div class="row mb-4">
                            <div class="col-md-12 mx-auto mt-5">
                                <img class="d-block mx-auto rounded-circle" style="max-height:150px;" src="'.$myImage.'" alt="'.$students->name.'" title="'.$students->name.'" />
                            </div>
                        </div>';
                }
            @endphp
            <form class="mt-4 mb-4" method="POST" action="/admin/students/update" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $students->id }}">
                <input type="hidden" name="company_id" value="{{ $myCompID }}">
                @if(!empty($myCompanies))
                    <div class="row mb-4">
                        <div class="col-md-6"><label for="company_id">Company</label></div>
                        <div class="col-md-6">
                            <select name="company_id_admin" class="form-control" required>
                                <option value=''>Please Select Company</option>
                                @foreach ($myCompanies as $company)
                                    <option {{ $students->company_id === $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ $students->name }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Email</label></div>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" value="{{ $students->email }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Phone</label></div>
                    <div class="col-md-6">
                        <input type="tel" name="phone" class="form-control" value="{{ $students->phone }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Title</label></div>
                    <div class="col-md-6">
                        <input type="tel" name="title" class="form-control" value="{{ $students->title }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="expertise">Department</label></div>
                    <div class="col-md-6">
                        <select name="dept_id" class="form-control">
                            <option value="0">Please Select</option>
                            @foreach($departments as $department)
                                <option <?php echo($students->dept_id === $department->id ? 'selected="selected"' : '') ?> value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Allocate Hours</label></div>
                    <div class="col-md-6"><input type="number" name="allocated_hour" class="form-control" value="{{ $students->allocated_hour }}"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="image">Image</label></div>
                    <div class="col-md-6">
                        <input type="file" name="image" class="form-control" value="{{ $students->image }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="image">Password</label></div>
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" value="">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                @php
                    if($myCompID > 0)
                        echo '<a class="btn btn-light" href="/admin">Cancel</a>';
                    else
                        echo '<a class="btn btn-light" href="/admin/students/">Cancel</a>';
                @endphp
            </form>
        </div>
    </div>
    <div class="col-md-6">
    </div>
@endsection