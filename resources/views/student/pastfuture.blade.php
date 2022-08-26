@extends('layouts.auth')

@section('content')
    <script>
        function myFunction(myDate, myClass) {
            var countDownDate = new Date(myDate).getTime();
            var x = setInterval(function() {
                var now = new Date().getTime();
                // Find the distance between now an the count down date
                var distance = countDownDate - now;
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                // Output the result in an element with id="counter"11
                //document.getElementById("counter").innerHTML = days + "Day : " + hours + "h " +minutes + "m " + seconds + "s ";
                jQuery('.the-final-countdown'+myClass+' p').html(days + "Day : " + hours + "h " +minutes + "m " + seconds + "s Left");
                // If the count down is over, write some text 
                if (distance < 0) {
                    jQuery('.the-final-countdown'+myClass+' p').html('Conducted')
                }
            }, 1000);
        }
    </script>
    <div class="col-md-7 noPadRight">
        <div class="topSection tblLessonPnl px-4 py-4 bgWhite">
            <h2 class="mb-4">Completed Lessons ({{ $compCount }})</h2>
            <div class="table-responsive mt-4">
                <table class="table" id="myDataTable">
                    <thead>
                        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @foreach ($compEvents as $events)
                            @php
                                //dd($events);
                                $myImage = asset('images/placeholderimage.png');
                                $myDate  = date('m/d/Y', strtotime($events->start));
                                if(!empty($events->teacherimage))
                                    $myImage = asset('images/users/'.$events->teacherimage);
                            @endphp
                            <tr>
                                <td class="align-middle">{{ $counter }}</td>
                                <td class="align-middle"><img class="rounded-circle imgmr-1" style="width:35px; height:35px;" src="{{ $myImage }}" alt="{{ $events->teacher }}" title="{{ $events->teacher }}" /> {{ $events->teacher }}</td>
                                <td class="align-middle">{{ $myDate }}</td>
                                <td class="align-middle">{{ $events->focusarea }}</td>
                                <td class="text-nowrap align-middle">{!! empty($events->lesson_url) ? '' : '<button type="button" class="btn linkBlue video-btn" data-toggle="modal" data-src="'.$events->lesson_url.'" data-target="#myModalStudents">Recording</button>' !!}</td>
                                {{-- <td class="text-nowrap align-middle"> {!! empty($events->kajabi_url) ? '' : '<a class="linkBlue" href="'.$events->kajabi_url.'" target="_blank">Kajabi</a>' !!}</td> --}}
                                <td class="text-nowrap align-middle">
                                    {!! empty($events->pdf_data) ? '' : '<a class="linkBlue" href="'.asset('images/users/'.$events->pdf_data).'" target="_blank">Slide</a>' !!}
                                    {!! empty($events->pdf_data_sec) ? '' : '<br /><a class="linkBlue" href="'.asset('images/users/'.$events->pdf_data_sec).'" target="_blank">Slide Two</a>' !!}
                                </td>
                                <td class="text-nowrap align-middle">{!! empty($events->homeworkurl) ? '' : '<a class="linkBlue" href="/homework/'.$events->homeworkurl.'">Homework</a>' !!}</td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="topSection tblLessonPnlRight px-4 py-4 bgWhite">
            <h2 class="mb-4">Upcoming Lessons ({{ $futCount }})</h2>
             @php
                $counterBtm = 1;
            @endphp
            @foreach ($futureEvents as $events)
                @php
                    //dd($events->homeworkid);
                    $myImage = asset('images/placeholderimage.png');
                    $start   = date('D, M d, h:i', strtotime($events->start));
                    $end     = date('h:i a', strtotime($events->end));
                    $timerDat= date("F d, Y H:i:s", strtotime($events->start));
                    $myDate  = $start.' - '.$end;
                    $eID     = $events->id;
                    if(!empty($events->teacherimage))
                        $myImage = asset('images/users/'.$events->teacherimage);
                @endphp
                <div class="mt-4 upcomingLessons">
                    <div class="row">
                        <div class="col-md-6"><h4>{{ $myDate }}</h4></div>
                        <div class="col-md-6 txtRight">{{-- <a class="editLess" href="#"><i class="fa fa-pencil"></i> Edit Lesson</a> --}}</div>
                    </div>
                    <div class="mt-1 px-2 py-2 btmSecLesson">
                        <div class="teacherInfo">
                            <img class="rounded-circle imgmr-1" style="width:50px; height:50px;"  src="{{ $myImage }}" alt="{{ $events->teacher }}" title="{{ $events->teacher }}" />
                            <p class="brdrRight">{{ $events->teacher }}</p>
                            <p class="textSecPnl">{{ $events->expertise }}</p>
                        </div>
                        <div class="mt-4 px-3 py-3">
                            <div style="display:flex">
                                <img class="imgmr-1" style="height:21px;"  src="{{ asset('images/playbutton.png') }}" alt="" title="" />
                                <p><strong>{{ $events->focusarea }}</strong></p>
                            </div>
                            @if(!empty($events->pdf_data))
                                <div class="txtSmall">
                                    <p>To-Do List</p>
                                    <div class="brdrGray mb-1">
                                        <div class="form-check">
                                            <input type="checkbox" {!! ($events->file_downloaded === 1) ? 'checked disabled' : '' !!} class="form-check-input articleDownload" data-id="{{ $events->id }}" data-file="1" data-url="{{ asset('images/users/'.$events->pdf_data) }}" id="check-{{ $events->id }}"><label class="form-check-label" for="check-{{ $events->id }}">Article for lesson</label>
                                            @if(!empty($events->pdf_data_sec))
                                                <br /><input type="checkbox" {!! ($events->file_sec_down === 1) ? 'checked disabled' : '' !!} class="form-check-input articleDownload" data-id="{{ $events->id }}" data-file="2" data-url="{{ asset('images/users/'.$events->pdf_data_sec) }}" id="check-{{ $events->id }}_sec"><label class="form-check-label" for="check-{{ $events->id }}_sec">Article for lesson</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="btnsBtmSec pull-right mt-2">
                                <script type = "text/javascript">myFunction('{!! $timerDat !!}', '{!! $eID !!}');</script>
                                <div class="the-final-countdown the-final-countdown{{ $events->id }}"><p></p></div>
                                {!! empty($events->zoom_link) ? '' : '<a class="enterLesson" href="'.$events->zoom_link.'" target="_blank">Enter Lesson</a>' !!}
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $counterBtm++;
                @endphp
            @endforeach
        </div>
    </div>

    <!-- Modal For Playing Video -->
    <div class="modal fade" id="myModalStudents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-height:1000px;">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive">
                        {{-- <iframe src="" title="" frameborder="0" id="video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                        <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always" allow="autoplay" target="_parent"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal For Playing Video -->

    <!-- Modal Event Open -->
    <div class="modal" id="myModalSmall" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modalEvents modal-dialog-centered" role="document">
        <div class="modal-content px-4 py-4"></div>
        </div>
    </div>
    <!-- Modal Event Open -->
@endsection

@section('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.rawgit.com/JacobLett/bootstrap4-latest/master/bootstrap-4-latest.min.js"></script>
<script>
$(document).ready(function () {
    $('#myModalSmall').modal({
      backdrop: 'static', 
      keyboard: false
    });
    $('#myDataTable').DataTable({
        pageLength: 20,
        lengthMenu: [
            [20, 50, 100, 500],
            [20, 50, 100, 500]
        ],
        info: false,
        lengthChange: false,
        paging: false,
        searching: false
    });
    var $videoSrc; 
    $('.video-btn').click(function() {
        //alert('test');
        $videoSrc = $(this).data( "src" );
    });

    
    $(document).off('click', '.articleDownload').on('click', '.articleDownload', function(){
      var myEventID = $(this).attr('data-id');
      var myFile    = $(this).attr('data-url');
      var myFileNum = $(this).attr('data-file');
      $('#myModalSmall .modal-content').html('<div class="text-center"><strong>Please wait...</strong><br /><div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div></div>');
      $('#myModalSmall').modal('show');
      //editData editFormData 
      $.ajax({
        url: "{{url('/')}}/downlaod-lesson",
        type:'POST',
        data: {_token:"{{ csrf_token() }}", myEventID:myEventID, myFileNum:myFileNum},
        success: function(data) {
            $('#myModalSmall').modal('hide');
            $('#check-'+myEventID).prop('disabled', true);
            window.open(myFile, '_blank');
            location.reload();
            return false;
        }
      });
    });
    //console.log($videoSrc);
    // when the modal is opened autoplay it  
    $('#myModalStudents').on('shown.bs.modal', function (e) {  
        // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
        $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
    });
    // stop playing the youtube video when I close the modal
    $('#myModalStudents').on('hide.bs.modal', function (e) {
        // a poor man's stop video
        $("#video").attr('src', ''); 
    });
});
</script>
@endsection