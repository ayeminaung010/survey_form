<?php

namespace App\Http\Controllers;

use App\Models\formData;
use App\Models\questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreformDataRequest;
use App\Http\Requests\UpdateformDataRequest;

class FormDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveys = formData::all();
        return view('welcome', compact('surveys'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //db transaction
        try {
            DB::beginTransaction();
            //validataion survey form
            $request->validate([
                'survey_name' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            //validataion question form
            $request->validate([
                'title' => 'required',
                'type' => 'required',
            ]);


            //store survey form
            $form_id =  formData::create([
                'name' => $request->survey_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            //store question data
            foreach ($request->title as $key => $title) {
                $question = new questions();
                $question->title = $title;
                $question->type = $request->type[$key];
                $question->form_id = $form_id->id;
                $question->save();
            }
            DB::commit();
            //send alert message
            $request->session()->flash('success', 'Survey Created Successfully');

            return redirect()->route('survey.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $request->session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(formData $formData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(formData $formData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateformDataRequest $request, formData $formData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(formData $formData)
    {
        //
    }
}
