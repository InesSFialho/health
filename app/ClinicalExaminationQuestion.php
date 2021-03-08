<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClinicalExaminationQuestion extends Model
{
    public function options()
    {
        $options = QuestionOption::where('clinical_examination_question_id', $this->id)
        ->get();

        return $options;
    }
}
