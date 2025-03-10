<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\ModelStates\Validation\ValidStateRule;
use App\States\User\UserState;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users'), 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'state' => new ValidStateRule(UserState::class),
        ];
    }
}
