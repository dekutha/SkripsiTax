@extends('layouts.app', ['title' => __('Perhitungan Pajak PPH')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Perhitungan Pajak Pegawai Sementara') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('etemporarytax.create') }}" class="btn btn-sm btn-primary">{{ __('Tambah Perhitungan') }}</a>
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
                                    <th scope="col">{{ __('Hari ke') }}</th>
                                    <th scope="col">{{ __('Gaji harian') }}</th>
                                    <th scope="col">{{ __('pph21') }}</th>
                                    <th scope="col">{{ __('Gaji Diterima') }}</th>
                                    <th scope="col">{{ __('Added by') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!isset($models))
                                <tr>
                                    <td>No records found</td>
                                </tr>
                                @else
                                @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->employee->name }}</td>
                                        <td>{{ $model->day_n }}</td>
                                        <td>Rp. {{ number_format($model->sallary) }}</td>
                                        <td>Rp. {{ number_format($model->pph21) }}</td>
                                        <td>Rp. {{ number_format($model->gaji_net) }}</td>
                                        <td>{{ $model->user->name }}</td>
                                        <td>
                                            <a href="{{ route('etemporarytax.show', $model->id) }}" class="btn btn-sm btn-outline-success">detail</a>
                                            @if(Auth::user()->level == 1)
                                                <form action="{{ route('etemporarytax.destroy', $model->id) }}" method="post" class="d-inline">
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
                            {{ $models->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection