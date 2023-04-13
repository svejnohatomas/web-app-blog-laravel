<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO: Authorized user only
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'slug' => ['required', 'max:255', 'unique:posts'],
            'title' => ['required', 'max:255'],
            'excerpt' => ['required', 'max:255'],
            'content' => ['required'],
        ];
    }
}
