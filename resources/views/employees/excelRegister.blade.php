@extends('layouts.app')
@section('title')
Excel Registration
@endsection
@section('main')
<div class="row">
    <!--When employee save successfully, show success message  -->
    @if ($successMessage = Session::get("success"))
    <div class="alert hide-message" id="alert-success">
        <div class="row d-flex justify-content-center">
            {{ $successMessage }}
        </div>
    </div>
    @endif
    <!-- Error messages for Excel UI -->
    <div id="errorMessages">
        @if (Session::has('importError') || Session::has('rowLimitError') || Session::has('NoFileError') || Session::has('allowedFormatError') || Session::has('NoFieldError'))
        <div class="alert alert-danger" id="box">
            @foreach ($errors->all() as $error)
            <span class="close-icon" id="error-icon">&times;</span>
            <div class="row d-flex justify-content-center">
                {{ $error }}
            </div>
            @endforeach
        </div>
        @endif
    </div>
    <!-- Header -->
    <div class="row mx-auto">
        <div class="d-flex justify-content-center" id="header">
            <h2>{{ trans('messages.excel_registration') }}</h2>
        </div>
    </div>
    <div class="col-sm-8 offset-sm-2">
        <!-- Registration Options: Radio Buttons -->
        <div class=" form-group mt-2 mb-2 row">
            <div class="col-sm-12 p-0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" value="1" name="register" id="normalRadio" onchange="handleUISelection()" checked>
                    <label class="form-check-label" for="normalRadio">{{ trans('messages.normal_register') }} &nbsp; &nbsp; &nbsp; &nbsp;</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" value="2" name="register" id="excelRadio" onchange="handleUISelection()" checked>
                    <label class="form-check-label" for="excelRadio">{{ trans('messages.excel_upload_register') }}</label>
                </div>
            </div>
        </div>
        <!-- Excel Registration Form  -->
        <div id="excelUI">
            <form method="post" action="/import-employees" enctype="multipart/form-data">
                @csrf
                <div id="btn-excel">
                    <a href="/export-employees" class="btn btn-success">{{ trans('messages.excel_download') }}</a>
                </div>
                <div id="card" class="mx-auto mt-5 mb-5">
                    <input type="file" name="excel_upload" id="input" />
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary mt-2 col-md-2">{{ trans('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection