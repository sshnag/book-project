<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'file_path'    => 'sometimes|file|mimes:pdf|max:102400',
            'cover_image'  => 'sometimes|image|mimes:png,jpg|max:20480',
        ];
    }
}
