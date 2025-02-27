<?php

namespace App\Repositories;

use App\Http\Controllers\Concerns\Paginatable;
use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface 
{
    use Paginatable;
    protected $model;

    public function __construct() {
        $this->setModel();
    }

    /**
     * Getter
     * 
     */
    abstract public function getModel();

    /**
     * Setter
     * 
     */
    public function setModel() {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get all
     * @return mixed
     */
    public function getAll() {
        return $this->model->orderByDesc('id')->paginate($this->getPerPage());
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id) {
        $result = $this->model->find($id);
        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * Update model detail that have change
     * @param $modelDetail
     * @param array $dataUpdate
     * @return mixed
     */
    public function updateChange($modelDetail, $dataUpdate = [], $fieldNoUpdate=[])
    {   
        $fieldAble = array_diff($modelDetail->getFillable(), $fieldNoUpdate);
        $dataSave = [];
        foreach($fieldAble as $key){
                //can update field to empty
                if( request()->has($key) && $modelDetail[$key] != $dataUpdate[$key]){
                    $dataSave[$key] = $dataUpdate[$key];
                }   
        }
        if(count($dataSave) > 0){
            $modelDetail = $modelDetail->update($dataSave);
            return $modelDetail;
        }
        return false;
    }
}