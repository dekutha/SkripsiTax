<?php

namespace App\Http\Controllers;

use App\Model\Employee;
use App\Model\EmployeeJob;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    // protected $viewPath = 'employee.';
    /**
     * Display a listing of the Pegawai Tetap.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $model )
    {
        $employees = Employee::orderBy('created_at', 'desc')
                    ->where('status', Employee::TYPE_P_TETAP)->paginate(25);

        return $this->view('employee.index', compact('employees'));
        // return view('index', ['employees' => $model->paginate(15)]);
    }

    /**
     * Display a listing of the Tenaga Ahli.
     *
     * @return \Illuminate\Http\Response
     */
    public function expertShow(Employee $model )
    {
        $employees = Employee::orderBy('created_at', 'desc')
                    ->where('status', Employee::TYPE_P_AHLI)->paginate(25);

        return $this->view('expert.index', compact('employees'));
        // return view('index', ['employees' => $model->paginate(15)]);
    }

    /**
     * Display a listing of the Tenaga Ahli.
     *
     * @return \Illuminate\Http\Response
     */
    public function etemporaryShow(Employee $model )
    {
        $employees = Employee::orderBy('created_at', 'desc')
                    ->where('status', Employee::TYPE_P_SEMENTARA)->paginate(25);

        return $this->view('temporaryEmployee.index', compact('employees'));
        // return view('index', ['employees' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model      = new Employee();
        $status     = 0;

        return $this->view('employee.form', compact('model', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createExpert()
    {
        $model      = new Employee();
        $status     = 2;

        return $this->view('expert.form', compact('model', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEtemporary()
    {
        $model      = new Employee();
        $status     = 1;

        return $this->view('temporaryEmployee.form', compact('model', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Employee();

        $model->name            = $request->name;
        $model->status          = $request->status;
        $model->emp_job         = $request->job;
        $model->gender          = $request->gender;
        $model->nik             = $request->nik;
        $model->npwp            = $request->npwp;
        $model->marital_status  = $request->get('marital_status', 0);
        $model->work_start      = Carbon::createFromFormat('d/m/Y', $request->work_start)->format('Y-m-d');
        $model->tanggungan      = $request->get('tanggungan', 0);

        $model->save();

        return redirect()->route('employee.index')->withStatus(__('Employee successfully added.'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeExpert(Request $request)
    {
        $model = new Employee();
        dd($request->all());
        $model->name            = $request->name;
        $model->status          = $request->status;
        $model->emp_job         = $request->job;
        $model->gender          = $request->gender;
        $model->nik             = $request->nik;
        $model->npwp            = $request->npwp;
        $model->marital_status  = $request->get('marital_status', 0);
        $model->work_start      = Carbon::createFromFormat('d/m/Y', $request->work_start)->format('Y-m-d');
        $model->tanggungan      = $request->get('tanggungan', 0);

        $model->save();

        return redirect()->route('employee.index')->withStatus(__('Employee successfully added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
