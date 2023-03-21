<?php

namespace App\Http\Controllers;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class FormController extends Controller
{
   public function index(Request $request)
   {
       $active ='formAct';
       $forms = Form::orderBy('id','DESC')->paginate(5);
       return view('forms.index',compact('forms'))->with('i', ($request->input('page', 1) - 1) * 5)->with('active',$active);
   }
    public function create(Request $request)
    {
        $active ='formAct';
        return view('forms.create')->with('active',$active);;
    }

    public function store(Request $request)
    {
        $active = 'formAct';
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required',
            'form_data'=> 'nullable'
        ]);
        $user = Auth::user();
        $input = $request->all();
        $form = Form::create($input);
        $form->name = $request->input('form_name');
        $form->user_id= $user->id;
        $form->save();

        return view('forms.index')
            ->with('success', 'Form created successfully')
            ->with('active', $active);
    }

    public function survey () {
        $active ='formAct';

        return view('forms.survey')->with('active',$active);;
    }
}
