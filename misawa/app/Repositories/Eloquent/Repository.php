<?php
/**
 * Created by PhpStorm.
 * User: huhaiguang
 * Date: 16/9/4
 * Time: 下午8:51
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Contact\RepositoryInterface;
use App\Repositories\Exception\RepositoryException;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Container\Container as App;



abstract class Repository implements RepositoryInterface
{
    private $app;
    protected $model;
//    protected $criteria;
//    protected $skipCriteria = false;

    /**
     * Repo constructor.
     * @param $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
//        $this->criteria=$collection;

//        $this->resetScope();
        $this->makeModel();

    }

    abstract function model();

    public function makeModel(){
        $model=$this->app->make($this->model());
        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        return $this->model=$model;
    }


    public function all($columns = array('*')){
//        $this->applyCriteria();
        return $this->model->get($columns);
    }
    public function paginate($perPage = 15, $columns = array('*')){
//        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }
    public function create(array $data){

        return $this->model->create($data);
    }
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }
    public function delete($id){

        return $this->model->destroy($id);
    }
    public function find($id, $columns = array('*')){
//        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }
    public function findBy($attribute, $value, $columns = array('*')) {
//        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
    }
}