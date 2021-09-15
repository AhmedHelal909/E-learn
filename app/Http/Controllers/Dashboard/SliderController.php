<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\BackEndController;
use App\Models\Slider;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends BackEndController
{
    public $model;
    public function __construct(Slider $model)
    {
        parent::__construct($model);
      $this->model =   $model;
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
         //array for validations
         $rules=[
             'image'=>'required',
        ];

         foreach (config('translatable.locales') as $locale){

             $rules += [$locale . '.name' => ['required','min:3','max:60']];
             $rules += [$locale . '.description' => ['required','max:300']];


         } // end of foreach

         $request->validate($rules);
         $request_data = $request->except(['image','video']);
         if ($request->image) {
             $request_data['image'] = $this->uploadImageSlider($request->image, 'slider_images');
            }
        
         Slider::create($request_data);

         //Noty
        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }


    public function update(Request $request, $id)
    {
        $slider = $this->model->findOrFail($id);
        //array for validations
        $rules=[];

        foreach (config('translatable.locales') as $locale){

            $rules += [$locale . '.name' => ['required' ,'min:3','max:60', Rule::unique('slider_translations' , 'name')->ignore($slider->id , 'slider_id')]];
            $rules += [$locale . '.description' => ['required' ,'max:300', Rule::unique('slider_translations' , 'description')->ignore($slider->id , 'slider_id')]];

        } // end of foreach

        $request->validate($rules);

        $request_data = $request->except(['video', 'image']);

        if ($request->image) {
            if ($slider->image != null) {
                Storage::disk('public_uploads')->delete('/slider_images/' . $slider->image);
            }
           $request_data['image'] = $this->uploadImageSlider($request->image, 'slider_images');
        } //end of if
       
        $slider->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    public function destroy($id, Request $request)
    {
        $slider = $this->model->findOrFail($id);
        if($slider->image != null){
            Storage::disk('public_uploads')->delete('/slider_images/' . $slider->image);
        }

        $slider->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    // public function upload($request)
    // {

    //     if($request->hasFile('video')){

    //         $file = $request->file('video');
    //         $filename = $file->getClientOriginalName();
    //         $path = public_path().'/uploads/slider_videos/';
    //         $file->move($path, $filename);
    //         return $filename;
    //     }

    //}
}
