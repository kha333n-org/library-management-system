<?php

namespace App\Http\Requests\Admin\Roles;

use App\Utils\Permissions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can(Permissions::$MANAGE_ROLES))
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:15'
        ];
    }

    public function messages()
    {
        return [
            'name' => 'same name already used',
        ];
    }
}
