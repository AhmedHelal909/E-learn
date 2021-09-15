<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Dashboard\BackEndController;
use App\Models\Country;


class CountryController extends BackEndController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
    public function index(Request $request)
    {
        $rows = $this->model;
        $rows = $this->filter($rows,$request);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        return view('dashboard.countries.index',compact('module_name_plural','module_name_singular','rows'));
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
                 'image'            => 'image',
                 'parent_id'        => 'sometimes|nullable|numeric',
             ]);
            //    return $request;
            $request_data = $request->except(['image', '_token']);
            if ($request->image) {
                $request_data['flag'] = $this->uploadImage($request->image, 'countries_images');
            }
    
            Country::create($request_data);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $country = $this->model->findOrFail($id);
        $request->validate([
            //'ar.name'          => ['required', 'min:5', Rule::unique('category_translations','name')->ignore($category->id, 'category_id') ],
            'en.name'          => ['required', 'max:60','min:3'],
            //'ar.description'   => ['required', 'min:5', Rule::unique('category_translations','description')->ignore($category->id, 'category_id') ],
            'image'            => 'nullable|image',
            'parent_id' => 'sometimes|nullable|numeric'
        ]);
        $request_data = $request->except(['_token', 'image']);
        if ($request->image) {
            if ($country->image != null) {
                Storage::disk('public_uploads')->delete('/countries_images/' . $country->image);
            }
           $request_data['flag'] = $this->uploadImage($request->image, 'countries_images');
        } //end of if

        $country->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $country = $this->model->findOrFail($id);
        if($country->image != null){
            Storage::disk('public_uploads')->delete('/category_images/' . $country->image);
        }
        $country->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
}
