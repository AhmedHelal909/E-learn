<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends BackEndController
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        
        $this->model->create($request->all());

        session()->flash('success', __('site.add_successfuly'));
        return redirect()->back();
    }//end store function

    public function edit($id)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $row = $this->model->find($id);
        if($row!=null){
            return view('dashboard.' . $this->getClassNameFromModel() . '.edit', compact('row', 'module_name_singular', 'module_name_plural'))->with($append);
        }
        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('module_name_singular', 'module_name_plural'))->with($append);
    } //end of edit

    public function update(Request $request, $id)
    {
        
        $setting=$this->model->findOrFail($id);

        
        $setting->update($request->all());

        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->back();
    } //end update function

    public function destroy($id, Request $request)
    {
        $setting = $this->model->findOrFail($id);

        $setting->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    } // end destroy function


}
