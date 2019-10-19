<?php
/**
 * Created by PhpStorm.
 * User: huhaiguang
 * Date: 16/9/4
 * Time: 下午8:46
 */

namespace App\Repositories\Contact;


interface PORepositoryInterface
{
    public function poAddNew($poinfo,$user,$customer,$cart);

}