<?php

namespace App\Http\Controllers;

use App\Model\EtemporaryTax;
use App\Model\Employee;
use Illuminate\Http\Request;

class EtemporaryTaxController extends Controller
{
    protected $viewPath = 'etemporarytax.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = EtemporaryTax::orderBy('created_at', 'desc')->paginate(25);

        return $this->view('index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model      = new EtemporaryTax();
        $employee   = Employee::where('status', Employee::TYPE_P_SEMENTARA)
                    ->orderBy('name')->pluck('name','id'); 

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
        
        $model = new EtemporaryTax();
        $employee = Employee::FindOrFail($request->employee_id);

        $sallary = $request->sallary;
        if($request->day_n > 1){
            $recBefore = EtemporaryTax::where('day_n', $request->day_n - 1); 
            $sallaryBefore = $recBefore->sallary;
            $akpphBefore = $recBefore->ak_pph21;   
        } else{
            $sallaryBefore = 0;
            $akpphBefore = 0;
        }
        
        $ptkp = 54000000;
        $pph21_a = 0;
        $pph21_b = 0;
        $akum_n = $sallary + $sallaryBefore;
        $batas_day = 450000;
        $pkp_y = $sallary - $batas_day;
        $pkp_x = $pkp_y < 0 ? 0 : $pkp_y;
        $objek_pajak = $pkp_y < 0 ? 0 : $ptkp < $akum_n ? $akum_n - $ptkp : $sallary - $batas_day;
        $day_n = $request->day_n;
        $ptkp_harian = $objek_pajak <=0 ? 0 : ($ptkp / 360) * $day_n;
        $pkp = $objek_pajak <= 0 ? 0 : $akum_n - $ptkp_harian;
        $roundpkp = floor($pkp);
        if($roundpkp <= 50000000){
            $pph21_a = $roundpkp * 0.05;
        } elseif ($roundpkp > 50000000 && $roundpkp < 250000000) {
            $pph21_a = 2500000 + ($roundpkp - 50000000) * 0.15;
        } elseif ($roundpkp > 250000000 && $roundpkp < 500000000) {
            $pph21_a = 32500000 + ($roundpkp - 250000000) * 0.25;
        } else {
            $pph21_a = 95000000 + ($roundpkp - 500000000) * 0.3;
        }

        if($pkp_y <= 50000000){
            $pph21_b = $pkp_y * 0.05;
        } elseif ($pkp_y > 50000000 && $pkp_y < 250000000) {
            $pph21_b = 2500000 + ($pkp_y - 50000000) * 0.15;
        } elseif ($pkp_y > 250000000 && $pkp_y < 500000000) {
            $pph21_b = 32500000 + ($pkp_y - 250000000) * 0.25;
        } else {
            $pph21_b = 95000000 + ($pkp_y - 500000000) * 0.3;
        }
        $pph21_c = $pkp_y > 0 && $akum_n < 4500000 ? $pph21_b : $pph21_a;
        $ak_pph21 = $akum_n < 4500000 ? $akpphBefore + $pph21_c : 0;
        $pph21 = $akum_n < 4500000 ? $pph21_c : $pph21_c - $akpphBefore;
        $gaji_net = $sallary - $pph21;
        

        $model->employee_id     = $request->employee_id;
        $model->user_id         = \Auth::user()->id;
        $model->sallary         = $request->sallary;
        $model->akum_n          = $akum_n;
        $model->akumulasi_gaji  = $akum_n;
        $model->batas_harian    = $batas_day;
        $model->pkp_y           = $pkp_y;
        $model->pkp_x           = $pkp_x;
        $model->objek_pajak     = $objek_pajak;
        $model->log_n           = 1;
        $model->day_n           = $day_n;
        $model->ptkp_harian     = $ptkp_harian;
        $model->pkp             = $pkp;
        $model->fixed_pkp       = $roundpkp;
        $model->pph21_a         = $pph21_a;
        $model->pph21_b         = $pph21_b;
        $model->pph21_c         = $pph21_c;
        $model->ak_pph21        = $ak_pph21;
        $model->pph21           = $pph21;
        $model->gaji_net        = $gaji_net;

        $model->save();

        return redirect()->route('etemporarytax.index')->withStatus(__('Employee successfully added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = EtemporaryTax::FindOrFail($id);

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
        $model      = EtemporaryTax::FindOrFail($id);
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
        $model      = EtemporaryTax::FindOrFail($id);
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
        $model = EtemporaryTax::FindOrFail($id);
        $model->delete();

        return redirect()->back()->withStatus(__('Record successfully deleted.'));
    }
}
