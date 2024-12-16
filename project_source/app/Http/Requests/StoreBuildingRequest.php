<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (
                auth()->user()->role === 'admin');  }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'build_name' => [
                'required',
                'regex:/^[A-H][1-9]$/',
                'unique:buildings,build_name',
            ],
            'manager_id' => 'nullable|exists:users,id',
            'type' => 'required|in:male,female',
            'floor_numbers' => 'required|integer|min:1',
            'room_numbers' => 'required|integer|min:1',
        ];
    }
    public function messages(): array
    {
        return [
            'build_name.required' => 'Tên tòa nhà là bắt buộc.',
            'build_name.regex' => 'Tên tòa nhà phải bắt đầu bằng chữ cái từ A đến H, theo sau là một số từ 1 đến 9.',
            'build_name.unique' => 'Tên tòa nhà đã tồn tại, vui lòng chọn tên khác.',
            'type.required' => 'Loại tòa nhà là bắt buộc.',
            'type.in' => 'Loại tòa nhà chỉ được chọn giữa male hoặc female.',
            'floor_numbers.required' => 'Số tầng là bắt buộc.',
            'room_numbers.required' => 'Số phòng là bắt buộc.',
        ];
    }
}
