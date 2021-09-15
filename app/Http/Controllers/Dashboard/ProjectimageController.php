<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Projectimage;
use App\Models\Project;
class ProjectimageController extends BackEndController
{
    public function __construct(Projectimage $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
       //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->OrWhereHas('project',function($q) use ($request){
                $q->whereTranslationLike('name','%' .$request->search. '%');
              });
        })->paginate(6);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //en

    public function show($id)
    {
       //get all data of Model
        $rows = $this->model->where('project_id',$id)->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //en
    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $projects=Project::all();
        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('projects','module_name_singular', 'module_name_plural'))->with($append);
    } //end 
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'image'      => 'required|image'
        ]);
     
         $request_data = $request->except(['image']);
         if ($request->image) {
             $request_data['image'] = $this->uploadImage($request->image, 'projects');
            }
      
            Projectimage::create($request_data);

        session()->flash('success', __('site.add_successfuly'));
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $projects=Project::where('id',Projectimage::latest()->first()->project_id)->get();
        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('projects','module_name_singular', 'module_name_plural'))->with($append);
       }

    public function update(Request $request, $id)
    {
        $projectimage = $this->model->findOrFail($id);
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'image'      => 'image'
        ]);
        $request_data = $request->except(['image']);

        if ($request->image) {
            if ($projectimage->image != null) {
                Storage::disk('public_uploads')->delete('/projects/' . $projectimage->image);
            }
           $request_data['image'] = $this->uploadImage($request->image, 'projects');
        } 
        $projectimage->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    public function destroy($id, Request $request)
    {
        $project = $this->model->findOrFail($id);
        if($project->image != null){
            Storage::disk('public_uploads')->delete('/projects/' . $project->image);
        }

        $project->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    
}
