<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TokenModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class AuthController extends ResourceController
{
    use ResponseTrait;

    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function index()
    {
        return $this->respond(['success' => true, "message" => "Seja bem-vindo à API Lettier! Feito com carinho por José Romano!"], 200);
    }

    public function register()
    {
        $rules = [
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $data = [
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        ];

        $userModel->save($data);

        return $this->respondCreated(['message' => 'User registered successfully']);
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getVar('email'))->first();

        if (!$user || !password_verify($this->request->getVar('password'), $user['password'])) {
            return $this->failUnauthorized('Invalid credentials');
        }

        $ses_data = [
            'id' => $user['id'],
            'email' => $user['email'],
            'isLoggedIn' => true
        ];
        $this->session->set($ses_data);

        $token = bin2hex(random_bytes(64));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $tokenData = [
            'user_id'   => $user['id'],
            'token'     => $token,
            'expires_at' => $expires_at
        ];

        log_message('info', 'Token Data: ' . json_encode($tokenData));

        try {
            $tokenModel = new TokenModel();
            $tokenModel->save($tokenData);
            log_message('info', 'Token saved successfully.');
        } catch (\Exception $e) {
            log_message('error', 'Error saving token: ' . $e->getMessage());
            return $this->fail('An error occurred while saving the token.');
        }

        return $this->respond(['token' => $token, 'expires_at' => $expires_at]);
    }

    public function logout()
    {
        $this->session->destroy();

        $authHeader = $this->request->header('Authorization');
        if (!$authHeader) {
            return $this->failUnauthorized('Authorization header not found');
        }

        $token = substr($authHeader->getValue(), 7);
        if (!$this->validateToken($token)) {
            return $this->failUnauthorized('Invalid or expired token');
        }

        $tokenModel = new TokenModel();
        $tokenModel->where('token', $token)->delete();

        return $this->respondDeleted(['message' => 'User logged out successfully']);
    }

    public function validateToken($token)
    {
        $tokenModel = new TokenModel();
        $tokenData = $tokenModel->where('token', $token)->first();

        if (!$tokenData || strtotime($tokenData['expires_at']) < time()) {
            return false;
        }

        return true;
    }

    public function userData()
    {
        $authHeader = $this->request->header('Authorization');
        if (!$authHeader) {
            return $this->failUnauthorized('Authorization header not found');
        }

        $token = $authHeader->getValue();
        if (!$this->validateToken($token)) {
            return $this->failUnauthorized('Invalid or expired token');
        }

        $tokenModel = new TokenModel();
        $tokenData = $tokenModel->where('token', $token)->first();

        $userModel = new UserModel();
        $user = $userModel->find($tokenData['user_id']);

        return $this->respond($user);
    }
}
