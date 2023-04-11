<?php

namespace App\Controllers;

class Employee extends BaseController
{

    protected $db, $builder, $employeeModel, $divisiModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('employee');
        $this->employeeModel = new \App\Models\M_Employee();
        $this->divisiModel = new \App\Models\M_Divisi();
    }
    public function index()
    {
        $data['title']  = 'Employee List';


        $employee = $this->employeeModel->list();

        $data['users'] = $employee;

        return view('admin/employee', $data);
    }

    public function detail($id = 0)
    {
        $data['title']  = 'Employee Details';

        $this->builder->select('employee.id as employeeid, id_employee, img, email, name, position, degree, address, no_tlp, birth_date, birth_place, gender, religion, divisi');
        $this->builder->where('employee.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();
        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail_employee', $data);
    }

    public function add_employee()
    {
        $data = [
            'title' => 'Add Employee',
        ];
        $divisi = $this->divisiModel->list();
        $data['divisi'] = $divisi;

        helper('form');

        if (!$this->request->is('post')) {
            return view('admin/add_employee', $data);
        }

        $post = $this->request->getPost(['id_employee', 'name', 'email', 'birth_place', 'birth_date', 'no_tlp', 'address', 'gender', 'religion', 'degree', 'divisi', 'position']);

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
            'divisi'        => $post['degree'],
            'position'      => $post['position'],
        ];
        $this->employeeModel->insert_employee($dataEmployee);
        return redirect('admin/employee')->with('success', 'Data Added Successfully');
    }

    public function delete($id)
    {
        $this->employeeModel->deleteEmployee($id);
        return redirect('admin/employee');
    }

    public function edit_employee($id)
    {
        $this->employeeModel->editEmployee($id);
        return redirect('admin/employee');
    }
}
