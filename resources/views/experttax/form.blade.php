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
                                <h3 class="mb-0">{{$model->exists ? __('Edit Pajak Tenaga Ahli') : __('Tambah Pajak Tenaga Ahli')}}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('experttax.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ Form::model($model, [
                            'method' => $model->exists ? 'put' : 'post',
                            'route' => $model->exists ? ['experttax.update', 'id' => $model->id] : 'experttax.store',
                            'enctype'   => 'multipart/form-data'
                        ]) }}
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label>{{__('Tenaga Ahli')}}</label>
                                    {{ Form::select('employee_id', $employee, null, ['class' => 'form-control', 'placeholder' => 'Choose Employee', 'id' => 'emp']) }}
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Penghasilan Bruto') }}</label>
                                    {{ Form::number('sallary', null, ['class' => 'form-control form-control-alternative', 'required']) }}
                                </div>

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