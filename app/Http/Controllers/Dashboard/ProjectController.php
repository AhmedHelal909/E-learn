<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\BackEndController;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends BackEndController
{
    public function __construct(Project $model)
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
    } //end of index

    
    public function store(Request $request)
    {
         $request->validate([
        //     'ar.name'          => 'required|min:2|unique:project_translations,name',
               'en.name'          => 'required|min:2|max:60|unique:project_translations,name',
        //     'ar.description'   => 'required|min:2|unique:project_translations,description',
               'en.description'   => 'nullable|min:2|max:300|unique:project_translations,description',
         ]);

        $request_data = $request->except(['_token']);
        $project=Project::create($request_data);
        session()->flash('success', __('site.add_successfuly'));
        $module_name_plural ='projectimages';
        $module_name_singular ='projectimage';
        $append = $this->append();
        $projects=Project::where('id',$project->id)->get();
        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('projects','module_name_singular', 'module_name_plural'))->with($append);
       }

    public function update(Request $request, $id)
    {
        $project = $this->model->findOrFail($id);
         $request->validate([
        //     'ar.name'          => ['required', 'min:2', Rule::unique('project_translations', 'name')->ignore($project->id, 'project_id')],
             'en.name'          => ['required','max:60', 'min:2', Rule::unique('project_translations', 'name')->ignore($project->id, 'project_id')],
        //     'ar.description'   => ['nullable', 'min:2', Rule::unique('project_translations', 'description')->ignore($project->id, 'project_id')],
             'en.description'   => ['nullable','max:300' ,'min:2', Rule::unique('project_translations', 'description')->ignore($project->id, 'project_id')],
         ]);
        $request_data = $request->except(['_token']);
        
        $project->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }

    public function destroy($id, Request $request)
    {
        $project = $this->model->findOrFail($id);
        
        $project->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
}
