<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	public function index()
	{
		$this->load->model('kelas_model');
		$data["kelas_list"] = $this->kelas_model->getDataKelas();
		$anjay["jumlah"] = $this->kelas_model->getJumlahSiswa();
		$this->load->view('kelas',$data, $anjay);	
	}

	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[2]|max_length[30]');
		$this->load->model('kelas_model');	
		if($this->form_validation->run()==FALSE){

			$this->load->view('tambah_kelas_view');

		}
		else
		{
			$this->kelas_model->insertKelas();
           	redirect('kelas');
		}
	}
	//method update butuh parameter id berapa yang akan di update
	public function update($id)
	{
		$this->load->helper('url','form', 'file');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		
		$this->load->model('kelas_model');
		$data['kelas']=$this->kelas_model->getKelas($id);
		
		if($this->form_validation->run()==FALSE){
			$this->load->view('edit_kelas_view',$data);
		}
		else
		{
			$this->kelas_model->updateById($id);
			redirect('kelas');
                
		}
	}

	public function delete($id)
	{
		$this->load->model('kelas_model');
		$this->kelas_model->deleteById($id);
		redirect('kelas', 'refresh');
	}
}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */

 ?>