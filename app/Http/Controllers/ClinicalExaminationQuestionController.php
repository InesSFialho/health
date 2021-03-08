<?php

namespace App\Http\Controllers;

use App\ClinicalExaminationQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClinicalExaminationQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions= ClinicalExaminationQuestion::all();
        
        return view('backoffice.clinical-examination-questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backoffice.clinical-examination-questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|max:255'
        ])->validate();

        $question = new ClinicalExaminationQuestion;
        $question->question = $request->question;
        $question->save();

        flash(__('Question successfully created!'))->success();

        return redirect()->route('clinical-examination-questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClinicalExaminationQuestion  $clinicalExaminationQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(ClinicalExaminationQuestion $clinicalExaminationQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClinicalExaminationQuestion  $clinicalExaminationQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(ClinicalExaminationQuestion $clinicalExaminationQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClinicalExaminationQuestion  $clinicalExaminationQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClinicalExaminationQuestion $clinicalExaminationQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClinicalExaminationQuestion  $clinicalExaminationQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClinicalExaminationQuestion $clinicalExaminationQuestion)
    {
        //
    }
}
