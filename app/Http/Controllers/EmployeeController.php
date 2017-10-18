<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

use DB;
use Validator;

class EmployeeController extends Controller
{

    private $name = 'employees';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'employees' => Employee::all()
        ];

        return view($this->name.'.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->name.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required',
            'alias.*' => 'required',
            'address.*' => 'required',
        ];

        $messages = [
            'name.required' => 'Nombre requerido',
            'email.required' => 'Email requerido.',
            'email.email' => 'Email no valido.',
            'birthday.required' => 'Fecha de nacimiento requerido.',
            'alias.required' => 'Alias requerido.',
            'address.required' => 'Dirección requerida.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->route($this->name.'.create')
                ->withErrors($validator)
                ->withInput();
        }

        $addresses = [];

        foreach ($request->input('alias') as $i => $value) {
            $addresses[$i]['alias'] = $value;
        }

        foreach ($request->input('address') as $i => $value) {
            $addresses[$i]['address'] = $value;
        }

        DB::beginTransaction();

        try {

            $employee = new Employee();
            $employee->name = $request->input('name');
            $employee->email = $request->input('email');
            $employee->birthday = $request->input('birthday');
            $employee->save();
            $employee->addresses()->createMany($addresses);

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()
                ->route("{$this->name}.create")
                ->withErrors([$e->getTraceAsString()])
                ->withInput();

        }

        DB::commit();

        return redirect()
            ->route("{$this->name}.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = [
            'employee' => Employee::find($id)
        ];

        return view($this->name.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'employee' => Employee::find($id)
        ];

        return view($this->name.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required',
        ];

        $messages = [
            'name.required' => 'Nombre requerido',
            'email.required' => 'Email requerido.',
            'email.email' => 'Email no valido.',
            'birthday.required' => 'Fecha de nacimiento requerido.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->route($this->name.'.create')
                ->withErrors($validator)
                ->withInput();
        }

        $addresses = [];

        foreach ($request->input('alias') as $i => $value) {
            $addresses[$i]['alias'] = $value;
        }

        foreach ($request->input('address') as $i => $value) {
            $addresses[$i]['address'] = $value;
        }

        DB::beginTransaction();

        try {

            $employee = Employee::find($id);
            $employee->name = $request->input('name');
            $employee->email = $request->input('email');
            $employee->birthday = $request->input('birthday');
            $employee->save();
            //$employee->addresses()->createMany($addresses);

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()
                ->route("{$this->name}.create")
                ->withErrors([$e->getTraceAsString()])
                ->withInput();

        }

        DB::commit();

        return redirect()
            ->route("{$this->name}.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::destroy($id);
        return redirect()
            ->route("{$this->name}.index");
    }
}
