<?php

namespace App\Controllers;

use App\Models\CourseModel;
use CodeIgniter\RESTful\ResourceController;

class CourseController extends ResourceController
{
    protected $modelName = 'App\Models\CourseModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data, 'Course created successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        if ($this->model->update($id, $data)) {
            return $this->respond($data, 200, 'Course updated successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id], 'Course deleted successfully');
        } else {
            return $this->failNotFound('Course not found');
        }
    }

    public function details($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Course not found');
        }
    }

    public function list()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }
}
