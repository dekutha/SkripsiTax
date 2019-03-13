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
                                <h3 class="mb-0">{{ __('Detail pph') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('employeetax.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Nama</h4>
                        <p class="card-text">{{ $model->employee->name }}</p>
                        <h4>NIK</h4>
                        <p class="card-text">{{ $model->employee->nik }}</p>
                        <h4>NPWP</h4>
                        <p class="card-text">{{ $model->employee->npwp }}</p>
                        <h4>Status</h4>
                        <p class="card-text">{{ $model->employee->getStatus() }}</p>
                        <h4>Tanggungan</h4>
                        <p class="card-text">{{ $model->employee->tanggungan }}</p>
                        <h4>Penghasilan Bruto</h4>
                        <p class="card-text">Rp. {{ number_format($model->sallary) }}</p>
                        <h4>Jumlah Penghasilan</h4>
                        <p class="card-text">Rp. {{ number_format($model->sallary) }}</p>
                        <h4>PKP Komulatif</h4>
                        <p class="card-text">Rp. {{ number_format($model->fixed_pkp) }}</p>
                        <h4>Pph21</h4>
                        <p class="card-text">Rp. {{ number_format($model->anual_pph21) }}</p>
                        

                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection