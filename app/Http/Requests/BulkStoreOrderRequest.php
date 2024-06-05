<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('delete');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // has que supplierId sea unico y que no se pueda repetir de los que ya estan

            '*.supplierId' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in(['Pending', 'Processing', 'Completed'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],
        ];
    }
    public function prepareForValidation()
    {
        $data = [];
        foreach ($this->toArray() as $obj) {
            $obj['supplier_id'] = $obj['supplierId'] ?? null;
            $obj['billed_dated'] = $obj['billedDate'] ?? null;
            $obj['paid_dated'] = $obj['paidDate'] ?? null;
            $data[] = $obj;
        }
        $this->merge($data);
    }
}
