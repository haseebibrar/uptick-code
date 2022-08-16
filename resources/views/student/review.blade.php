@extends('layouts.auth',['checkreview'=> 1])
@section('content')
  <div class="col-md-11 noPadRight">
      <div class="topSection px-4 py-4 bgWhite">
          <h2 class="mb-4">Submit review for your {{ $student->focusarea }} lesson with {{ $student->teacher }}</h2>
          <div class="col-md-6">
            <form method="POST" action="/submit-review" id="frmEvent" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-3"><label style="padding-top: 14px;">Rating</label></div>
                    <div class="col-md-6">
                        <div class="rating"> <input type="radio" name="rating" value="5" id="5" required><label for="5">☆</label> <input type="radio" required name="rating" value="4" id="4"><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3" required><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2" required><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1" required><label for="1">☆</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3"><label for="review">Review</label></div>
                    <div class="col-md-6">
                        <textarea name="review" class="form-control" style="height:100px;"></textarea>
                    </div>
                </div>
                <input type="hidden" name="event_id" id="event_id" value="{{ $student->id }}">
                <button type="submit" class="btn btn-primary btnGreen">Submit Review</button>
            </form>
          </div>
          <div class="col-md-6"></div>
      </div>
  </div>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
    
    $(document).off('click', '.editEvent').on('click', '.editEvent', function(){
      $('#zoomLink').hide();
      var myEventID = $(this).attr('data-id');
      $('#eventeditid').val(myEventID);
      $('#myModalSmall .modal-content').html('<div class="text-center"><strong>Loading...</strong><br /><div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div></div>');
      $('#myModalSmall').modal('show');
      $('.editData').hide();
      $('.editFormData, .btnGreenEdit').show();
      //editData editFormData 
      $.ajax({
        url: "{{url('/')}}/showeditevent",
        type:'POST',
        data: {_token:"{{ csrf_token() }}", myEventID:myEventID},
        success: function(data) {
          $('#myModalSmall').modal('hide');
          $('#myModalSec').modal('show');
          //$('.editdatepicker').val(myDateFull);
          $('.editdatepicker').datepicker({
            autoclose : true,
            format    : 'M dd yyyy',
            startDate : 'd'
          });
          $('.timeDiv').html(data);
        }
      });
    });
  });
</script>
@endsection