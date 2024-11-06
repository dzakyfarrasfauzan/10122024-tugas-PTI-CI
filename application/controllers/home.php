<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load model
		$this->load->model("Item_model");
		$this->load->model('usermodel');
	}

	// Default controller
	public function index()
	{
		// Apakah user sudah login?
		if ($this->auth->is_logged_in() == false) {
			// Jika belum, arahkan ke form login
			$this->signin();
		} else {
			// Jika sudah, tampilkan halaman web sesuai hak akses
			$this->menu->tampil_sidebar();

			// Untuk kebutuhan widget di dashboard
			$data['user1'] = $this->usermodel->select_all(1);
			$data['user2'] = $this->usermodel->select_all(2);
			$data['products'] = $this->Item_model->select_all()->result();
			$data['chart'] = [
				'label' => [],
				'data'  => [],
			];

			// Menyiapkan data chart jika produk tersedia
			if ($data['products']) {
				foreach ($data['products'] as $product) {
					$data['chart']['label'][] = $product->nama_model;
					$data['chart']['data'][] = $product->jml_produk;
				}
			}

			// Tampilkan halaman utama dengan data yang sudah disiapkan
			$this->load->view('main_page', $data);
		}
	}

	// Halaman login form
	public function signin()
	{
		$this->load->view('login_form');
	}

	// Proses login
	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$success = $this->auth->do_login($username, $password);

		if ($success) {
			// Jika login berhasil, arahkan ke halaman dashboard
			redirect(site_url('dashboard'));
		} else {
			// Jika login gagal, tampilkan pesan error
			$data['login_info'] = "Username atau password salah. Silahkan masukkan kombinasi yang benar!";
			$this->load->view('login_form', $data);
		}
	}

	// Proses logout
	public function logout()
	{
		if ($this->auth->is_logged_in() == true) {
			// Jika user sudah login, lakukan logout dan hancurkan session
			$this->auth->do_logout();
		}

		// Arahkan ke halaman utama (login page)
		redirect('login');
	}
}
