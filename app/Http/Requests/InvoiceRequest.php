<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'invoice_no' => ['required'],
            'customer_email' => ['email', 'required'],
            'date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after:date'],
            'comment' => ['string','nullable'],
            'subtotal' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'product_id.*' => ['required'],
            'price.*' => ['required', 'numeric'],
            'quantity.*' => ['required', 'numeric'],
            'rowTotal.*' => ['required', 'numeric'],
        ];
    }
}
