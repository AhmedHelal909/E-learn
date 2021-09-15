<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Dashboard\BackEndController;
use App\Models\Subject;

class SubjectController extends BackEndController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Subject $model)
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

  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            //     'ar.name'          => 'required|min:5|unique:category_translations,name',
                 'en.name'          => 'required|min:3|max:60',
            //     'ar.description'   => 'required|min:5|unique:category_translations,description',
               
             ]);
            //    return $request;
            $request_data = $request->except(['image', '_token']);
            if ($request->image) {
                $request_data['image'] = $this->uploadImage($request->image, 'category_images');
            }
    
            Subject::create($request_data);
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
        $subject = $this->model->findOrFail($id);
        $request->validate([
            //'ar.name'          => ['required', 'min:5', Rule::unique('category_translations','name')->ignore($category->id, 'category_id') ],
            'en.name'          => ['required', 'max:60','min:3'],
            //'ar.description'   => ['required', 'min:5', Rule::unique('category_translations','description')->ignore($category->id, 'category_id') ],
        
        ]);
        $request_data = $request->except(['_token', 'image']);
        if ($request->image) {
            if ($subject->image != null) {
                Storage::disk('public_uploads')->delete('/category_images/' . $subject->image);
            }
           $request_data['image'] = $this->uploadImage($request->image, 'category_images');
        } //end of if

        $subject->update($request_data);
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
        $subject = $this->model->findOrFail($id);
        if($subject->image != null){
            Storage::disk('public_uploads')->delete('/category_images/' . $subject->image);
        }
        $subject->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
}
