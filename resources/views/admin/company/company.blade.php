@extends('layouts.auth')

@section('content')
    <div class="col-md-11">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Companies</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="msgSuccess">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <a class="btn btnGreen" href="/admin/companies/add">Add New</a>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Total Allocated Hours</th>
                            <th scope="col">Used Hours</th>
                            <th scope="col">Remaining Hours</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                                <td class="font-weight-bold"></td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->phone}}</td>
                                <td>{{$company->total_bank_hours}}</td>
                                <td>{{$company->used_hours}}</td>
                                <td>{{$company->remaining_bank_hours}}</td>
                                <td class="text-nowrap">
                                    <a href="/admin/companies/edit/{{$company->id}}" class="btn btn-info mr-3"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0)" data-id="{{$company->id}}" class="btn btnDel btn-danger"><i class="fa fa-trash"></i> Delete</a>
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
                    window.location = "/admin/companies/delete/"+myID;
                }
                else{
                    return false;
                }
            });
            $('#msgSuccess').delay(3000).fadeOut('slow');
        });
    </script>
@endsection