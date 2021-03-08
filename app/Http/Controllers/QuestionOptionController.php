<?php

namespace App\Http\Controllers;

use App\QuestionOption;
use App\ClinicalExaminationQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class QuestionOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($question_id)
    {
        $question = ClinicalExaminationQuestion::find($question_id);

        return view('backoffice.question-options.index', compact('question'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($question_id)
    {
        $question = ClinicalExaminationQuestion::find($question_id);

        return view('backoffice.question-options.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $question_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $option = new QuestionOption;
        $option->name = $request->name;
        $option->clinical_examination_question_id = $question_id	;
        $option->save();

        flash(__('Option successfully created!'))->success();

        return redirect()->route('clinical-examination-questions.options.index', $question_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuestionOption  $questionOption
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionOption $questionOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuestionOption  $questionOption
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionOption $questionOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuestionOption  $questionOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionOption $questionOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuestionOption  $questionOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionOption $questionOption)
    {
        //
    }
}
