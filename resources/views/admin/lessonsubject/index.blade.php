@extends('layouts.auth')

@section('content')
    <div class="col-md-11">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Lesson Subject</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="msgSuccess">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <a class="btn btnGreen" href="/admin/lessonsubject/add">Add New</a>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Focus Area</th>
                            <th scope="col">Name</th>
                            <th scope="col">Homework</th>
                            <th scope="col">PDF</th>
                            <th scope="col">Kajabi link</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lessonsubjects as $lessonsubject)
                            @php
                                $editBtn    = '';
                                $pdfFile    = 'No File Uploaded';
                                $pdfFileSec = '';
                                $homeWorkLink= '';
                                if(isset($lessonsubject->homeworks))
                                    $editBtn = '<a href="/admin/homework/edit/'.$lessonsubject->homeworks->id.'" class="btn btn-info mr-3"><i class="fa fa-edit"></i> Edit Homework</a>';
                                
                                if(!empty($lessonsubject->pdf_data))
                                    $pdfFile = '<a href="'.asset('images/users/'.$lessonsubject->pdf_data).'" target="_blank">View File One</a>';
                                if(!empty($lessonsubject->pdf_data_sec))
                                    $pdfFileSec = '<br /><a href="'.asset('images/users/'.$lessonsubject->pdf_data_sec).'" target="_blank">View File Two</a>';
                                
                                if(!empty($lessonsubject->kajabi_url))
                                    $homeWorkLink = '<a href="'.$lessonsubject->kajabi_url.'" target="_blank">Home Work Link</a>';
                            @endphp
                        <tr>
                                <td class="font-weight-bold align-middle"></td>
                                <td class="align-middle">{{$lessonsubject->focusarea->name}}</td>
                                <td class="align-middle">{{$lessonsubject->name}}</td>
                                <td class="text-nowrap">
                                    @if(empty($editBtn))
                                        <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('add-lesson').submit();">Add Homework</a>
                                        <form id="add-lesson" action="{{ route('admin.addhomeworks') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$lessonsubject->focusarea->id}}" name="focus_id">
                                            <input type="hidden" value="{{$lessonsubject->id}}" name="lesson_id">
                                        </form>
                                    @endif
                                    {!! $editBtn !!}
                                </td>
                                <td class="text-nowrap">
                                    {!! $pdfFile.$pdfFileSec !!}
                                </td>
                                <td class="text-nowrap">{!! $homeWorkLink !!}</td>
                                <td class="text-nowrap">
                                    <a href="/admin/lessonsubject/edit/{{$lessonsubject->id}}" class="btn btn-info mr-3"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0)" data-id="{{$lessonsubject->id}}" class="btn btnDel btn-danger"><i class="fa fa-trash"></i> Delete</a>
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
                    window.location = "/admin/lessonsubject/delete/"+myID;
                }
                else{
                    return false;
                }
            });
            $('#msgSuccess').delay(3000).fadeOut('slow');
        });
    </script>
@endsection