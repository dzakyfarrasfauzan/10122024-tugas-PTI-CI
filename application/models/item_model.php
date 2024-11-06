<?php
class Item_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	// Fungsi untuk insert data ke t_model
	function insert_item($data) {
		return $this->db->insert('t_model', $data);
	}

	// Fungsi untuk menampilkan seluruh data dari t_model
	function select_all() {
		$this->db->select('*');
		$this->db->from('t_model');
		$this->db->order_by('kd_model', 'desc');
		return $this->db->get();
	}

	/**
	 * Fungsi menampilkan data berdasarkan kode model.
	 * Fungsi ini digunakan untuk proses pencarian.
	 */
	function select_by_kode($kd_model) {
		$this->db->select('*');
		$this->db->from('t_model');
		$this->db->like('LOWER(kd_model)', strtolower($kd_model)); // Menghindari SQL Injection
		return $this->db->get();
	}

	// Fungsi menampilkan data berdasarkan ID model
	function select_by_id($kd_model) {
		$this->db->select('*');
		$this->db->from('t_model');
		$this->db->where('kd_model', $kd_model);
		return $this->db->get();
	}

	// Fungsi untuk update data ke t_model
	function update_item($kd_model, $data) {
		$this->db->where('kd_model', $kd_model);
		return $this->db->update('t_model', $data);
	}

	// Fungsi untuk delete data dari t_model
	function delete_item($kd_model) {
		$this->db->where('kd_model', $kd_model);
		return $this->db->delete('t_model');
	}

	// Fungsi untuk menampilkan data dengan pagination
	function select_all_paging($limit = array()) {
		$this->db->select('*');
		$this->db->from('t_model');

		if (!empty($limit)) {
			$this->db->limit($limit['perpage'], $limit['offset']);
		}

		return $this->db->get();
	}

	// Fungsi untuk menghitung jumlah item
	function jumlah_item() {
		$this->db->select('*');
		$this->db->from('t_model');
		return $this->db->count_all_results();
	}

	// Fungsi untuk eksport data
	function eksport_data() {
		$this->db->select('kd_model, nama_model, deskripsi');
		$this->db->from('t_model');
		return $this->db->get();
	}
}
?>
