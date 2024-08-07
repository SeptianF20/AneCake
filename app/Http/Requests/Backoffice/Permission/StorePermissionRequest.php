<?php

namespace App\Http\Requests\Backoffice\Permission;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:permissions',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Permission name is required',
            'name.unique' => 'Permission name already exists',
        ];
    }
}
