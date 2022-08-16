@extends('layouts.auth')

@section('content')
    <div class="col-md-7">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Edit Record</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="msgSuccess">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <form class="mt-4 mb-4" method="POST" action="/admin/homework/update" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="homeworkid" value="{{ $homeworks->id }}">
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ $homeworks->name }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Instructions</label></div>
                    <div class="col-md-6">
                        <input type="text" name="instructions_text" class="form-control" value="{{ $homeworks->instructions_text }}">
                    </div>
                </div>
                <div class="dynamicAddRemove">
                    @php
                        //dd($homeworks->homeworkdetails);
                        $counter = 1;
                    @endphp
                    @foreach($homeworks->homeworkdetails as $details)
                        <input type="hidden" name="question[{{ $details->id }}][id]" value="{{ $details->id }}">
                        <div class="jsondata jsondata-{{ $details->id }}" data-id="{{ $details->id }}">
                            <div class="row mb-4">
                                <div class="col-md-6"><label for="name">Question</label></div>
                                <div class="col-md-4">
                                    <input type="text" name="question[{{ $details->id }}][name]" class="form-control" value="{{ $details->question }}">
                                </div>
                                @php
                                    //dd(json_decode($details->answer));
                                    if($counter === 1)
                                        echo '<div class="col-md-2"><button type="button" name="add" id="add-btn" class="btn btn-success">Add More</button></div>';
                                    else
                                        echo '<div class="col-md-2"><button type="button" data-id="'.$details->id.'" class="btn btn-danger remove-div">Remove</button></div>';
                                    
                                    $countIn = 1;
                                    $answers = json_decode($details->answer);
                                @endphp
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6"><label for="name">Possible Answers</label></div>
                                <div class="col-md-4">
                                    @foreach($answers as $answer)
                                        <input type="text" name="question[{{ $details->id }}][answer][{{ $countIn }}]" class="form-control mb-1" value="{{ $answer }}">
                                        @php
                                            $countIn++;
                                        @endphp
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6"><label for="name">Final Answers</label></div>
                                <div class="col-md-4">
                                    <input type="text" name="question[{{ $details->id }}][final_answer]" class="form-control mb-1" value="{{ $details->final_answer }}">
                                </div>
                            </div>
                        </div>
                        @php
                            // dd($homeworks->homeworkdetails);
                            $counter++;
                        @endphp
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/admin/lessonsubject/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-4"></div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var i = $('.dynamicAddRemove div.jsondata:last').attr('data-id');
            $(document).off('click', '#add-btn').on('click', '#add-btn', function(){
                ++i;
                //alert(i);
                $(".dynamicAddRemove").append('<div class="jsondata-'+i+'"><div class="row mb-4"><div class="col-md-6"><label for="name">Question</label></div><div class="col-md-4"><input type="text" name="question['+i+'][name]" class="form-control" value=""></div><div class="col-md-2"><button type="button" data-id="'+i+'" class="btn btn-danger remove-div newdiv">Remove</button></div></div><div class="row mb-4"><div class="col-md-6"><label for="name">Possible Answers</label></div><div class="col-md-4"><input type="text" name="question['+i+'][answer][1]" class="form-control mb-1" value=""><input type="text" name="question['+i+'][answer][2]" class="form-control mb-1" value=""><input type="text" name="question['+i+'][answer][3]" class="form-control mb-1" value=""><input type="text" name="question['+i+'][answer][4]" class="form-control" value=""></div></div><div class="row mb-4"><div class="col-md-6"><label for="name">Final Answers</label></div><div class="col-md-4"><input type="text" name="question['+i+'][final_answer]" class="form-control mb-1" value=""></div></div></div>');
            });
            $(document).off('click', '.remove-div').on('click', '.remove-div', function(){  
                if($(this).hasClass('newdiv')){
                    var myDivID = $(this).attr('data-id');
                    $('.jsondata-'+myDivID).remove();
                    return false;
                }else{
                    if(confirm("Are you sure you want to delete this?")){
                        myID = $(this).attr('data-id');
                        window.location = "/admin/homework/delete/"+myID;
                    }
                    else{
                        return false;
                    }
                }
            });
            $('#msgSuccess').delay(3000).fadeOut('slow');
        });
    </script>
@endsection