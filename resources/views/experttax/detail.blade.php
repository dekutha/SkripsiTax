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
                        <h4>Jabatan</h4>
                        <p class="card-text">{{ $model->employee->getJob() }}</p>
                        <h4>NIK</h4>
                        <p class="card-text">{{ $model->employee->nik }}</p>
                        <h4>NPWP</h4>
                        <p class="card-text">{{ $model->employee->npwp }}</p>
                        <h4>Status</h4>
                        <p class="card-text">{{ $model->employee->getStatus() }}</p>
                        <h4>Tanggungan</h4>
                        <p class="card-text">{{ $model->employee->tanggungan }}</p>
                        <h4>Gaji Pokok</h4>
                        <p class="card-text">Rp. {{ number_format($model->sallary) }}</p>
                        <h4>BPJS tertanggung</h4>
                        <p class="card-text">Rp. {{ number_format($model->insurance) }}</p>
                        <h4>Tunjangan Jabatan</h4>
                        <p class="card-text">Rp. {{ number_format($model->pos_allowance) }}</p>
                        <h4>Uang Makan</h4>
                        <p class="card-text">Rp. {{ number_format($model->meal) }}</p>
                        <h4>Service Charge</h4>
                        <p class="card-text">Rp. {{ number_format($model->service_charge) }}</p>
                        <h4>Gaji Total</h4>
                        <p class="card-text">Rp. {{ number_format($model->sallary_plus_insurance) }}</p>
                        <h4>Pendapatan Pertahun</h4>
                        <p class="card-text">Rp. {{ number_format($model->y_sallary) }}</p>
                        <h4>THR</h4>
                        <p class="card-text">Rp. {{ number_format($model->ho_allowance) }}</p>
                        <h4>Pendapatan Pertahun + THR</h4>
                        <p class="card-text">Rp. {{ number_format($model->y_sallary_plus_ho_allowance) }}</p>
                        <h4>Biaya Jabatan</h4>
                        <p class="card-text">Rp. {{ number_format($model->pos_cost) }}</p>
                        <h4>PTPK</h4>
                        <p class="card-text">Rp. {{ number_format($model->ptkp) }}</p>
                        <h4>PKP</h4>
                        <p class="card-text">Rp. {{ number_format($model->pkp) }}</p>
                        <h4>PKP Pembulatan</h4>
                        <p class="card-text">Rp. {{ number_format($model->fixed_pkp) }}</p>
                        <h4>Pph21 1 Tahun</h4>
                        <p class="card-text">Rp. {{ number_format($model->anual_pph21) }}</p>
                        <h4>Sanksi NPWP</h4>
                        <p class="card-text">Rp. {{ number_format($model->sanksi) }}</p>
                        <h4>Pph21 1 Tahun + Sanksi</h4>
                        <p class="card-text">Rp. {{ number_format($model->anual_pph21_plus_sanksi) }}</p>
                        <h4>Pph21 1 Bulan</h4>
                        <p class="card-text">Rp. {{ number_format($model->monthly_pph21) }}</p>

                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection