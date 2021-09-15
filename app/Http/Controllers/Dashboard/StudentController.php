<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Dashboard\BackEndController;


class StudentController extends BackEndController
{
    public function __construct(Student $model)
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
            'name'                    => 'required|unique:students|max:255',
            'email'                   => 'required|email|unique:students',
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
    
            Student::create($request_data);
            session()->flash('success', __('site.add_successfuly'));
            return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    public function update(Request $request, $id)
    {
        $student = $this->model->findOrFail($id);
        $request->validate([
            'name'                    => 'required|unique:students,name,'.$student->id,
            'email'                   => 'required|email|unique:students,email,'.$student->id,
            'password'                => 'required|min:5|string|confirmed',
            'password_confirmation'   => 'required|min:5|string|same:password',
            'start_trial_date'        => 'required|date|date_format:Y-m-d',
            'end_trial_date'          => 'required|date|date_format:Y-m-d|after:start_trial_date',
            'start_paid_date'         => 'required|date|date_format:Y-m-d',
            'end_paid_date'           => 'required|date|date_format:Y-m-d|after:start_paid_date',
            
          
             ]);
      
        $request_data = $request->except(['_token', 'image','password_confirmation']);
        if ($request->image) {
            if ($student->image != null) {
                Storage::disk('public_uploads')->delete('/category_images/' . $student->image);
            }
           $request_data['image'] = $this->uploadImage($request->image, 'category_images');
        } //end of if

        $student->update($request_data);
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
        
        $student = $this->model->findOrFail($id);
        if($student->image != null){
            Storage::disk('public_uploads')->delete('/category_images/' . $student->image);
        }
        $student->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
}
