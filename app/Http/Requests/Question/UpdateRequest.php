<?php

namespace App\Http\Requests\Question;

use App\Rules\OnlyAsDraft;
use App\Rules\WithQuestionMark;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $question = $this->route()->question;

        return Gate::allows('update', $question);
    }

    public function rules(): array
    {
        $question = $this->route()->question;

        return [
            'question' => [
                'required',
                new WithQuestionMark,
                new OnlyAsDraft($question),
                'min:10',
                Rule::unique('questions')->ignoreModel($question)]
        ];
    }
}
