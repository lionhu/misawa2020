<?php

namespace App\Http\Requests;

use App\Http\Requests\API\ApiValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;  // 追加
use Illuminate\Http\Exceptions\HttpResponseException;  // 追加
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request; // 追加


class CheckoutRequest extends FormRequest
{
//    use ApiValidationRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "vendor_id"=>"required",
            "customer.postcode"=>"required | min:2",
            "customer.name"=>"required | min:2",
            "customer.address1"=>"required | min:4",
            "customer.address2"=>"required | min:4",
            "customer.email"=>"required | email|min:5",
            "customer.phone"=>"required | min:4"
        ];
    }

    public function messages(){
        return [
            'vendor_id.required' => 'Shop：必须输入',
            'customer.name.required' => '客户姓名：必须输入',
            'customer.name.min' => '客户姓名：2字符以上',
            'customer.postcode.required' => '邮编：必须输入',
            'customer.postcode.min' => '邮编：5字符以上',
            'customer.address1.required' => '地址（2／1）：必须输入',
            'customer.address1.min' => '地址（2／1）：4字符以上',
            'customer.address2.required' => '地址（2／2）：必须输入',
            'customer.address2.min' => '地址（2／2）：4字符以上',
            'customer.email.required' => '为了即使通知到客户，电子邮件地址：必须输入',
            'customer.email.min' => '为了即使通知到客户，电子邮件地址：5字符以上',
            'customer.email.email' => '不是合法的电子邮箱地址。',
            'customer.phone.required' => '联系电话：必须输入',
            'customer.phone.min' => '联系电话：4字符以上'
        ];
    }

    public function response( array $errors )
    {
        $response = [
            'data'    => $errors,
            'result'  => 'NG',
            'summary' => 'Failed validation.',
            'errors'  => $errors,
        ];


        return new JsonResponse( $response, 422 );
    }
}
