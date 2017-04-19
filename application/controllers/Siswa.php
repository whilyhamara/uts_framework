<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

	public function index($idKelas)
	{
		$this->load->model('kelas_model');		
		$data["siswa_list"] = $this->kelas_model->getSiswaByKelas($idKelas);
		$this->load->view('siswa', $data);
	}
	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|requireds');
		$this->form_validation->set_rules('tanggalLahir', 'TanggalLahir', 'trim|required');
		$this->load->model('kelas_model');	
		$data["kelas_list"] = $this->kelas_model->getDataKelas();
		$this->load->view('tambah_siswa_view', $data);
		if($this->form_validation->run()==FALSE){

			$config['upload_path']			='./assets/uploads';
			$config['allowed_types']		='gif|jpg|png';
			$config['max_size']				=1000000000;
			$config['max_width']			=10240;
			$config['max_height']			=7680;
			$this->load->library('upload', $config);
			if( ! $this->upload->do_upload('userfile'))
			{
				// $error = array('error' => $this->upload->display_errors());
				// echo "<script> alert('Gambar belum diisi'); 
				// window.location.href='http://localhost/codeigniter_alpha/index.php/pegawai/create';</script>";	
			}
			else
			{
				$this->kelas_model->insertSiswa();
               	redirect('kelas');
			}
		}

	}
	//method update butuh parameter id berapa yang akan di update
	public function update($id)
	{
		//load library
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		//sebelum update data harus ambil data lama yang akan di update
		$this->load->model('kelas_model');
		$data["kelas_list"] = $this->kelas_model->getDataKelas();
		$data["siswa"] = $this->kelas_model->getSiswaId($id);
		//skeleton code
		if($this->form_validation->run()==FALSE){

		//setelah load data dikirim ke view
			$this->load->view('edit_siswa_view',$data);

		}else{
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']  = 1000000;
			$config['max_width']  = 10240;
			$config['max_height']  = 7680;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('userfile')){
				// $error = array('error' => $this->upload->display_errors());
				// var_dump($error);
				$this->kelas_model->updateSiswaTanpaFoto($id);
				$data["siswa_list"] = $this->kelas_model->getDataSiswa();	
				$this->load->view('kelas', $data);
					//$this->load->view('barang_edit_view', $error);
			}
			else{
				$this->kelas_model->updateSiswa($id);
				$data["siswa_list"] = $this->kelas_model->getDataSiswa();	
				$this->load->view('kelas', $data);
			}
			
			//$this->load->view('edit_pegawai_sukses');

		}
	}

	
		

	public function delete($id)
	{
		//$where=array('id'=>$id);
		//$this->load->model('pegawai_model');

		//$this->load->model('pegawai_model');
		//$data['pegawai']=$this->pegawai_model->getPegawai($id);
		//$namaFile = $data['pegawai']->foto;
		//unlink('assets/uploads/'.$namaFile);

		//$this->pegawai_model->deleteById($id);
		//redirect('pegawai/datatable','refresh');
		$this->load->model('kelas_model');
		$path= './assets/uploads/';
		$where = array('id' => $id);
		$rowdel = $this->kelas_model->get_byimage($where,'siswa');
		@unlink($path.$rowdel->foto);

		$this->kelas_model->m_delete($where,'siswa');
		redirect('kelas', 'refresh');
	}

}

/* End of file Jabatan.php */
/* Location: ./application/controllers/Jabatan.php */

 ?>