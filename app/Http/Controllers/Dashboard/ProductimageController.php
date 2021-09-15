<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Productimage;
class ProductimageController extends BackEndController
{
    public function __construct(Productimage $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
       //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->OrWhereHas('product',function($q) use ($request){
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
        $rows = $this->model->where('product_id',$id)->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    
    }
    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $products=Product::all();

        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('module_name_singular', 'module_name_plural','products'))->with($append);
    } //end of create
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image'      => 'required|image'
        ]);
         
         $request_data = $request->except(['image']);
         if ($request->image) {
             $request_data['image'] = $this->uploadImage($request->image, 'products');
            }
      
            Productimage::create($request_data);

        session()->flash('success', __('site.add_successfuly'));
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $products=Product::where('id',Productimage::latest()->first()->product_id)->get();

        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('module_name_singular', 'module_name_plural','products'))->with($append);
      }



    public function update(Request $request, $id)
    {

        $productimage = $this->model->findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image'      => 'image'
        ]);
        $request_data = $request->except(['image']);

        if ($request->image) {
            if ($productimage->image != null) {
                Storage::disk('public_uploads')->delete('/products/' . $productimage->image);
            }
           $request_data['image'] = $this->uploadImage($request->image, 'products');
        } 
        $productimage->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }



    public function destroy($id, Request $request)
    {
        $slider = $this->model->findOrFail($id);
        if($slider->image != null){
            Storage::disk('public_uploads')->delete('/products/' . $slider->image);
        }

        $slider->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    
}
