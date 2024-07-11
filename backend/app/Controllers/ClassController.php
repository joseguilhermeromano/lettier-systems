<?php

namespace App\Controllers;

use App\Models\ClassModel;
use CodeIgniter\RESTful\ResourceController;

class ClassController extends ResourceController
{
    protected $modelName = 'App\Models\ClassModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated($data, 'Class created successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        if ($this->model->update($id, $data)) {
            return $this->respond($data, 200, 'Class updated successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id], 'Class deleted successfully');
        } else {
            return $this->failNotFound('Class not found');
        }
    }

    public function details($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Class not found');
        }
    }

    public function list()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }
}
