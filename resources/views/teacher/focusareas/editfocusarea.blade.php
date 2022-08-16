@extends('layouts.auth')

@section('content')
    <div class="col-md-5">
        <div class="topSection px-4 py-4 bgWhite">
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
            <form class="mt-4 mb-4" method="POST" action="/teacher/lessons-material/update" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $focusareateacher->id }}">
                <input type="hidden" name="focusarea_id" value="{{ $focusareateacher->focusarea_id }}">
                <div class="row mb-4">
                    <div class="col-md-6"><label for="focusarea_id">Focus Area</label></div>
                    <div class="col-md-6"><h3>{{ $focusareas->name }}</h3></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="lesson_id">Lesson's Subject</label></div>
                    <div class="col-md-6">
                        <select name="lesson_id" id="lesson_id" class="form-control">
                            @foreach($lessons as $lesson)
                                <option <?php echo($focusareateacher->lesson_id === $lesson->id ? 'selected="selected"' : '') ?> value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="embeded_url">Embeded URL</label></div>
                    <div class="col-md-6">
                        <input type="url" name="embeded_url" class="form-control" value="{{ $focusareateacher->embeded_url }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/teacher/lessons-materials/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-6">
    </div>
@endsection