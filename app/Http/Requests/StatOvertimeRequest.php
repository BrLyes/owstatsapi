<?php

namespace App\Http\Requests;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatOvertimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => [
                "required",
                "exists:characters,name"
            ],
            "stat" => [
                "required",
                Rule::in(Game::STATS)
            ],
            "after" => [
                "required",
                "date",
            ],
            "before" => [
                "required",
                "date",
            ]
        ];
    }
}
