<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\BackEndController;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PartnerController extends BackEndController
{
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }
    public function index(Request $request)
    {
       //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->where('name','like','%' .$request->search. '%');
        })->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image'=> ['image','required']
        ]);
        $request_data=$request->except(['image']);

        // store image
        if ($request->image) {
            $request_data['image'] = $this->uploadImage($request->image, 'client_images');
        }

        Partner::create($request_data);

        session()->flash('success', __('site.added_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    } //end of store



    public function update(Request $request,$id)
    {
        $partner=$this->model->findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' =>['image'],
        ]);

        $request_data=$request->except(['image']);

        // store image
        if ($request->image) {
            if ($partner->image != null) {
                Storage::disk('public_uploads')->delete('/client_images/' . $partner->image);
            }
           $request_data['image'] = $this->uploadImage($request->image, 'client_images');
        } //end of if

        $partner->update($request_data);

        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }//end of update

    


    public function destroy($id, Request $request)
    {
        $partner = $this->model->findOrFail($id);
            if ($partner->image != null) {
                Storage::disk('public_uploads')->delete('/client_images/' . $partner->image);
            }
        $partner->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }


}
