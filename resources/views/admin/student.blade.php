@extends('layouts.auth')

@section('content')
    <div class="col-md-11">
        <div class="myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Students</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="msgSuccess">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <a class="btn btnGreen" href="/admin/students/add">+ Add New</a>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th data-orderable="false" scope="col" class="txtCenter">Activity</th>
                            <th scope="col">Students</th>
                            <th scope="col">Department</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Company</th>
                            <th scope="col" class="txtCenter">Cancellation</th>
                            <th data-orderable="false" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $myImage = '';
                                if(!empty($student->image))
                                    $myImage = asset('images/users/'.$student->image);
                                
                                $studentEv  = $student->events;
                                $pastEvents = 0;
                                $totalEvent = $student->allocated_hour;
                                $myPercente = 0;
                                $canceled   = 0;
                                $companyName= '';
                                if(!empty($student->company_id))
                                    $companyName= $student->companies['name'];
                                if($studentEv->isNotEmpty()){
                                    foreach($studentEv as $event){
                                        $myTime = strtotime($event->start);
                                        if($myTime < time())
                                            $pastEvents = $pastEvents+1;
                                        if($event->status === "canceled")
                                            $canceled = $canceled+1;
                                    } 
                                    $myPercente = round(($pastEvents / $totalEvent)*100, 2);
                                }
                            @endphp
                            <tr>
                                <td class="align-middle"><div class="circleAct{{ $totalEvent < 1 ? ' circleActRed' : '' }}"></div></td>
                                <td class="align-middle text-nowrap"><div style="display:flex;">{!! ($myImage === "" ? '' : '<img class="rounded-circle imgmr-1" style="width:50px; height:50px;" src="'.$myImage.'" alt="'.$student->name.'" title="'.$student->name.'" />') !!}<div style="margin-top: 0.4rem; text-align: center; line-height: 1.4;">{{$student->name}}<br /><p class="noMargin txtSmall">{{$student->title}}</p></div></div></td>
                                <td class="align-middle">{{ $student->deptname }}</td>
                                <td class="align-middle">
                                    <div class="txtCenter">{{ $pastEvents }}/{{ $totalEvent }}</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $myPercente }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="align-middle txtCenter">{{ $companyName }}</td>
                                <td class="align-middle txtCenter">{{ $canceled }}</td>
                                <td class="text-nowrap">
                                    <a href="/admin/students/edit/{{$student->id}}" class="btn btn-info mr-3"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:void(0)" data-id="{{$student->id}}" class="btn btnDel btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable({
                pageLength: 20,
                lengthMenu: [
                    [20, 50, 100, 500],
                    [20, 50, 100, 500]
                ],
            });
            $(document).off('click', '.btnDel').on('click', '.btnDel', function(){
                if(confirm("Are you sure you want to delete this?")){
                    myID        = $(this).attr('data-id');
                    window.location = "/admin/students/delete/"+myID;
                }
                else{
                    return false;
                }
            });
            $('#msgSuccess').delay(3000).fadeOut('slow');
        });
    </script>
@endsection