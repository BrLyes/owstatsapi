<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameStoreRequest extends FormRequest
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
            "kill" => [
                "required",
                "numeric"
            ],
            "death" => [
                "required",
                "numeric"
            ],
            "assist" => [
                "required",
                "numeric"
            ],
            "damage" => [
                "required",
                "numeric"
            ],
            "heal" => [
                "required",
                "numeric"
            ],
            "mitigate" => [
                "required",
                "numeric"
            ],
            "match_date" => [
                "required",
                "date"
            ],
            "accuracy" => [
                "numeric",
                "between:0,100"
            ]
        ];
    }
}
