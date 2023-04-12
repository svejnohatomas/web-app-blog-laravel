<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
            'category_id' => ['required', 'exists:App\Models\Category,id'],
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'slug' => ['required', 'max:255'],
            'title' => ['required', 'max:255'],
            'excerpt' => ['required', 'max:255'],
            'content' => ['required'],
        ];
    }
}
