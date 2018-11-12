<?php

namespace App\Repositories;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contracts\MainRepositoryInterface;
use Illuminate\Contracts\Container\Container as App;

abstract class MainRepository implements MainRepositoryInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();


    /**
     * @return mixed
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        return $this->model = $model;
    }


    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }



    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        try{
            return $this->model->create($data);
        }catch (Exception $e){
            error_log($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id")
    {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function getObjects($paginate = 0)
    {
        if($paginate) {
            $objects = $this->model->paginate($paginate);
        }else {
            $objects = $this->model->all();
        }
        return $objects;
    }
}
