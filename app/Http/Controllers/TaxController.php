<?php

namespace App\Http\Controllers;

use App\Model\Tax;
use App\Model\Employee;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    protected $viewPath = 'employeetax.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Tax::orderBy('created_at', 'desc')->paginate(25);

        return $this->view('index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model      = new Tax();
        $employee   = Employee::orderBy('name')->pluck('name','id'); 

        return $this->view('form', compact('model', 'employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $model = new Tax();
        $employee = Employee::FindOrFail($request->employee_id);

        $ptkp = 0;
        $pphanual = 0;
        $sallary_bruto = $request->sallary + $request->insurance + $request->pos_allowance + $request->meal + $request->service_charge;
        $yearlybruto = $sallary_bruto * 12;
        $yearlybrutoho = $yearlybruto + $request->ho_allowance;
        $jab = ($yearlybruto * 0.05) < 6000000 ? $yearlybruto * 0.05 : 0;
        if($employee->marital_status == 0 && $employee->tanggungan == 0){
            $ptkp = 54000000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 0) {
            $ptkp = 58500000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 1) {
            $ptkp = 63000000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 2) {
            $ptkp = 67500000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 3) {
            $ptkp = 72000000;
        }
        $pkp = ($yearlybrutoho - $jab - $ptkp) > 0 ? $yearlybrutoho - $jab - $ptkp : 0;
        $roundpkp = floor($pkp);
        if($roundpkp <= 50000000){
            $pphanual = $roundpkp * 0.05;
        } elseif ($roundpkp > 50000000 && $roundpkp < 250000000) {
            $pphanual = 2500000 + ($roundpkp - 50000000) * 0.15;
        } elseif ($roundpkp > 250000000 && $roundpkp < 500000000) {
            $pphanual = 32500000 + ($roundpkp - 250000000) * 0.25;
        } else {
            $pphanual = 95000000 + ($roundpkp - 500000000) * 0.3;
        }
        $sanksi = $employee->npwp == 0 ? $pphanual * 0.2 : 0;
        $pphanualplus = $pphanual + $sanksi;
        $monthly_pph21 = round($pphanualplus / 12); 
        

        $model->employee_id                 = $request->employee_id;
        $model->user_id                     = \Auth::user()->id;
        $model->sallary                     = $request->sallary;
        $model->insurance                   = $request->get('insurance', 0);
        $model->pos_allowance               = $request->get('pos_allowance', 0);
        $model->meal                        = $request->get('meal', 0);
        $model->service_charge              = $request->get('service_charge', 0);
        $model->sallary_plus_insurance      = $sallary_bruto;
        $model->y_sallary                   = $yearlybruto;
        $model->ho_allowance                = $request->ho_allowance;
        $model->y_sallary_plus_ho_allowance = $yearlybrutoho;
        $model->pos_cost                    = $jab;
        $model->ptkp                        = $ptkp;
        $model->pkp                         = $pkp;
        $model->fixed_pkp                   = $roundpkp;
        $model->anual_pph21                 = $pphanual;
        $model->anual_pph21_plus_sanksi     = $pphanualplus;
        $model->monthly_pph21               = $monthly_pph21;

        $model->save();

        return redirect()->route('employeetax.index')->withStatus(__('Employee successfully added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Tax::FindOrFail($id);

        return $this->view('detail', compact('model'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model      = Tax::FindOrFail($id);
        $employee = Employee::get()->mapWithKeys(function($item){
            return [$item['id'] => $item['name']];
        });

        return $this->view('form', compact('model', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model      = Tax::FindOrFail($id);
        $employee = Employee::FindOrFail($request->employee_id);

        $ptkp = 0;
        $pphanual = 0;
        $sallary_bruto = $request->sallary + $request->insurance + $request->pos_allowance + $request->meal + $request->service_charge;
        $yearlybruto = $sallary_bruto * 12;
        $yearlybrutoho = $yearlybruto + $request->ho_allowance;
        $jab = ($yearlybruto * 0.05) < 6000000 ? $yearlybruto * 0.05 : 0;
        if($employee->marital_status == 0 && $employee->tanggungan == 0){
            $ptkp = 54000000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 0) {
            $ptkp = 58500000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 1) {
            $ptkp = 63000000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 2) {
            $ptkp = 67500000;
        } elseif ($employee->marital_status == 1 && $employee->tanggungan == 3) {
            $ptkp = 72000000;
        }
        $pkp = ($yearlybrutoho - $jab - $ptkp) > 0 ? $yearlybrutoho - $jab - $ptkp : 0;
        $roundpkp = floor($pkp);
        if($roundpkp <= 50000000){
            $pphanual = $roundpkp * 0.05;
        } elseif ($roundpkp > 50000000 && $roundpkp < 250000000) {
            $pphanual = 2500000 + ($roundpkp - 50000000) * 0.15;
        } elseif ($roundpkp > 250000000 && $roundpkp < 500000000) {
            $pphanual = 32500000 + ($roundpkp - 250000000) * 0.25;
        } else {
            $pphanual = 95000000 + ($roundpkp - 500000000) * 0.3;
        }
        $sanksi = $employee->npwp == 0 ? $pphanual * 0.2 : 0;
        $pphanualplus = $pphanual + $sanksi;
        $monthly_pph21 = round($pphanualplus / 12); 
        

        $model->employee_id                 = $request->employee_id;
        $model->user_id                     = \Auth::user()->id;
        $model->sallary                     = $request->sallary;
        $model->insurance                   = $request->get('insurance', 0);
        $model->pos_allowance               = $request->get('pos_allowance', 0);
        $model->meal                        = $request->get('meal', 0);
        $model->service_charge              = $request->get('service_charge', 0);
        $model->sallary_plus_insurance      = $sallary_bruto;
        $model->y_sallary                   = $yearlybruto;
        $model->ho_allowance                = $request->ho_allowance;
        $model->y_sallary_plus_ho_allowance = $yearlybrutoho;
        $model->pos_cost                    = $jab;
        $model->ptkp                        = $ptkp;
        $model->pkp                         = $pkp;
        $model->fixed_pkp                   = $roundpkp;
        $model->anual_pph21                 = $pphanual;
        $model->anual_pph21_plus_sanksi     = $pphanualplus;
        $model->monthly_pph21               = $monthly_pph21;

        $model->save();

        return redirect()->route('employeetax.index')->withStatus(__('Employee successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Tax::FindOrFail($id);
        $model->delete();

        return redirect()->back()->withStatus(__('Record successfully deleted.'));
    }
}
