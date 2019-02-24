@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('partials.header', ['title' => $model->exists ? __('Edit User') : __('Add User') ])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{$model->exists ? __('Edit Employee') : __('Add Employee')}}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('employee.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="{{$model->exists ? 'put' : 'post'}}" action="{{ $model->exists ? route('employee.update') : route('employee.store') }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{__('Gender')}}</label>
                                            <select name="employee_type" class="form-control" id="exampleFormControlSelect1">
                                                <option value="0">Laki-Laki</option>
                                                <option value="1">Perempuan</option>
                                            </select>
                                        </div>        
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{__('Jabatan')}}</label>
                                            <select name="job" class="form-control" id="exampleFormControlSelect1">
                                                <option value="0">Staff Admin</option>
                                                <option value="1">Kepala Produksi</option>
                                                <option value="2">Supervisor</option>
                                                <option value="3">Security</option>
                                                <option value="4">Produksi</option>
                                                <option value="5">Gudang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Mulai Bekerja') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                </div>
                                                <input name="work_start" class="form-control datepicker" placeholder="Select date" type="text" value="06/20/2018">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('NIK') }}</label>
                                            <input type="number" name="nik" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('NIK') }}" value="{{ old('nik') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('NPWP') }}</label>
                                            <input type="number" name="npwp" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('NPWP') }}" value="{{ old('npwp') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{__('Status Menikah')}}</label>
                                            {{ Form::select('marital_status', ['0' => 'Belum Menikah', '1' => 'Menikah'], null, ['class' => 'form-control', 'placeholder' => 'Pilih Status', 'id' => 'marital_status']) }}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Jumlah Tanggungan') }}</label>
                                            <input type="number" name="tanggungan" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Tanggungan') }}" value="{{ old('tanggungan') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{ Form::hidden('status', $status) }}

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush