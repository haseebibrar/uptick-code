@extends('layouts.auth')

@section('content')
    <div class="col-md-11">
        <div class="topSection tblLessonPnl px-4 py-4 bgWhite">
            <h2 class="mb-4">Open Lessons ({{ $countLessons }})</h2>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="msgSuccess">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="table-responsive mt-4">
                <table class="table" id="myDataTable">
                    <thead>
                        <tr><th></th><th></th><th></th><th></th></tr>
                    </thead>
                    <tbody>
                        @php
                            //dd($openLessons);
                            $counter = 1;
                        @endphp
                        @foreach ($openLessons as $events)
                            @php
                                //dd($events);
                                $myImage = asset('images/placeholderimage.png');
                                $myDate  = date('m/d/Y', strtotime($events->start));
                                if(!empty($events->studentimage))
                                    $myImage = asset('images/users/'.$events->studentimage);
                                $myTime = date('H:i', strtotime($events->start)).' - '.date('H:i a', strtotime($events->end));
                                $myClass= 'btnLesson'.$events->status;
                                $statusText = 'Completed';
                                if($events->status === "canceled")
                                    $statusText = 'Canceled';
                            @endphp
                            <tr>
                                <td class="align-middle">{{ $counter }}</td>
                                <td class="align-middle"><img class="rounded-circle imgmr-1" style="width:35px; height:35px;" src="{{ $myImage }}" alt="{{ $events->student }}" title="{{ $events->student }}" /> {{ $events->student }}</td>
                                <td class="align-middle"><span style="margin-right:1rem;">{{ $myDate }}</span> | <span style="margin-right:1rem; margin-left:1rem; width:125px; display:inline-block;">{{ $myTime }}</span> | <span style="margin-left:1rem;">{{ $events->focusarea }}</span></td>
                                <td class="align-middle">
                                    <a class="genClassTblt btnLessonscheduled" href="{{ route('lesson-material') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('lesson-form-{{ $events->id }}').submit();">
                                        {{ __('Completed') }}
                                    </a>
                                    <form id="lesson-form-{{ $events->id }}" action="{{ route('lesson-material') }}" method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" value="{{ $events->id }}" name="event_id">
                                        <input type="hidden" value="{{ $events->focusarea_id }}" name="focus_id">
                                        <input type="hidden" value="{{ $events->focusarea }}" name="focus_name">
                                    </form>
                                    <a class="genClassTblt btnCancel btnLessoncanceled" data-id="{{ $events->id }}" href="#">Canceled</a>
                                </td>
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

    <!-- Modal Event Open -->
    <div class="modal" id="myModalDel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modalEvents modal-dialog-centered" role="document">
        <div class="modal-content px-4 py-4">
            <div style="font-size: 15px; text-align:center;" class="mb-4">Are you sure this lesson was canceled?</div>
            <div style="display:flex; text-align:center; margin: 0 auto;">
            <a href="javascript:void(0)" class="btnStndrd btnGreen closeModal" style="margin-right: 10px;">No</a>
            <a href="" data-id="" class="btnDelEvent btnStndrd btnGray">Yes</a>
            </div>
        </div>
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
    $(document).off('click', '.btnLessoncanceled').on('click', '.btnLessoncanceled', function(){
        $('#myModalDel').modal('show');
        var myEventID = $(this).attr('data-id');
        $('.btnDelEvent').attr('href', '/teacher/cancel-lesson/'+myEventID);
    });
    $(document).off('click', '.closeModal').on('click', '.closeModal', function(){
        $('#myModalDel').modal('hide');
    });
    $('#msgSuccess').delay(3000).fadeOut('slow');
});
</script>
@endsection