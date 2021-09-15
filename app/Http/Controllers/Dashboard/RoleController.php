<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends BackEndController
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
       //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
              $q->where('name','like','%' .$request->search. '%')
                ->orWhere('description','like','%' .$request->search. '%');

        })->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index
  
    public function store(Request $request)
    {

        $newRole = new Role();

        $newRole->name         =  $request->name;
        $newRole->display_name = ucfirst($request->name);
        $newRole->description  =  $request->description;
        $newRole->save();

        $newRole->attachPermissions($request->permissions);

        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $updateRole = $this->model->findOrFail($id);

        $updateRole->name         =  $request->name;
        $updateRole->display_name = ucfirst($request->name);
        $updateRole->description  =  $request->description;
        $updateRole->save();


        $updateRole->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
}
