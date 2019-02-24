<?php

namespace App\Http\Controllers;

use App\Model\ExpertTax;
use App\Model\Employee;
use Illuminate\Http\Request;

class ExpertTaxController extends Controller
{
    protected $viewPath = 'experttax.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = ExpertTax::orderBy('created_at', 'desc')->paginate(25);

        return $this->view('index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model      = new ExpertTax();
        $employee   = Employee::where('status', Employee::TYPE_P_AHLI)
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
        
        $model = new ExpertTax();
        $employee = Employee::FindOrFail($request->employee_id);

        $pphanual = 0;
        $pkp = $request->sallary * (50 / 100);

        $roundpkp = floor($pkp);
        if($roundpkp <= 50000000){
            $pphanual = $roundpkp * (5 / 100);
        } elseif ($roundpkp > 50000000 && $roundpkp < 250000000) {
            $pphanual = 2500000 + ($roundpkp - 50000000) * (15 / 100);
        } elseif ($roundpkp > 250000000 && $roundpkp < 500000000) {
            $pphanual = 32500000 + ($roundpkp - 250000000) * (25 / 100);
        } else {
            $pphanual = 95000000 + ($roundpkp - 500000000) * (30 / 100);
        } 
        

        $model->employee_id                 = $request->employee_id;
        $model->user_id                     = \Auth::user()->id;
        $model->sallary                     = $request->sallary;
        $model->sallary_plus_insurance      = $request->sallary;
        $model->pkp                         = $pkp;
        $model->fixed_pkp                   = $roundpkp;
        $model->anual_pph21                 = $pphanual;

        $model->save();

        return redirect()->route('experttax.index')->withStatus(__('Data Berhasil Ditambahkan.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = ExpertTax::FindOrFail($id);

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
        $model      = ExpertTax::FindOrFail($id);
        $employee = Employee::where('status', Employee::TYPE_P_AHLI)
                    ->get()->mapWithKeys(function($item){
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
        $model      = ExpertTax::FindOrFail($id);
        $employee   = Employee::FindOrFail($request->employee_id);

        $pphanual = 0;
        $pkp = $request->sallary * (50 / 100);

        $roundpkp = floor($pkp);
        if($roundpkp <= 50000000){
            $pphanual = $roundpkp * (5 / 100);
        } elseif ($roundpkp > 50000000 && $roundpkp < 250000000) {
            $pphanual = 2500000 + ($roundpkp - 50000000) * (15 / 100);
        } elseif ($roundpkp > 250000000 && $roundpkp < 500000000) {
            $pphanual = 32500000 + ($roundpkp - 250000000) * (25 / 100);
        } else {
            $pphanual = 95000000 + ($roundpkp - 500000000) * (30 / 100);
        } 
        

        $model->employee_id                 = $request->employee_id;
        $model->user_id                     = \Auth::user()->id;
        $model->sallary                     = $request->sallary;
        $model->sallary_plus_insurance      = $request->sallary;
        $model->pkp                         = $pkp;
        $model->fixed_pkp                   = $roundpkp;
        $model->anual_pph21                 = $pphanual;

        $model->save();

        return redirect()->route('experttax.index')->withStatus(__('Data Berhasil Diperbaharui.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        $model     = ExpertTax::findOrFail($id);

        $model->delete();

        return redirect()->back()->withStatus(__('Record successfully deleted.'));
    }
}
