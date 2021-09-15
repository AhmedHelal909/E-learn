<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Dashboard\BackEndController;


class TeacherController extends BackEndController
{
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }
    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->whereTranslationLike('name','%' .$request->search. '%')
              ->orWhereTranslationLike('description','%' .$request->search. '%');
        })->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'                    => 'required|unique:teachers|max:255',
            'email'                   => 'required|email|unique:teachers',
            'password'                => 'required|min:5|string|confirmed',
            'password_confirmation'   => 'required|min:5|string|same:password',
            'start_trial_date'        => 'required|date|date_format:Y-m-d',
            'end_trial_date'          => 'required|date|date_format:Y-m-d|after:start_trial_date',
            'start_paid_date'         => 'required|date|date_format:Y-m-d',
            'end_paid_date'           => 'required|date|date_format:Y-m-d|after:start_paid_date',
            
          
             ]);
            //    return $request;
            $request_data = $request->except(['image', '_token','password_confirmation']);
            if ($request->image) {
                $request_data['image'] = $this->uploadImage($request->image, 'category_images');
            }
    
            Teacher::create($request_data);
            session()->flash('success', __('site.add_successfuly'));
            return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
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
        $teacher = $this->model->findOrFail($id);
        $request->validate([
            'name'                    => 'required|unique:teachers|max:255',
            'email'                   => 'required|string|email|max:255|unique:teachers,email,'.$teacher->id,
            'password'                => 'required|min:5|string|confirmed',
            'password_confirmation'   => 'required|min:5|string|same:password',
            'start_trial_date'        => 'required|date|date_format:Y-m-d',
            'end_trial_date'          => 'required|date|date_format:Y-m-d|after:start_trial_date',
            'start_paid_date'         => 'required|date|date_format:Y-m-d',
            'end_paid_date'           => 'required|date|date_format:Y-m-d|after:start_paid_date',
           
        ]);
        $request_data = $request->except(['_token', 'image','password_confirmation']);
        if ($request->image) {
            if ($teacher->image != null) {
                Storage::disk('public_uploads')->delete('/category_images/' . $teacher->image);
            }
           $request_data['image'] = $this->uploadImage($request->image, 'category_images');
        } //end of if

        $teacher->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $teacher = $this->model->findOrFail($id);
        if($teacher->image != null){
            Storage::disk('public_uploads')->delete('/category_images/' . $teacher->image);
        }
        $teacher->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
}
