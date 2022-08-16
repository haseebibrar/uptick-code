@extends('layouts.auth')

@section('content')
    <div class="col-md-5">
        <div class="topSection myHeight px-4 py-4 bgWhite">
            <h1 class="txtLeft">Edit Company Record</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="mt-4 mb-4" method="POST" action="/admin/companies/update" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $companies->id }}">
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Name</label></div>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" value="{{ $companies->name }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Allocate Hours</label></div>
                    <div class="col-md-6">
                        <input type="number" name="remaining_bank_hours" class="form-control" value="{{ $companies->remaining_bank_hours }}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6"><label for="name">Phone</label></div>
                    <div class="col-md-6">
                        <input type="tel" name="phone" class="form-control" value="{{ $companies->phone }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnGreen">Save</button>
                <a class="btn btn-light" href="/admin/companies/">Cancel</a>
            </form>
        </div>
    </div>
    <div class="col-md-6">
    </div>
@endsection