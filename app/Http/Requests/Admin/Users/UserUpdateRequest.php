<?php

namespace App\Http\Requests\Admin\Users;

use App\Utils\Permissions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (Auth::user()->can(Permissions::$EDIT_USERS))
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:30',
            'address' => 'required|min:5|max:100',
            'phone_number' => ['required', 'regex:/^(\+92|0)(3\d{2}|4[1-9]\d|5[0-6]\d|7[0-1]\d|9[0-5]\d)\d{7}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number' => 'Please enter a valid phone number, eg: +923401234567 OR 03401234567'
        ];
    }
}
