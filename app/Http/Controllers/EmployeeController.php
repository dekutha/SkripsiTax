<?php

namespace App\Http\Controllers;

use App\Model\Employee;
use App\Model\EmployeeJob;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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

        $work_start = Carbon::createFromFormat('d/m/Y', $request->work_start)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');

        $ts1 = strtotime($work_start);
        $ts2 = strtotime($now);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        // $work_duration = date('m', strtotime($now)) - date('m', strtotime($work_start));

        if($diff >= 12){
            $diff = 12;
        } else {
            $diff = $diff;
        }

        $model->name            = $request->name;
        $model->status          = $request->status;
        $model->emp_job         = $request->job;
        $model->gender          = $request->gender;
        $model->nik             = $request->nik;
        $model->npwp            = $request->npwp;
        $model->marital_status  = $request->get('marital_status', 0);
        $model->work_start      = $work_start;
        $model->work_duration   = $diff;
        $model->tanggungan      = $request->get('tanggungan', 0);

        $reg = new User();

        $reg->name      = $request->name;
        $reg->email     = $request->email;
        $reg->password  = Hash::make('password');
        $reg->level     = 3;

        $reg->save();

        $model->usr_id  = $reg->id;

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
        // dd($request->all());
        $work_start = Carbon::createFromFormat('d/m/Y', $request->work_start)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');

        $ts1 = strtotime($work_start);
        $ts2 = strtotime($now);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        // $work_duration = date('m', strtotime($now)) - date('m', strtotime($work_start));

        if($diff >= 12){
            $diff = 12;
        } else {
            $diff = $diff;
        }

        $model->name            = $request->name;
        $model->status          = $request->status;
        $model->emp_job         = $request->job;
        $model->gender          = $request->gender;
        $model->nik             = $request->nik;
        $model->npwp            = $request->npwp;
        $model->marital_status  = $request->get('marital_status', 0);
        $model->work_start      = $work_start;
        $model->work_duration   = $diff;
        $model->tanggungan      = $request->get('tanggungan', 0);

        $model->save();

        return redirect()->route('expert.index')->withStatus(__('Employee successfully added.'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEtemporary(Request $request)
    {
        $model = new Employee();
        // dd($request->all());
        $work_start = Carbon::createFromFormat('d/m/Y', $request->work_start)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');

        $ts1 = strtotime($work_start);
        $ts2 = strtotime($now);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        // $work_duration = date('m', strtotime($now)) - date('m', strtotime($work_start));

        if($diff >= 12){
            $diff = 12;
        } else {
            $diff = $diff;
        }
        
        $model->name            = $request->name;
        $model->status          = $request->status;
        $model->gender          = $request->gender;
        $model->nik             = $request->nik;
        $model->npwp            = $request->npwp;
        $model->marital_status  = $request->get('marital_status', 0);
        $model->work_start      = $work_start;
        $model->work_duration   = $diff;
        $model->tanggungan      = $request->get('tanggungan', 0);

        $model->save();

        return redirect()->route('employeetemporary.index')->withStatus(__('Employee successfully added.'));
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
    public function destroy(Request $request, $id)
    {
        $model = Employee::FindOrFail($id);

        $model->delete();

        return redirect()->back()->withStatus(__('Record successfully deleted.'));
    }
}
