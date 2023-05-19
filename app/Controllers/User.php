<?php

namespace App\Controllers;

use App\Models\M_User;

class User extends BaseController
{
    protected $db, $builder, $userModel, $divisiModel, $posisiModel, $employeeModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->userModel = new M_User();
        $this->divisiModel = new \App\Models\M_Divisi();
        $this->posisiModel = new \App\Models\M_Posisi();
        $this->employeeModel = new \App\Models\M_Employee();
    }
    public function index()
    {
        $data['title'] = 'My Profile';
        return view('user/index', $data);
    }

    public function data_user()
    {
        $data['title'] = 'Add Data';
        return view('user/edit', $data);
    }


    public function add_user()
    {
        $data = [
            'title' => 'Add User',
        ];
        $divisi = $this->divisiModel->list();
        $data['divisi'] = $divisi;

        $posisi = $this->posisiModel->list();
        $data['posisi'] = $posisi;
        // $data['title']  = 'User List';

        helper('form');

        if (!$this->request->is('post')) {
            return view('admin/add_user', $data);
        }

        $post = $this->request->getPost(['fullname', 'username', 'email', 'divisi', 'position', 'password_hash']);

        if (!$this->validateData($post, [
            'fullname'          => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'username'          => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'email'             => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'divisi'            => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'position'          => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'password_hash'     => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
            // session()->setFlashdata('success', 'Post Berhasil Disimpan');
        }

        $dataUser = [
            'fullname'          => $post['fullname'],
            'username'          => $post['username'],
            'email'             => $post['email'],
            'divisi'            => $post['divisi'],
            'position'          => $post['position'],
            'password_hash'     => $post['password_hash'],
        ];
        $this->userModel->insert_user($dataUser);
        return redirect('admin/index')->with('success', 'Data Added Successfully');

        // return view('admin/add_user', $data);
    }

    public function delete($id)
    {
        $this->userModel->deleteUser($id);
        return redirect('admin/index');
    }

    public function data_profile()
    {
        $data['title'] = 'Add Data';

        $divisi = $this->divisiModel->list();
        $data['divisi'] = $divisi;

        $posisi = $this->posisiModel->list();
        $data['posisi'] = $posisi;

        helper('form');

        if (!$this->request->is('post')) {
            return view('user/edit', $data);
        }

        $post = $this->request->getPost([
            'id_employee',
            'name',
            'email',
            'birth_place',
            'birth_date',
            'no_tlp',
            'address',
            'gender',
            'religion',
            'degree',
            'divisi',
            'position'
        ]);

        if (!$this->validateData($post, [
            'id_employee'   => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'name'          => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'email'         => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'birth_place'   => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'birth_date'    => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'no_tlp'        => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'address'       => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'gender'        => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'religion'      => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'degree'        => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'divisi'        => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            'position'      => ['rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $dataEmployee = [
            'id_employee'   => $post['id_employee'],
            'name'          => $post['name'],
            'email'         => $post['email'],
            'birth_place'   => $post['birth_place'],
            'birth_date'    => $post['birth_date'],
            'no_tlp'        => $post['no_tlp'],
            'address'       => $post['address'],
            'gender'        => $post['gender'],
            'religion'      => $post['religion'],
            'degree'        => $post['degree'],
            'divisi'        => $post['divisi'],
            'position'      => $post['position'],
        ];
        $this->employeeModel->insert_employee($dataEmployee);
        return redirect('user/index')->with('success', 'Data Added Successfully');
    }

    public function attemptRegister()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        $users = model(UserModel::class);

        // Validate basics first since some password rules rely on these fields
        $rules = config('Validation')->registrationRules ?? [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate passwords since they can only be validated properly here
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user              = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent      = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
        }

        // Success!
        return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
    }
}
