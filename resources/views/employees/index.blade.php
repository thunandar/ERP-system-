@extends('layouts.app')
@section('title')
Employee List
@endsection
@section('main')
<div class="row">
    <div class="col-sm-12">
        <!--When employee update successfully, show success message  -->
        @if ($successMessage = Session::get("success"))
        <div class="alert hide-message" id="alert-success">
            <div class="row d-flex justify-content-center">
                {{ $successMessage }}
            </div>
        </div>
        @endif
        <!-- Show error message  -->
        @if ($errorMessage = session('error'))
        <div class="alert alert-danger" id="box">
            <span class="close-icon" id="error-icon">&times;</span>
            <div class="row d-flex justify-content-center">
                {{ $errorMessage }}
            </div>
        </div>
        @endif
        <div class="row mx-auto">
            <div class="d-flex justify-content-center" id="header">
                @if ($employeeCount== 0 || $employeeCount == 1)
                <h2>{{ trans('messages.employee_list') }}</h2>
                @elseif ($employeeCount > 1)
                <h2>{{ trans('messages.employee_lists') }}</h2>
                @endif
            </div>
        </div>
        <!-- Search Form -->
        <form action="" method="GET" enctype="multipart/form-data" id="ListForm">
            <!-- Search Box -->
            <div class="search-container mt-3 mb-4">
                <div class="row mx-auto mb-3 col-md-10">
                    <label for="employee_id" class="col-sm-2 col-form-label">{{ trans('messages.employee_id_search') }}</label>
                    <div class="col-sm-3">
                        <input type="text" name="employee_id" class="form-control" value="{{ request('employee_id') }}" id="employee_id">
                    </div>
                    <label for="employee_code" class="col-sm-2 col-form-label">{{ trans('messages.employee_code_search') }}</label>
                    <div class="col-sm-3">
                        <input type="text" name="employee_code" class="form-control" value="{{ request('employee_code') }}" id="employee_code">
                    </div>
                </div>
                <div class="row mx-auto mb-3 col-md-10">
                    <label for="employee_name" class="col-sm-2 col-form-label">{{ trans('messages.employee_name_search') }}</label>
                    <div class="col-sm-3">
                        <input type="text" name="employee_name" class="form-control" value="{{ request('employee_name') }}" id="employee_name">
                    </div>
                    <label for="email_address" class="col-sm-2 col-form-label">{{ trans('messages.email_search') }}</label>
                    <div class="col-sm-3">
                        <input type="text" name="email_address" class="form-control" value="{{ request('email_address') }}" id="email_address">
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="form-group row mb-2" id="form">
                <div class="col-sm-2"></div>
                <div class="col-sm-2">
                    <button id="searchEmployee" class="btn btn-primary mb-4 col-md-12" @if($employeeCount == 0) disabled @endif ><i class="fas fa-search"></i>{{ trans('messages.search') }}</button>
                </div>
                <div class="col-sm-2">
                    <button id="exportExcel" class="btn btn-primary mb-4 col-md-12 {{ $employees->count() === 0 ? ' disabled' : '' }}" {{ $employees->count() === 0 ? ' disabled' : '' }}><i class="fas fa-file-download"></i>{{ trans('messages.excel_download') }}</button>
                </div>
                <div class="col-sm-2">
                    <button id="generatePDF" class="btn btn-primary mb-4 col-md-12 {{ $employees->count() === 0 ? ' disabled' : '' }}" {{ $employees->count() === 0 ? ' disabled' : '' }}><i class="fas fa-file-download"></i>{{ trans('messages.pdf_download') }}</button>
                </div>
                <div class="col-sm-2">
                    <a href="/show-employees" class="btn btn-primary mb-4 col-md-12 @if($employeeCount== 0) disabled @endif"><i class="fas fa-undo"></i>{{ trans('messages.reset') }}</a>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </form>
        <!-- Show Total Employee Result -->
        @if ($employees->total() == 0 || $employees->total() == 1)
        <p style="margin-bottom: 20px;">{{ trans('messages.total_result') }}: {{ $employees->total() }}</p>
        @elseif ($employees->total() > 1)
        <p style="margin-bottom: 20px;">{{ trans('messages.total_results') }}: {{ $employees->total() }}</p>
        @endif
        <!-- Show Employee Lists Table  -->
        <table class="table table-bordered text-center" style="vertical-align: middle;">
            <thead style="vertical-align: middle;">
                <tr>
                    <th rowspan="2">
                        {{ trans('messages.no') }}
                    </th>
                    <th rowspan="2">{{ trans('messages.employee_id') }}</th>
                    <th rowspan="2">{{ trans('messages.employee_code') }}</th>
                    <th rowspan="2">{{ trans('messages.employee_name') }}</th>
                    <th rowspan="2">{{ trans('messages.email') }}</th>
                    <th colspan="4" class="no-border-bottom">{{ trans('messages.action') }}</th>
                </tr>
                <tr>
                    <th>{{ trans('messages.edit') }}</th>
                    <th>{{ trans('messages.detail') }}</th>
                    <th>{{ trans('messages.active') }}/ <br /> {{ trans('messages.inactive') }}</th>
                    <th>{{ trans('messages.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <!-- Delete Modal Box  -->
                <div class="modal fade" id="deleteModal{{$employee->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header mt-1 mb-1">
                                <h5 class="modal-title">{{ trans('messages.confirmation') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ trans('messages.delete_message') }}
                            </div>
                            <div class="modal-footer mt-1 mb-1">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">{{ trans('messages.cancel') }}</button>
                                <button type="submit" form="deleteForm{{$employee->id}}" class="btn btn-danger px-5">{{ trans('messages.ok') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Active To InActive Modal Box  -->
                <div class="modal fade" id="activeModal{{$employee->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header mt-1 mb-1">
                                <h5 class="modal-title">{{ trans('messages.confirmation') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ trans('messages.active_message') }}
                            </div>
                            <div class="modal-footer mt-1 mb-1">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">{{ trans('messages.cancel') }}</button>
                                <button type="submit" form="activeForm{{$employee->id}}" class="btn btn-primary px-5">{{ trans('messages.ok') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- InActive To Active Modal Box  -->
                <div class="modal fade" id="inactiveModal{{$employee->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header mt-1 mb-1">
                                <h5 class="modal-title">{{ trans('messages.confirmation') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ trans('messages.inactive_message') }}
                            </div>
                            <div class="modal-footer mt-1 mb-1">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">{{ trans('messages.cancel') }}</button>
                                <button type="submit" form="inactiveForm{{$employee->id}}" class="btn btn-primary px-5">{{ trans('messages.ok') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <tr>
                    <td>{{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}</td>
                    <td>{{$employee->employee_id}}</td>
                    <td>{{$employee->employee_code}}</td>
                    <td>{{ substr(strip_tags($employee->employee_name), 0, 20) }}{{ strlen(strip_tags($employee->employee_name)) > 10 ? "..." : "" }}</td>
                    <td>{{$employee->email_address}}</td>
                    <td>
                        @if ($employee->deleted_at !== null)
                        <button class="btn btn-secondary" disabled><i class="fas fa-edit"></i></button>
                        @else
                        <a href="/edit-employees/{{$employee->id}}" class="btn btn-primary" id="editButton"><i class="fas fa-edit"></i></a>
                        @endif
                    </td>
                    <td>
                        <a href="/employee-details/{{$employee->id}}" class="btn btn-primary"><i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                    <td>
                        @if ($employee->deleted_at != null)
                        <form id="inactiveForm{{$employee->id}}" action="/restore-employees/{{$employee->id}}" method="POST" class="mb-0">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-secondary" type="button" id="activeButton" data-bs-toggle="modal" data-bs-target="#inactiveModal{{$employee->id}}">Inactive</button>
                        </form>
                        @endif
                        @if ($employee->deleted_at == null)
                        <form id="activeForm{{$employee->id}}" action="/delete-active-employees/{{$employee->id}}" method="POST" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary" type="button" id="activeButton" data-bs-toggle="modal" data-bs-target="#activeModal{{$employee->id}}">Active</button>
                        </form>
                        @endif
                    </td>
                    <td>
                        @if ($employee->deleted_at == null)
                        <form id="deleteForm{{$employee->id}}" action="/delete-employees/{{$employee->id}}" method="POST" class="mb-0" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="button" id="deleteButton" data-bs-toggle="modal" data-bs-target="#deleteModal{{$employee->id}}"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        @else
                        <a class="btn btn-secondary"><i class="fas fa-trash-alt"></i></a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-5">{{ trans('messages.no_employee') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $employees->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection