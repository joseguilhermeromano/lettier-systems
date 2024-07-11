<?php

namespace App\Controllers;

use App\Models\GuardianModel;
use CodeIgniter\RESTful\ResourceController;

class GuardianController extends ResourceController
{
    protected $modelName = 'App\Models\GuardianModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated($data, 'Guardian created successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        if ($this->model->update($id, $data)) {
            return $this->respond($data, 200, 'Guardian updated successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id], 'Guardian deleted successfully');
        } else {
            return $this->failNotFound('Guardian not found');
        }
    }

    public function details($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Guardian not found');
        }
    }

    public function list()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }
}
