@extends('layouts.auth')

@section('content')
    <div class="col-md-5 ">
        <div class="topSection px-4 py-4 bgWhite">
            <h1 class="txtLeft">Upload lesson's materials</h1>
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
            <form class="mt-4 mb-4" method="POST" action="/teacher/lessons-material/add" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $eventID }}" name="event_id">
                <div class="row mb-4">
                    <div class="col-md-6"><label>Focus Area:</label></div>
                    <div class="col-md-6">{{ $focusName }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="lesson_id">Lesson's Subject</label></div>
                    <div class="col-md-6">
                        <select name="lesson_id" id="lesson_id" class="form-control" required>
                            <option>Please Select</option>
                            @foreach($lessonSubs as $lesson)
                                <option {{ $lessonID === $lesson->id ? 'selected' : '' }} value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="embeded_url">Embedded video url</label></div>
                    <div class="col-md-6">
                        <input type="url" name="embeded_url" class="form-control" value="{{ $lessonUrl }}">
                    </div>
                </div>
                {{-- <div class="row mb-4">
                    <div class="col-md-6"><label for="embeded_url">Kajabi link</label></div>
                    <div class="col-md-6">
                        <input type="url" name="kajabi_url" class="form-control" value="{{ $kajabiUrl }}">
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/teacher/open-lesson/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-6">
    </div>
@endsection