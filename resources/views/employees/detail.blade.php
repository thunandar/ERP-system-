@extends('layouts.app')
@section('title')
Employee's Detail
@endsection
@section('main')
<div class="row">
    <div class="row mx-auto">
        <div class="d-flex justify-content-center" id="header">
            <h2>{{ trans('messages.employee_info') }}</h2>
        </div>
    </div>
    <div class="col-sm-8 offset-sm-3">
        <!-- Employee Details  -->
        <form>
            <div class="form-group row mt-4 mb-2">
                <label for="" class="col-sm-3">{{ trans('messages.employee') }}</label>
                <div class="col-sm-5">
                    @if ($employeeUpload && file_exists(public_path('images/' . $employeeUpload->file_name)))
                    <img src="{{ asset('images/' . $employeeUpload->file_name) }}" width="100px" height="100px" style="border-radius: 100%; object-fit: cover; margin-bottom: 5px;" alt="Previous Image">
                    @else
                    <img src="{{ asset('images/default_employee.jpg') }}" width="100px" height="100px" style="border-radius: 100%; object-fit: cover; margin-bottom: 5px;" alt="Employee Default Image">
                    @endif
                </div>
            </div>
            <div class="form-group row mt-2 mb-2">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.employee_id:') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="employee_id" value={{ $employee->employee_id }} disabled />
                </div>
            </div>
            <div class="form-group row mt-2 mb-2">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.employee_code:') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="employee_code" value={{ $employee->employee_code }} disabled />
                </div>
            </div>
            <div class="form-group row mt-2 mb-2">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.employee_name:') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="employee_name" value="{{ $employee->employee_name }}" disabled />
                </div>
            </div>
            <div class="form-group row mt-2 mb-2">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.nrc_number:') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="nrc_number" value={{ $employee->nrc_number }} disabled />
                </div>
            </div>
            <div class="form-group row mt-2 mb-2">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.email_address:') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="email_address" value={{ $employee->email_address }} disabled />
                </div>
            </div>
            <div class="form-group mt-2 mb-2 row">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.gender:') }} &nbsp; &nbsp;</label>
                <div class="col-sm-5">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="1" name="gender" {{ $employee->gender == '1' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="">{{ trans('messages.male') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="2" name="gender" {{ $employee->gender == '2' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="">{{ trans('messages.female') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mt-2 mb-2">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.date_of_birth:') }}</label>
                <div class="col-sm-5">
                    <input type="date" class="form-control" name="date_of_birth" value={{ $employee->date_of_birth }} disabled />
                </div>
            </div>
            <div class="form-group mt-2 mb-2 row">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.marital_status:') }}</label>
                <div class="col-sm-5">
                    <select id="mySelect" class="form-select" name="marital_status" aria-label="Default select example" disabled>
                        <option value="">---Select---</option>
                        <option value="1" {{ $employee->marital_status == '1' ? 'selected' : '' }}>{{ trans('messages.single') }}</option>
                        <option value="2" {{ $employee->marital_status == '2' ? 'selected' : '' }}>{{ trans('messages.married') }}</option>
                        <option value="3" {{ $employee->marital_status == '3' ? 'selected' : '' }}>{{ trans('messages.married') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mt-2 mb-2">
                <label for="" class="col-sm-3 col-form-label">{{ trans('messages.address:') }}</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="address" rows="3" disabled>{{ $employee->address }}</textarea>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection