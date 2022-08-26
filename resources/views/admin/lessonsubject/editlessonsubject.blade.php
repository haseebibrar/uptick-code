@extends('layouts.auth')

@section('content')
    <div class="col-md-5">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Edit Record</h1>
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
            <form class="mt-4 mb-4" method="POST" action="/admin/lessonsubject/update" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $lessonsubjects->id }}">
                <div class="row mb-4">
                    <div class="col-md-6"><label for="expertise">Focus Area</label></div>
                    <div class="col-md-6">
                        <select name="focusarea_id" class="form-control">
                            <option value="0">Please Select</option>
                            @foreach($focusareas as $focusarea)
                                <option <?php echo($lessonsubjects->focusarea_id === $focusarea->id ? 'selected="selected"' : '') ?> value="{{ $focusarea->id }}">{{ $focusarea->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ $lessonsubjects->name }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="pdf_data">File One</label></div>
                    <div class="col-md-6">
                        <input type="file" name="pdf_data" class="form-control" value="{{ $lessonsubjects->pdf_data }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="pdf_data_sec">File Two</label></div>
                    <div class="col-md-6">
                        <input type="file" name="pdf_data_sec" class="form-control" value="{{ $lessonsubjects->pdf_data_sec }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="embeded_url">Kajabi link</label></div>
                    <div class="col-md-6">
                        <input type="url" name="kajabi_url" class="form-control" value="{{ $lessonsubjects->kajabi_url }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/admin/lessonsubject/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-6">
    </div>
@endsection