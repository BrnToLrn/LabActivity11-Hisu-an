<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->author()->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:120'],
            'body'         => ['required', 'string', 'min:20'],
            'category'     => ['required', 'in:Announcement,Health,Peace & Order,Ayuda,Community Updates'],
            'tags'         => ['required', 'array', 'min:1'],
            'tags.*'       => ['exists:tags,id'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
