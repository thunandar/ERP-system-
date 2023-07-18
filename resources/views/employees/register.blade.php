@extends('layouts.app')
@section('title')
Normal Registration
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
    <div class="row mx-auto">
        <div class="d-flex justify-content-center" id="header">
            <h2>{{ trans('messages.normal_registration') }}</h2>
        </div>
    </div>
    <div class="col-sm-8 offset-sm-3">
        <!-- Registration Options: Radio Buttons -->
        <div class=" form-group mt-2 mb-2 row">
            <div class="col-sm-12 p-0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" value="1" name="register" id="normalRadio" onchange="handleUISelection()" checked>
                    <label class="form-check-label" for="normalRadio">{{ trans('messages.normal_register') }} &nbsp; &nbsp; &nbsp; &nbsp;</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" value="2" name="register" id="excelRadio" onchange="handleUISelection()">
                    <label class="form-check-label" for="excelRadio">{{ trans('messages.excel_upload_register') }}</label>
                </div>
            </div>
        </div>
        <!-- Normal Registration Form  -->
        <div id="normalUI">
            <form method="post" action="/save-employees" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.employee_id:') }}</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="employee_id" value="{{ old('employee_id', $newId) }}" readonly />
                        @error('employee_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.employee_code:') }}<span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="employee_code" value="{{old('employee_code')}}" />
                        @error('employee_code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.employee_name:') }}<span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="employee_name" value="{{old('employee_name')}}" />
                        @error('employee_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.nrc_number:') }}<span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nrc_number" value="{{old('nrc_number')}}" />
                        @error('nrc_number')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.password:') }}<span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="password" id="password" />
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-primary col-md-12" onclick="generatePassword()">{{ trans('messages.generate_password') }}</button>
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.email_address:') }}<span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="email_address" value="{{old('email_address')}}" />
                        @error('email_address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-2 mb-2 row">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.gender:') }}&nbsp; &nbsp;</label>
                    <div class="col-sm-5">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="1" name="gender" id="male" {{ old('gender') == "1" ? 'checked' : '' }}>
                            <label class="form-check-label" for="male">{{ trans('messages.male') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="2" name="gender" id="female" {{ old('gender') == "2" ? 'checked' : '' }}>
                            <label class="form-check-label" for="female">{{ trans('messages.female') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.date_of_birth:') }} <span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="date_of_birth" value="{{old('date_of_birth')}}" />
                        @error('date_of_birth')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-2 mb-2 row">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.marital_status:') }}</label>
                    <div class="col-sm-5">
                        <select id="mySelect" class="form-select" name="marital_status" aria-label="Default select example">
                            <option selected value="">---{{ trans('messages.select') }}--</option>
                            <option value="1" {{ old('marital_status') == "1" ? "selected" :''}}>{{ trans('messages.single') }}</option>
                            <option value="2" {{ old('marital_status') == "2" ? "selected" :''}}>{{ trans('messages.married') }}</option>
                            <option value="3" {{ old('marital_status') == "3" ? "selected" :''}}>{{ trans('messages.divorce') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.address:') }}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mt-2 mb-2">
                    <label for="" class="col-sm-3 col-form-label">{{ trans('messages.image:') }}</label>
                    <div class="col-sm-5">
                        <input type="file" class="form-control mb-3" name="photo" id="photoInput" onchange="handleFileChange(e)" />
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="#" id="imagePreview" width="70px" height="70px" style="object-fit: cover; display: none;" alt="Employee Image">
                            </div>
                            <div class="col-sm-6 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-danger" id="removeImage" style="display: none;">{{ trans('messages.remove') }}</button>
                            </div>
                        </div>
                        @error('photo')
                        <span id="photoError" class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mt-3 col-md-2">{{ trans('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection