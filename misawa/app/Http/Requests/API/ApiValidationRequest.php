<?php
namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiValidationRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 500,
            'result' => [
                'errors' => $validator->errors()->toArray()
            ]
        ];

        throw new HttpResponseException(response()->json($response, 500));
    }
}
