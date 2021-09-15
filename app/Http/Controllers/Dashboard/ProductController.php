<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\BackEndController;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends BackEndController
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
       //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->whereTranslationLike('name','%' .$request->search. '%')
              ->orWhereTranslationLike('description','%' .$request->search. '%')
              ->OrWhereHas('category',function($q) use ($request){
                $q->whereTranslationLike('name','%' .$request->search. '%');
              });
        })->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index

    public function show($id)
    {
       //get all data of Model
        $rows = $this->model->where('category_id',$id)->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //en
    public function store(Request $request)
    {
         $request->validate([
        //     'ar.name'          => 'required|min:2|unique:product_translations,name',
             'en.name'          => 'required|min:2|unique:product_translations,name|max:60',
        //     'ar.description'   => 'required|min:2|unique:product_translations,description',
             'en.description'   => 'nullable|min:2|max:300|unique:product_translations,description',
            //  'size'             =>'required',
             'code'          => 'required|min:2|unique:products,code|max:100',

         ]);
        //    return $request;
        $request_data = $request->except(['_token']);
        // $request_data['size']=json_encode($request->size);

        $product=Product::create($request_data);
        $products=Product::where('id',$product->id)->get();
        $module_name_plural   = 'productimages';
        $module_name_singular = 'productimage';
        session()->flash('success', __('site.add_successfuly'));
        return view('dashboard.productimages.create',compact('module_name_plural','module_name_singular','products'));
    }

 
    public function update(Request $request, $id)
    {
        $product = $this->model->findOrFail($id);
         $request->validate([
        //     'ar.name'          => ['required', 'min:2', Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id')],
             'en.name'          => ['required','max:60', 'min:2', Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id')],
        //     'ar.description'   => ['required', 'min:2', Rule::unique('product_translations', 'description')->ignore($product->id, 'product_id')],
             'en.description'   => ['nullable', 'max:300','min:2', Rule::unique('product_translations', 'description')->ignore($product->id, 'product_id')],
            //  'size'             =>'required',
             'code'          => ['required','max:100', 'min:2', Rule::unique('products', 'code')->ignore($product->id, 'id')],

             ]);
        $request_data = $request->except(['_token']);
        // if($request->size)
        // {
        //     $request_data['size']=json_encode($request->size);

        // }
        
        $product->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }

    public function destroy($id, Request $request)
    {
        $product = $this->model->findOrFail($id);
        
        $product->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
}
