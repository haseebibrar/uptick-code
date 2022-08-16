@extends('layouts.auth')

@section('content')
    <div class="col-md-11">
        <div class="myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Tutors</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="msgSuccess">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <a class="btn btnGreen" href="/admin/teachers/add">Add New</a>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Expertise</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Zoom Link</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            @php
                                $myImage = '';
                                if(!empty($teacher->image))
                                    $myImage = asset('images/users/'.$teacher->image);
                            @endphp
                            <tr>
                                <td class="font-weight-bold"></td>
                                <td>{!! ($myImage === "" ? '' : '<img class="rounded-circle imgmr-1" style="width: 50px; height:50px;" src="'.$myImage.'" alt="'.$teacher->name.'" title="'.$teacher->name.'" />') !!} {{$teacher->name}}</td>
                                <td>{{$teacher->email}}</td>
                                <td>{{$teacher->expertise}}</td>
                                <td>{{$teacher->phone}}</td>
                                <td><a href="{{ $teacher->zoom_link }}" target="_blank">{{$teacher->zoom_link}}</a></td>
                                <td class="text-nowrap">
                                    <a href="/admin/teachers/edit/{{$teacher->id}}" class="btn btn-info mr-3"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0)" data-id="{{$teacher->id}}" class="btn btnDel btn-danger"><i class="fa fa-trash"></i> Delete</a>
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
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
                }
            });
            $(document).off('click', '.btnDel').on('click', '.btnDel', function(){
                if(confirm("Are you sure you want to delete this?")){
                    myID = $(this).attr('data-id');
                    window.location = "/admin/teachers/delete/"+myID;
                }
                else{
                    return false;
                }
            });
            $('#msgSuccess').delay(3000).fadeOut('slow');
        });
    </script>
@endsection