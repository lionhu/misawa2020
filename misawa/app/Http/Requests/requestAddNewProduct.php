<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class requestAddNewProduct extends FormRequest
{
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
              "catalogue" => "required",
              "subcatalogue" => "required",
              "manufactory" => "required",
              "product_code" => "required|unique:products",
              "name" => "required",
              "name_jp" => "required",
              "unit" => "required",
              "tablets" => "required",
              "o_price" => "required|numeric",
              "b_price" => "required|numeric",
              "r_price" => "required|numeric"
        ];
    }

    public function messages(){
        return [
            "catalogue.required" => "大类，必须选择",
            "subcatalogue.required" => "小类，必须选择",
            "manufactory.required" => "必须选择制药商",
            "product_code.required" => "产品编号，必须输入",
            "product_code.unique" => "产品编号相同的产品已经存在！",
            "name.required" => "产品名，必须输入",
            "name_jp.required" => "日文产品名，必须输入",
            "unit.required" => "单位，必须输入",
            "tablets.required" => "数量，必须输入",
            "o_price.required" => "对外公开售价，必须输入",
            "b_price.required" => "代理商进货价，必须输入",
            "r_price.required" => "药店进货价，必须输入",
            "o_price.numeric" => "对外公开售价，必须是数字",
            "b_price.numeric" => "代理商进货价，必须是数字",
            "r_price.numeric" => "药店进货价，必须是数字"
        ];
    }
}
