@extends('layouts.auth')
@push('css')
    <link href="{{ asset('lib/main.css') }}" rel="stylesheet" type='text/css'>
    <style>
        #calendarteacher {
            max-width: 1100px;
            margin: 0 auto;
        }
    </style>
@endpush
@section('content')
  @php
    //dd($sunData);
    $sunCount = 1;
    $monCount = 1;
    $tueCount = 1;
    $wedCount = 1;
    $thuCount = 1;
    $friCount = 1;
    $satCount = 1;
  @endphp
  
  <div class="col-md-7 noPadRight">
    <div class="topSection px-4 py-4 bgWhite">
      <h2 class="mb-4">Schedule a lesson</h2>
      <div id='loading'>loading...</div>
      <div id='calendarteacher'></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="topSection px-4 py-4 myHeight bgWhite">
      @if ($message = Session::get('success'))
        <div class="alert alert-success" id="msgSuccess">
          <p>{{ $message }}</p>
        </div>
      @endif
      <h3 class="mb-4 text-center">Set your weekly hours</h3>
      <div class="innerSec">
        <form class="mt-4 mb-4" method="POST" action="/teacher/updatetime" enctype="multipart/form-data">
          @csrf
          <div class="dynamicAddRemove dynamicAddRemovesun">
            @if(!empty($sunData))
              @foreach ($sunData as $sun)
                <div class="form-check mb-2 row d-flex sun-{{ $sunCount }}">
                  <div class="col-md-2">
                    @if($sunCount === 1)
                      <input type="checkbox" name="suncheck[0][name]" class="form-check-input sch" id="focus-1" checked="checked" value="sun">
                      <label class="form-check-label" for="focus-1">Sun</label>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <select name="suncheck[0][time][{{ $sunCount }}][1]" class="form-control sun" id="sun-1">
                      <option value="unavailable">Unavailable</option>
                      {!! $sun[1] !!}
                    </select>
                  </div>
                  <div class="col-md-1 sun-hide"> - </div>
                  <div class="col-md-4 sun-hide"><select name="suncheck[0][time][{{ $sunCount }}][2]" class="form-control sun" id="sun-2">
				  <option value="unavailable">Unavailable</option>{!! $sun[2] !!}</select></div>
                  <div class="col-md-1 sun-hide">
                    @if($sunCount === 1)
                      <button type="button" data-day="sun" class="btn addTimeBtn">+</button>
                    @else
                      <button type="button" data-day="sun" data-id="{{ $sunCount }}" class="btn removeTimeBtn">-</button>
                    @endif
                  </div>
                </div>
                @php
                  $sunCount++;
                @endphp
              @endforeach
            @else
              <div class="form-check mb-2 row d-flex">
                <div class="col-md-2">
                  <input type="checkbox" name="suncheck[0][name]" class="form-check-input sch" id="focus-1" value="sun">
                  <label class="form-check-label" for="focus-1">Sun</label>
                </div>
                <div class="col-md-4">
                  <select name="suncheck[0][time][0][1]" class="form-control sun" id="sun-1">
                    <option value="unavailable">Unavailable</option>
                    {!! $myTime !!}
                  </select>
                </div>
                <div class="col-md-1 sun-hide"> - </div>
                <div class="col-md-4 sun-hide"><select name="suncheck[0][time][0][2]" class="form-control sun" id="sun-2"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div>
                <div class="col-md-1"><button type="button" data-day="sun" class="btn addTimeBtn">+</button></div>
              </div>
            @endif
          </div>

          <div class="dynamicAddRemove dynamicAddRemovemon">
            @if(!empty($monData))
              @foreach ($monData as $mon)
                <div class="form-check mb-2 row d-flex mon-{{ $monCount }}">
                  <div class="col-md-2">
                    @if($monCount === 1)
                      <input type="checkbox" name="moncheck[0][name]" class="form-check-input sch-2" id="focus-2" checked="checked" value="mon">
                      <label class="form-check-label" for="focus-2">Mon</label>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <select name="moncheck[0][time][{{ $monCount }}][1]" class="form-control mon" id="mon-1">
                      <option value="unavailable">Unavailable</option>
                      {!! $mon[1] !!}
                    </select>
                  </div>
                  <div class="col-md-1 mon-hide"> - </div>
                  <div class="col-md-4 mon-hide"><select name="moncheck[0][time][{{ $monCount }}][2]" class="form-control mon" id="mon-2"><option value="unavailable">Unavailable</option>{!! $mon[2] !!}</select></div>
                  <div class="col-md-1 mon-hide">
                    @if($monCount === 1)
                      <button type="button" data-day="mon" class="btn addTimeBtn">+</button>
                    @else
                      <button type="button" data-day="mon" data-id="{{ $monCount }}" class="btn removeTimeBtn">-</button>
                    @endif
                  </div>
                </div>
                @php
                  $monCount++;
                @endphp
              @endforeach
            @else
              <div class="form-check mb-2 row d-flex">
                <div class="col-md-2">
                  <input type="checkbox" name="moncheck[0][name]" class="form-check-input sch-2" id="focus-2" value="mon">
                  <label class="form-check-label" for="focus-2">Mon</label>
                </div>
                <div class="col-md-4">
                  <select name="moncheck[0][time][0][1]" class="form-control mon" id="mon-1">
                    <option value="unavailable">Unavailable</option>
                    {!! $myTime !!}
                  </select>
                </div>
                <div class="col-md-1 mon-hide"> - </div>
                <div class="col-md-4 mon-hide"><select name="moncheck[0][time][0][2]" class="form-control mon" id="mon-2"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div>
                <div class="col-md-1 mon-hide"><button type="button" data-day="mon" class="btn addTimeBtn">+</button></div>
              </div>
            @endif
          </div>

          <div class="dynamicAddRemove dynamicAddRemovetue">
            @if(!empty($tueData))
              @foreach ($tueData as $tue)
                <div class="form-check mb-2 row d-flex tue-{{ $tueCount }}">
                  <div class="col-md-2">
                    @if($tueCount === 1)
                      <input type="checkbox" name="tuecheck[0][name]" class="form-check-input sch-3" id="focus-3" checked="checked" value="tue">
                      <label class="form-check-label" for="focus-3">Tue</label>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <select name="tuecheck[0][time][{{ $tueCount }}][1]" class="form-control tue" id="tue-1">
                      <option value="unavailable">Unavailable</option>
                      {!! $tue[1] !!}
                    </select>
                  </div>
                  <div class="col-md-1 tue-hide"> - </div>
                  <div class="col-md-4 tue-hide"><select name="tuecheck[0][time][{{ $tueCount }}][2]" class="form-control tue" id="tue-2"><option value="unavailable">Unavailable</option>{!! $tue[2] !!}</select></div>
                  <div class="col-md-1 tue-hide">
                    @if($tueCount === 1)
                      <button type="button" data-day="tue" class="btn addTimeBtn">+</button>
                    @else
                      <button type="button" data-day="tue" data-id="{{ $tueCount }}" class="btn removeTimeBtn">-</button>
                    @endif
                  </div>
                </div>
                @php
                  $tueCount++;
                @endphp
              @endforeach
            @else
              <div class="form-check mb-2 row d-flex">
                <div class="col-md-2">
                  <input type="checkbox" name="tuecheck[0][name]" class="form-check-input sch-3" id="focus-3" value="tue">
                  <label class="form-check-label" for="focus-3">Tue</label>
                </div>
                <div class="col-md-4">
                  <select name="tuecheck[0][time][0][1]" class="form-control tue" id="tue-1"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select>
                </div>
                <div class="col-md-1 tue-hide"> - </div>
                <div class="col-md-4 tue-hide"><select name="tuecheck[0][time][0][2]" class="form-control tue" id="tue-2"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div>
                <div class="col-md-1 tue-hide"><button type="button" data-day="tue" class="btn addTimeBtn">+</button></div>
              </div>
            @endif
            
          </div>

          <div class="dynamicAddRemove dynamicAddRemovewed">
            @if(!empty($wedData))
              @foreach ($wedData as $wed)
                <div class="form-check mb-2 row d-flex wed-{{ $wedCount }}">
                  <div class="col-md-2">
                    @if($wedCount === 1)
                      <input type="checkbox" name="wedcheck[0][name]" class="form-check-input sch-4" id="focus-4" checked="checked" value="wed">
                      <label class="form-check-label" for="focus-4">Wed</label>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <select name="wedcheck[0][time][{{ $wedCount }}][1]" class="form-control wed" id="wed-1">
                      <option value="unavailable">Unavailable</option>
                      {!! $wed[1] !!}
                    </select>
                  </div>
                  <div class="col-md-1 wed-hide"> - </div>
                  <div class="col-md-4 wed-hide"><select name="wedcheck[0][time][{{ $wedCount }}][2]" class="form-control wed" id="wed-2"><option value="unavailable">Unavailable</option>{!! $wed[2] !!}</select></div>
                  <div class="col-md-1 wed-hide">
                    @if($wedCount === 1)
                      <button type="button" data-day="wed" class="btn addTimeBtn">+</button>
                    @else
                      <button type="button" data-day="wed" data-id="{{ $wedCount }}" class="btn removeTimeBtn">-</button>
                    @endif
                  </div>
                </div>
                @php
                  $wedCount++;
                @endphp
              @endforeach
            @else
              <div class="form-check mb-2 row d-flex">
                <div class="col-md-2">
                  <input type="checkbox" name="wedcheck[0][name]" class="form-check-input sch-4" id="focus-4" value="wed">
                  <label class="form-check-label" for="focus-4">Wed</label>
                </div>
                <div class="col-md-4">
                  <select name="wedcheck[0][time][0][1]" class="form-control wed" id="wed-1">
                    <option value="unavailable">Unavailable</option>
                    {!! $myTime !!}
                  </select>
                </div>
                <div class="col-md-1 wed-hide"> - </div>
                <div class="col-md-4 wed-hide"><select name="wedcheck[0][time][0][2]" class="form-control wed" id="wed-2"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div>
                <div class="col-md-1 wed-hide"><button type="button" data-day="wed" class="btn addTimeBtn">+</button></div>
              </div>
            @endif
          </div>

          <div class="dynamicAddRemove dynamicAddRemovethu">
            @if(!empty($thuData))
              @foreach ($thuData as $thu)
                <div class="form-check mb-2 row d-flex thu-{{ $thuCount }}">
                  <div class="col-md-2">
                    @if($thuCount === 1)
                      <input type="checkbox" name="thucheck[0][name]" class="form-check-input sch-5" id="focus-5" checked="checked" value="thu">
                      <label class="form-check-label" for="focus-5">Thu</label>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <select name="thucheck[0][time][{{ $thuCount }}][1]" class="form-control thu" id="thu-1">
                      <option value="unavailable">Unavailable</option>
                      {!! $thu[1] !!}
                    </select>
                  </div>
                  <div class="col-md-1 thu-hide"> - </div>
                  <div class="col-md-4 thu-hide"><select name="thucheck[0][time][{{ $thuCount }}][2]" class="form-control thu" id="thu-2"><option value="unavailable">Unavailable</option>{!! $thu[2] !!}</select></div>
                  <div class="col-md-1 thu-hide">
                    @if($thuCount === 1)
                      <button type="button" data-day="thu" class="btn addTimeBtn">+</button>
                    @else
                      <button type="button" data-day="thu" data-id="{{ $thuCount }}" class="btn removeTimeBtn">-</button>
                    @endif
                  </div>
                </div>
                @php
                  $thuCount++;
                @endphp
              @endforeach
            @else
              <div class="form-check mb-2 row d-flex">
                <div class="col-md-2">
                  <input type="checkbox" name="thucheck[0][name]" class="form-check-input sch-5" id="focus-5" value="thu">
                  <label class="form-check-label" for="focus-5">Thu</label>
                </div>
                <div class="col-md-4">
                  <select name="thucheck[0][time][0][1]" class="form-control thu" id="thu-1">
                    <option value="unavailable">Unavailable</option>
                    {!! $myTime !!}
                  </select>
                </div>
                <div class="col-md-1 thu-hide"> - </div>
                <div class="col-md-4 thu-hide"><select name="thucheck[0][time][0][2]" class="form-control thu" id="thu-2"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div>
                <div class="col-md-1 thu-hide"><button type="button" data-day="thu" class="btn addTimeBtn">+</button></div>
              </div>
            @endif
          </div>

          <div class="dynamicAddRemove dynamicAddRemovefri">
            @if(!empty($friData))
              @foreach ($friData as $fri)
                <div class="form-check mb-2 row d-flex fri-{{ $friCount }}">
                  <div class="col-md-2">
                    @if($friCount === 1)
                      <input type="checkbox" name="fricheck[0][name]" class="form-check-input sch-6" id="focus-6" checked="checked" value="fri">
                      <label class="form-check-label" for="focus-6">Fri</label>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <select name="fricheck[0][time][{{ $friCount }}][1]" class="form-control fri" id="fri-1">
                      <option value="unavailable">Unavailable</option>
                      {!! $fri[1] !!}
                    </select>
                  </div>
                  <div class="col-md-1 fri-hide"> - </div>
                  <div class="col-md-4 fri-hide"><select name="fricheck[0][time][{{ $friCount }}][2]" class="form-control fri" id="fri-2"><option value="unavailable">Unavailable</option>{!! $fri[2] !!}</select></div>
                  <div class="col-md-1 fri-hide">
                    @if($friCount === 1)
                      <button type="button" data-day="fri" class="btn addTimeBtn">+</button>
                    @else
                      <button type="button" data-day="fri" data-id="{{ $friCount }}" class="btn removeTimeBtn">-</button>
                    @endif
                  </div>
                </div>
                @php
                  $friCount++;
                @endphp
              @endforeach
            @else
              <div class="form-check mb-2 row d-flex">
                <div class="col-md-2">
                  <input type="checkbox" name="fricheck[0][name]" class="form-check-input sch-6" id="focus-6" value="fri">
                  <label class="form-check-label" for="focus-6">Fri</label>
                </div>
                <div class="col-md-4">
                  <select name="fricheck[0][time][0][1]" class="form-control fri" id="fri-1">
                    <option value="unavailable">Unavailable</option>
                    {!! $myTime !!}
                  </select>
                </div>
                <div class="col-md-1 fri-hide"> - </div>
                <div class="col-md-4 fri-hide"><select name="fricheck[0][time][0][2]" class="form-control fri" id="fri-2"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div>
                <div class="col-md-1 fri-hide"><button type="button" data-day="fri" class="btn addTimeBtn">+</button></div>
              </div>
            @endif
          </div>

          <div class="dynamicAddRemove dynamicAddRemovesat">
            @if(!empty($satData))
              @foreach ($satData as $sat)
                <div class="form-check mb-2 row d-flex sat-{{ $satCount }}">
                  <div class="col-md-2">
                    @if($satCount === 1)
                      <input type="checkbox" name="satcheck[0][name]" class="form-check-input sch-7" id="focus-7" checked="checked" value="sat">
                      <label class="form-check-label" for="focus-7">sat</label>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <select name="satcheck[0][time][{{ $satCount }}][1]" class="form-control sat" id="sat-1">
                      <option value="unavailable">Unavailable</option>
                      {!! $sat[1] !!}
                    </select>
                  </div>
                  <div class="col-md-1 sat-hide"> - </div>
                  <div class="col-md-4 sat-hide"><select name="satcheck[0][time][{{ $satCount }}][2]" class="form-control sat" id="sat-2"><option value="unavailable">Unavailable</option>{!! $sat[2] !!}</select></div>
                  <div class="col-md-1 sat-hide">
                    @if($satCount === 1)
                      <button type="button" data-day="sat" class="btn addTimeBtn">+</button>
                    @else
                      <button type="button" data-day="sat" data-id="{{ $satCount }}" class="btn removeTimeBtn">-</button>
                    @endif
                  </div>
                </div>
                @php
                  $satCount++;
                @endphp
              @endforeach
            @else
              <div class="form-check mb-2 row d-flex">
                <div class="col-md-2">
                  <input type="checkbox" name="satcheck[0][name]" class="form-check-input sch-7" id="focus-7" value="sat">
                  <label class="form-check-label" for="focus-7">Sat</label>
                </div>
                <div class="col-md-4">
                  <select name="satcheck[0][time][0][1]" class="form-control sat" id="sat-1">
                    <option value="unavailable">Unavailable</option>
                    {!! $myTime !!}
                  </select>
                </div>
                <div class="col-md-1 sat-hide"> - </div>
                <div class="col-md-4 sat-hide"><select name="satcheck[0][time][0][2]" class="form-control sat" id="sat-2"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div>
                <div class="col-md-1 sat-hide"><button type="button" data-day="sat" class="btn addTimeBtn">+</button></div>
              </div>
            @endif
          </div>

          <button type="submit" class="btn btn-primary btnGreen btnSaveTime">Save</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Event Open -->
  <div class="modal" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modalEvents modal-dialog-centered" role="document">
      <div class="modal-content px-4 py-4">
        <div class="row">
          <div style="text-align: right;">
            <a class="editEvent" data-id="" href="javascript:void(0)"><i class="fa fa-pencil"></i></a>
            <a class="dltEvent" data-id="" href="javascript:void(0)"><i class="fa fa-trash"></i></a>
            <a class="closeModal" href="javascript:void(0)"><i class="fa fa-close"></i></a>
          </div>
          <div style="font-size: 15px;">Vocabulary and Fluency</div>
          <div class="align-middle" style="font-size: 13px;"><img height="11" src="{{ asset('images/clock.svg') }}" alt="Clock" title="Clock" /> Monday, May 02, 9:00 - 10:00am</div>
          <div style="font-size: 13px;"><img height="11" src="{{ asset('images/user.svg') }}" alt="User" title="User" /> Max Smith</div>
          <div style="font-size: 13px;"><img height="11" src="{{ asset('images/bell.svg') }}" alt="Bell" title="Bell" /> 10 minutes before</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Event Open -->

  <!-- Modal Event Open -->
  <div class="modal" id="myModalSmall" tabindex="-1" role="dialog">
    <div class="modal-dialog modalEvents modal-dialog-centered" role="document">
      <div class="modal-content px-4 py-4">
          <div style="font-size: 15px; text-align:center;" class="mb-4">Are you sure you want to delete this lesson?</div>
          <div style="display:flex; text-align:center; margin: 0 auto;">
            <a href="javascript:void(0)" class="btnStndrd btnGreen closeModal" style="margin-right: 10px;">No</a>
            <a href="javascript:void(0)" data-id="" class="btnDelEvent btnStndrd btnGray">Yes</a>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- Modal Event Open -->
