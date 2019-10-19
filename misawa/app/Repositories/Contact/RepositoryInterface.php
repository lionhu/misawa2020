<?php
/**
 * Created by PhpStorm.
 * User: huhaiguang
 * Date: 16/9/4
 * Time: 下午8:46
 */

namespace App\Repositories\Contact;


interface RepositoryInterface
{
    public function all($columns = array('*'));
    public function paginate($perPage = 15, $columns = array('*'));
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id, $columns = array('*'));
    public function findBy($field, $value, $columns = array('*'));
}