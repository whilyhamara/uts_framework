<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_Model extends CI_Model {

		public function __construct()
		{
			parent::__construct();
			//Do your magic here
		}	

		public function getDataKelas()
		{
			$this->db->select("id,nama");
			$query = $this->db->get('kelas');
			return $query->result();
		}
		public function getDataSiswa()
		{
			$this->db->select("id,nama,DATE_FORMAT(tanggal_lahir,'%d-%m-%Y') as tanggal_lahir, foto, fk_kelas");
			$query = $this->db->get('siswa');
			return $query->result();
		}
		public function getSiswaId($id)
		{
			$this->db->where('id', $id);	
			$query = $this->db->get('siswa',1);
			return $query->result();
		}

		public function getSiswaByKelas($idKelas)
		{
			$this->db->select("kelas.nama as namaKelas, siswa.id, siswa.nama as namaSiswa, DATE_FORMAT(tanggal_lahir,'%d-%m-%Y') as tanggal_lahir, foto");
			$this->db->where('fk_kelas', $idKelas);	
			$this->db->join('kelas', 'kelas.id = siswa.fk_kelas', 'left');	
			$query = $this->db->get('siswa');
			return $query->result();
		}

		public function insertKelas()
		{
			$insert_kelas = array(
				'nama' => $this->input->post('nama'),
			);

			$this->db->insert('kelas', $insert_kelas);

		}
		public function insertSiswa()
		{
			$insert_siswa = array(
				'nama' => $this->input->post('nama'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'foto' => $this->upload->data('file_name'),
				'fk_kelas' => $this->input->post('fk_kelas')
			);

			$this->db->insert('siswa', $insert_siswa);

		}

		public function getJumlahSiswa()
		{
			$query=$this->db->query("SELECT COUNT(id) FROM `siswa` WHERE fk_kelas=1");
			return $query->result_array();
			
		}

		public function getKelas($id)
		{
			$this->db->where('id', $id);	
			$query = $this->db->get('kelas',1);
			return $query->result();

		}

		public function getSiswa($id)
		{
			$this->db->where('id', $id);	
			$query = $this->db->get('siswa',1);
			return $query->result();

		}


		public function updateById($id)
		{
			$data = array('nama' => $this->input->post('nama')
							 );
			$this->db->where('id', $id);
			$this->db->update('kelas', $data);
		}

		public function updateSiswaById($id)
		{
			$data = array('nama' => $this->input->post('nama'),
							'tanggalLahir' =>$this->input->post('tanggalLahir'),
							'foto' => $this->upload->data('file_name'),
							'fk_kelas' => $this->input->post('fk_kelas')
							 );
			$this->db->where('id', $id);
			$this->db->update('pegawai', $data);
		}

    	public function updateSiswa($id)
		{
			$data = array('nama' => $this->input->post('nama'), 
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'foto' => $this->upload->data('file_name'));
			$this->db->where('id', $id);
			$this->db->update('siswa', $data);
		}
		public function updateSiswaTanpaFoto($id)
		{
			$data = array('nama' => $this->input->post('nama'), 
			'tanggal_lahir' => $this->input->post('tanggal_lahir')
			);
			$this->db->where('id', $id);
			$this->db->update('siswa', $data);
		}

		function get_byimage($where,$table) {
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
 
	        if ($query->num_rows() == 1) {
	            return $query->row();
	        }
    	}
  
		public function deleteById($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('kelas');
		}

		public function m_delete($where,$table)
    	{
	        $this->db->where($where);
			$this->db->delete($table);
	    }
}

/* End of file Pegawai_Model.php */
/* Location: ./application/models/Pegawai_Model.php */
 ?>