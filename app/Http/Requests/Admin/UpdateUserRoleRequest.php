<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class UpdateUserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isAdmin();
    }

    /**
     * @return array<string, list<int|string|Enum>>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            /** @var User $target */
            $target = User::query()->findOrFail((int) $this->input('user_id'));

            if ($target->isAdmin() && $this->input('role') === 'user') {
                $adminCount = User::query()->where('role', 'admin')->count();
                if ($adminCount <= 1) {
                    $validator->errors()->add('role', __('backend.error_last_admin'));
                }
            }
        });
    }
}