@endsection

@section('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lib/main.js') }}"></script>
<script>
	
	$(document).ready(function()
	{
		var sun_1 = $('#sun-1').val();
		var sun_2 = $('#sun-2').val();
		var mon_1 = $('#mon-1').val();
		var mon_2 = $('#mon-2').val();
		var tue_1 = $('#tue-1').val();
		var tue_2 = $('#tue-2').val();
		var wed_1 = $('#wed-1').val();
		var wed_2 = $('#wed-2').val();
		var thu_1 = $('#thu-1').val();
		var thu_2 = $('#thu-2').val();
		var fri_1 = $('#fri-1').val();
		var fri_2 = $('#fri-2').val();
		var sat_1 = $('#sat-1').val();
		var sat_2 = $('#sat-2').val();
		
		localStorage.setItem('sun_1', sun_1);
		localStorage.setItem('sun_2', sun_2);
		localStorage.setItem('mon_1', mon_1);
		localStorage.setItem('mon_2', mon_2);
		localStorage.setItem('tue_1', tue_1);
		localStorage.setItem('tue_2', tue_2);
		localStorage.setItem('wed_1', wed_1);
		localStorage.setItem('wed_2', wed_2);
		localStorage.setItem('thu_1', thu_1);
		localStorage.setItem('thu_2', thu_2);
		localStorage.setItem('fri_1', fri_1);
		localStorage.setItem('fri_2', fri_2);
		localStorage.setItem('sat_1', sat_1);
		localStorage.setItem('sat_2', sat_2);
	});
	
	$('.sch').on('click', function(){
		
		if (!$('input.sch').is(':checked')) {
			$(".sun").val('unavailable').change();
			$(".sun-hide").css('display', 'none');
			$("#sun-1").attr('disabled', true);
		} 
		
		if ($('input.sch').is(':checked')){
			$("#sun-1").val(localStorage.getItem('sun_1')).change();
			$("#sun-2").val(localStorage.getItem('sun_2')).change();
			$(".sun-hide").css('display', 'block');
			$("#sun-1").attr('disabled', false);
		}			
	})
	
	$('.sch-2').on('click', function(){
		
		if (!$('input.sch-2').is(':checked')) {
			$(".mon").val('unavailable').change();
			$(".mon-hide").css('display', 'none');
			$("#mon-1").attr('disabled', true);
		} 
		
		if ($('input.sch-2').is(':checked')){
			$("#mon-1").val(localStorage.getItem('mon_1')).change();
			$("#mon-2").val(localStorage.getItem('mon_2')).change();
			$(".mon-hide").css('display', 'block');
			$("#mon-1").attr('disabled', false);
		}			
	})
	
	$('.sch-3').on('click', function(){
		
		if (!$('input.sch-3').is(':checked')) {
			$(".tue").val('unavailable').change();
			$(".tue-hide").css('display', 'none');
			$("#tue-1").attr('disabled', true);
		} 
		
		if ($('input.sch-3').is(':checked')){
			$("#tue-1").val(localStorage.getItem('tue_1')).change();
			$("#tue-2").val(localStorage.getItem('tue_2')).change();
			$(".tue-hide").css('display', 'block');
			$("#tue-1").attr('disabled', false);
		}			
	})
	
	$('.sch-4').on('click', function(){
		
		if (!$('input.sch-4').is(':checked')) {
			$(".wed").val('unavailable').change();
			$(".wed-hide").css('display', 'none');
			$("#wed-1").attr('disabled', true);
		} 
		
		if ($('input.sch-4').is(':checked')){
			$("#wed-1").val(localStorage.getItem('wed_1')).change();
			$("#wed-2").val(localStorage.getItem('wed_2')).change();
			$(".wed-hide").css('display', 'block');
			$("#wed-1").attr('disabled', false);
		}			
	})
	
	$('.sch-5').on('click', function(){
		
		if (!$('input.sch-5').is(':checked')) {
			$(".thu").val('unavailable').change();
			$(".thu-hide").css('display', 'none');
			$("#thu-1").attr('disabled', true);
		} 
		
		if ($('input.sch-5').is(':checked')){
			$("#thu-1").val(localStorage.getItem('thu_1')).change();
			$("#thu-2").val(localStorage.getItem('thu_2')).change();
			$(".thu-hide").css('display', 'block');
			$("#thu-1").attr('disabled', false);
		}			
	})
	
	$('.sch-6').on('click', function(){
		
		if (!$('input.sch-6').is(':checked')) {
			$(".fri").val('unavailable').change();
			$(".fri-hide").css('display', 'none');
			$("#fri-1").attr('disabled', true);
		} 
		
		if ($('input.sch-6').is(':checked')){
			$("#fri-1").val(localStorage.getItem('fri_1')).change();
			$("#fri-2").val(localStorage.getItem('fri_2')).change();
			$(".fri-hide").css('display', 'block');
			$("#fri-1").attr('disabled', false);
		}			
	})
	
	$('.sch-7').on('click', function(){
		
		if (!$('input.sch-7').is(':checked')) {
			$(".sat").val('unavailable').change();
			$(".sat-hide").css('display', 'none');
			$("#sat-1").attr('disabled', true);
		} 
		
		if ($('input.sch-7').is(':checked')){
			$("#sat-1").val(localStorage.getItem('sat_1')).change();
			$("#sat-2").val(localStorage.getItem('sat_2')).change();
			$(".sat-hide").css('display', 'block');
			$("#sat-1").attr('disabled', false);
		}			
	})
		
  $(document).ready(function () {
    $(document).off('click', '.addTimeBtn').on('click', '.addTimeBtn', function(){
      var myDay = $(this).attr('data-day');
      var myID  = parseFloat($(".dynamicAddRemove"+myDay+" .form-check").length + 1);
      //alert(myID);
      //return false;
      $(".dynamicAddRemove"+myDay).append('<div class="'+myDay+'-hide"><div class="form-check mb-2 row d-flex '+myDay+'-'+myID+'"><div class="col-md-2"></div><div class="col-md-4"><select name="'+myDay+'check[0][time]['+myID+'][1]" class="form-control"><option value="unavailable">Unavailable</option>{!! $myTime !!}</select></div><div class="col-md-1"> - </div><div class="col-md-4"><select name="'+myDay+'check[0][time]['+myID+'][2]" class="form-control">{!! $myTime !!}</select></div><div class="col-md-1"><button type="button" name="add" data-day="'+myDay+'" data-id="'+myID+'" class="btn removeTimeBtn">-</button></div></div></div>');
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
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
    });
    $(document).off('click', '.closeModal').on('click', '.closeModal', function(){
      $('#myModal, #myModalSmall').modal('hide');
    });
    $(document).off('click', '.removeTimeBtn').on('click', '.removeTimeBtn', function(){
      var myID  = $(this).attr('data-id');
      var myDay = $(this).attr('data-day');
      $('.'+myDay+'-'+myID).remove();
      //if (typeof myID !== 'undefined' && myID !== false){
      //}
    });
    
    $(document).off('click', '.dltEvent').on('click', '.dltEvent', function(){
      $('#myModal').modal('hide');
      $('#myModalSmall').modal('show');
      var myEventID = $(this).attr('data-id');
      $('.btnDelEvent').attr('data-id', myEventID);
    });

    $(document).off('click', '.btnDelEvent').on('click', '.btnDelEvent', function(){
      var myEventID = $(this).attr('data-id');
      $.ajax({
          url: "{{url('/')}}/eventdelete",
          type:'POST',
          data: {_token:"{{ csrf_token() }}", myEventID:myEventID},
          success: function(data) {
            $('#myModalSmall .modal-content').html(data);
          }
      });
    });
    $('#msgSuccess').delay(3000).fadeOut('slow');
  });


  document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var calendarEl = document.getElementById('calendarteacher');
    var SITEURL = "{{url('/')}}";
    var calendar = new FullCalendar.Calendar(calendarEl, {
      themeSystem       : 'standard',
      height            : '85vh',
      allDaySlot        : false,
      expandRows        : true,
      slotMinTime       : '09:00',
      slotMaxTime       : '21:00',
      slotDuration      : '01:00',
      headerToolbar     : {
        left    : 'prev,next today',
        center  : 'title',
        right   : 'timeGridWeek,timeGridDay'
      },
      initialView       : 'timeGridWeek',
      navLinks          : true, // can click day/week names to navigate views
      editable          : false,
      selectable        : false,
      nowIndicator      : true,
      dayMaxEvents      : true, // allow "more" link when too many events
      events: {
        url: SITEURL + "/get-data-teachers",
        failure: function() {
          //document.getElementById('script-warning').style.display = 'none'
        }
      },
      eventDidMount: function(info) {
        //console.log(info);
        info.el.innerHTML = '<div class="eventInfo">'+info.timeText+'<br />'+info.event._def.title+' / '+info.event._def.extendedProps.description+'</div>';
      },
      loading: function(bool) {
        document.getElementById('loading').style.display =bool ? 'block' : 'none';
      },
      eventClick: function(arg) {
        $('#myModal').modal('show');
        var myEventID = arg.event.id;
        $('.editEvent, .dltEvent').attr('data-id', myEventID);
        $('.modal-backdrop').hide();
        //console.log(arg);
        //console.log(arg.event.id);
        //if (confirm('Are you sure you want to delete this event?')) {
        //  arg.event.remove()
        //}
      },
    });
    calendar.render();
  });
</script>
@endsection