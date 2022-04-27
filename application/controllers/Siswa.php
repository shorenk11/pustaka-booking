<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{

public function __construct()
	{
		parent::__construct();
		$this->load->model("Siswa_model"); //load model siswa
	}


	//method pertama yang akan di eksekusi
	public function index()
	{
		$data["title"] = "List Data Siswa";

		//ambil fungsi getAll untuk menampilkan semua data siswa
		$data["data_siswa"] = $this->Siswa_model->getAll();

		//load view header.php pada folder views/templates
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');

		//load view header.php pada folder views/siswa
		$this->load->view('siswa/index', $data);
		$this->load->view('templates/footer');
	}

	//method add digunakan untuk menampilkan form tambah data Siswa
	public function add()
	{
	$Siswa = $this->Siswa_model; //objek model
	$validation = $this->form_validation; //objek form validation
	$validation->set_rules($Siswa->rules()); //menerapkan rules validasi pada Siswa_model

	//kondisi jika semua kolom telah divalidasi, maka akan menjalankan method save pada siswa_model
	if ($validation->run())
	{
		$Siswa->save();
		$this->session->set_flashdata('message', '<div class="alert-success alert-dismissible fade show" role="alert">Data Siswa berhasil disimpan.
			<button type="button" class="close" data-dismiss="alert" aria-label="close"
			<span aria-hiden="true">$times;</span>
			<button></div>');
			redirect("siswa");
	}
	$data["title"] = "Tambah Data Siswa";
	$this->load->view('templates/header', $data);
	$this->load->view('templates/menu', $data);
	$this->load->view('siswa/add', $data);
	$this->load->view('templates/footer', $data);
	}

	public function edit($id = null)
	{
		if (!isset($edit)) redirect('siswa');

		$Siswa = $this->Siswa_model;
		$validation = $this->form_validation;
		$validation->set_rules($Siswa->rules());

		if ($validation->run()) 
		{
			$Siswa->update();
			$this->session->set_flashdata('message', '<div class="alert" aria-label="close">
			<span aria-hiden="true">$times;</span>
			</button></div>');
			redirect("siswa");
		}
		$data["title"] = "Edit Data Siswa";
		$data["data_siswa"] = $Siswa->getById($id);
		if (!$data["data_siswa"]) show_404();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		$this->load->view('siswa/edit', $data);
		$this->load->view('templates/footer', $data);
	}

	public function delete()
	{
		$id = $this->input->get('id');
		if (!isset($id)) show_404();
		$this->Siswa_model->delete($id);
		$msg['succes'] = true;
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Siswa berhasil dihapus.
			<button type="button" class="close" data-dismiss="alert" aria-label="close">
			<span aria-hiden="true">&times;</span>
			</button></div>');
		$this->output->set_output(json_encode($msg));
	}

}