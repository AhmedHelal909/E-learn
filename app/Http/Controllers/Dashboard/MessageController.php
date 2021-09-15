<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Message;
use Illuminate\Http\Request;


class MessageController extends BackEndController
{
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }

    public function destroy($id, Request $request)
    {
        $order = $this->model->findOrFail($id);

        $order->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    } // end destroy function

    protected function filter($rows,$request)
    {
        $rows = $rows->when($request->search , function ($q) use ($request){

            return $q->where('message' , 'Like', '%' .$request->search . '%' )
                     ->orWhereHas('user' , function($query) use($request){
                $query->where('name' , 'Like', '%' .$request->search . '%' );
            } );
        });

        $rows = $rows->when($request->date , function ($q) use ($request){

            return $q->whereDate('created_at' , $request->date );

        });
        $rows = $rows->when($request->type , function ($q) use ($request){

            return $q->where('type' , $request->type );

        })->latest()->paginate(10);
        return $rows;
    }

}
