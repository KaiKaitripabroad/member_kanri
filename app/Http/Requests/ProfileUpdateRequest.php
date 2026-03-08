<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // 自由入力に変更した役職
            'position' => ['nullable', 'string', 'max:255'],
            
            // メンバー一覧の検索と連動する学籍番号
            'student_id' => ['nullable', 'string', 'max:255'],
            
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],

            // その他、必要に応じて残しておく項目
            'department' => ['nullable', 'string', 'max:100'],
            'grade' => ['nullable', 'integer', 'min:1', 'max:6'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'joined_at' => ['nullable', 'date'],
        ];
    }
}
