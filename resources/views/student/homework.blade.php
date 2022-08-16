@extends('layouts.auth')

@section('content')
    <div class="col-md-11">
        <div class="topSection tblLessonPnl px-4 py-4 bgWhite">
            <h2 class="mb-4">Homework</h2>
            <h4 class="mb-4">PLease answer the questions below:</h4>
            <h5><em>{{ $instruct }}</em></h5>
            <form class="mt-4 mb-4" method="POST" action="/homeworksave" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="homework_id" value="{{ $homework_id }}">
                <input type="hidden" name="student_id" value="{{ $studentID }}">
                <div class="row">
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($myHomeWork as $data)
                        <div class="col-md-6 ">
                            <div class="myQuesDiv mb-4">
                                <h4>{{ $counter }}. {{ $data->question }}</h4>
                                @php
                                    $countIn = 1;
                                    $answers = json_decode($data->answer);
                                @endphp
                                @foreach($answers as $answer)
                                    <div class="form-check">
                                        <input type="radio" {{ $data->answer_name === $answer ? 'checked' : '' }} id="question{{ $data->id.$countIn }}" class="form-check-input" value="{{ $answer }}" name="question[{{ $data->id }}]">
                                        <label class="form-check-label" for="question{{ $data->id.$countIn }}">{{ $answer }}</label>
                                    </div>
                                    @php
                                        $countIn++;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                </div>
                <div class="btnsBtmSec pull-right" style="display:flex">
                    <button type="submit" class="btn btn-primary btnStndrd btnGreen mr-2">Save</button>
                    <a class="btnStndrd btnGray" href="/past-future-lesson">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    
});
</script>
@endsection