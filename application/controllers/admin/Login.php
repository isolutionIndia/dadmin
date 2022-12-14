<?php
//

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ('0' == $this->session->userdata('role')) {
			redirect('super/dashboard');
		}
	}
	public function index()
	{

		$this->form_validation->set_rules('usrnme', 'Email id', 'required');
		$this->form_validation->set_rules('psswd', 'Password', 'required');
		if ($this->form_validation->run()) {
			$email = $this->input->post('usrnme');
			$password = $this->input->post('psswd');
			$this->load->model('login_model');
			$validate = $this->login_model->index($email, $password);
			if ($validate) {
				$this->session->set_userdata('role', 'admin');
				$this->session->set_userdata('name', $email);
				$data['validate'] = $validate;
				$this->load->view('dashboard', $data);
			} else {
				$this->session->set_flashdata('error', 'Invalid login details.Please try again.');
				//print_r($validate);
				redirect('welcome');
			}
		} else {
			redirect('welcome');
		}
	}
}
