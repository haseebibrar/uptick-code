@extends('layouts.auth')

@section('content')
    <div class="col-md-11">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">HR Users</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="msgSuccess">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <a class="btn btnGreen" href="/admin/users/add">Add New</a>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @php
                                $myImage = '';
                                if(!empty($user->image))
                                    $myImage = asset('images/users/'.$user->image);
                            @endphp
                            <tr>
                                <td class="font-weight-bold"></td>
                                <td>{!! ($myImage === "" ? '' : '<img class="rounded-circle  imgmr-1" style="height:50px;" src="'.$myImage.'" alt="'.$user->name.'" title="'.$user->name.'" />') !!} {{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->companyname}}</td>
                                <td class="text-nowrap">
                                    <a href="/admin/users/edit/{{$user->id}}" class="btn btn-info mr-4"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0)" data-id="{{$user->id}}" class="btn btnDel btn-danger"><i class="fa fa-trash"></i> Delete</a>
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
                    window.location = "/admin/users/delete/"+myID;
                }
                else{
                    return false;
                }
            });
            $('#msgSuccess').delay(3000).fadeOut('slow');
        });
    </script>
@endsection