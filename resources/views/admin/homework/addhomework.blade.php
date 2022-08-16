@extends('layouts.auth')

@section('content')
    <div class="col-md-7">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Add Homework</h1>
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
            <form class="mt-4 mb-4" method="POST" action="/admin/homework/add" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="focusarea_id" value="{{ $focusID }}">
                <input type="hidden" name="lesson_id" value="{{ $lessonID }}">
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Instructions</label></div>
                    <div class="col-md-6">
                        <input type="text" name="instructions_text" class="form-control" value="{{ old('instructions_text') }}">
                    </div>
                </div>
                <div class="dynamicAddRemove">
                    <div class="jsondata">
                        <div class="row mb-4">
                            <div class="col-md-6"><label for="name">Question</label></div>
                            <div class="col-md-4">
                                <input type="text" name="question[0][name]" class="form-control" value="">
                            </div>
                            <div class="col-md-2">
                                <button type="button" name="add" id="add-btn" class="btn btn-success">Add More</button>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6"><label for="name">Possible Answers</label></div>
                            <div class="col-md-4">
                                <input type="text" name="question[0][answer][1]" class="form-control mb-1" value="">
                                <input type="text" name="question[0][answer][2]" class="form-control mb-1" value="">
                                <input type="text" name="question[0][answer][3]" class="form-control mb-1" value="">
                                <input type="text" name="question[0][answer][4]" class="form-control" value="">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6"><label for="name">Final Answers</label></div>
                            <div class="col-md-4">
                                <input type="text" name="question[0][final_answer]" class="form-control mb-1" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/admin/homework/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-4">
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var i = 0;
        $(document).off('click', '#add-btn').on('click', '#add-btn', function(){
            ++i;
            //alert(i);
            $(".dynamicAddRemove").append('<div class="jsondata-'+i+'"><div class="row mb-4"><div class="col-md-6"><label for="name">Question</label></div><div class="col-md-4"><input type="text" name="question['+i+'][name]" class="form-control" value=""></div><div class="col-md-2"><button type="button" data-id="'+i+'" class="btn btn-danger remove-div">Remove</button></div></div><div class="row mb-4"><div class="col-md-6"><label for="name">Possible Answers</label></div><div class="col-md-4"><input type="text" name="question['+i+'][answer][1]" class="form-control mb-1" value=""><input type="text" name="question['+i+'][answer][2]" class="form-control mb-1" value=""><input type="text" name="question['+i+'][answer][3]" class="form-control mb-1" value=""><input type="text" name="question['+i+'][answer][4]" class="form-control" value=""></div></div><div class="row mb-4"><div class="col-md-6"><label for="name">Final Answers</label></div><div class="col-md-4"><input type="text" name="question['+i+'][final_answer]" class="form-control mb-1" value=""></div></div></div>');
        });
        $(document).on('click', '.remove-div', function(){  
            var myDivID = $(this).attr('data-id');
            $('.jsondata-'+myDivID).remove();
            return false;
        });
    </script>
@endsection