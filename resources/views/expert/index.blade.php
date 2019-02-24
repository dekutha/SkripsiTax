@extends('layouts.app', ['title' => __('Employee Management')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Tenaga Ahli') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('expert.create') }}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Job') }}</th>
                                    <th scope="col">{{ __('NIK') }}</th>
                                    <th scope="col">{{ __('Start Work') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!isset($employees))
                                <tr>
                                    <td>No records found</td>
                                </tr>
                                @else
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->getJob() }}</td>
                                        <td>{{ $employee->nik }}</td>
                                        <td>{{ $employee->work_start }}</td>
                                        <td>
                                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @if(Auth::user()->level == 1)
                                                <form action="{{ route('user.destroy', $employee) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>    
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $employees->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection