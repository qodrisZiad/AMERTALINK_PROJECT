<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
class M_model extends CI_Model
{
	private $table = "tm_karyawan";
	function tambah($table,$data){
		$this->db->insert($table,$data);
		return $this->db->affected_rows();
	}
	//delete data
	function hapus($table,$where){
		$this->db->where($where);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}
// ---------------------------------------------------------------------
    //ambil data
    function getData($tabel,$where){
        $query = $this->db->where($where)->get($tabel);
        if($query->num_rows()>0)
        { return $query->row();}
        else{return null;}
    } 
    function data($where){
        $query = $this->db->where($where)->get($this->table);
        return $query->result();
    }
// ---------------------------------------------------------------------
	//update data
	function update($table,$data,$where){
		$query = $this->db->update($table,$data,$where);
		return $this->db->affected_rows();
	}
	//ini khusus untuk datatablenya
    function allposts_count($tabel)
    {   $query_select = "SELECT 
        a.fc_branch,a.fc_nik,a.fv_sname,a.fv_lname,
        CASE 
        WHEN fc_sex = 'L' THEN 'LAKI-LAKI'
        WHEN fc_sex = 'P' THEN 'PEREMPUAN' 
        END as sex,
        fc_ktp,fv_tmp_lahir,DATE_FORMAT(fd_lahir,'%d-%m-%Y') as fd_lahir
        ,fc_hp,fc_hp2,fv_addr_ktp,fv_addr,DATE_FORMAT(fd_masuk,'%d-%m-%Y') as fd_masuk,
        b.fv_jabatan,fv_pict,a.fc_status
        FROM tm_karyawan a
        LEFT JOIN tm_jabatan b ON b.fc_jabatan=a.fc_jabatan";
        $query = $this->db->query($query_select);
        return $query->num_rows();  
    } 
    function allposts($tabel,$limit,$start,$col,$dir)
    {   
       $query = $this->db->select("a.fc_branch,a.fc_nik,a.fv_sname,a.fv_lname,
        CASE 
        WHEN fc_sex = 'L' THEN 'LAKI-LAKI'
        WHEN fc_sex = 'P' THEN 'PEREMPUAN' 
        END as sex,
        fc_ktp,fv_tmp_lahir,DATE_FORMAT(fd_lahir,'%d-%m-%Y') as fd_lahir
        ,fc_hp,fc_hp2,fv_addr_ktp,fv_addr,DATE_FORMAT(fd_masuk,'%d-%m-%Y') as fd_masuk,
        b.fv_jabatan,fv_pict,a.fc_status")
       ->from('tm_karyawan a')
       ->join('tm_jabatan b','b.fc_jabatan=a.fc_jabatan')
        ->limit($limit,$start)
        ->order_by($col,$dir)
        ->get();
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_search($tabel,$field1,$field2,$limit,$start,$search,$col,$dir)
    {
        $query = $this->db->like($field1,$search)
                         ->or_like($field2,$search)
                         ->limit($limit,$start)
                         ->order_by($col,$dir)->get($tabel);
        if($query->num_rows()>0)
        { return $query->result(); }
        else { return null; }
    } 
    function posts_search_count($tabel,$field1,$field2,$search)
    {   
    	$query = $this->db->like($field1,$search)->or_like($field2,$search)->get($tabel);
        return $query->num_rows();  
    } 
    function getJabatan(){
        $query = $this->db->where(array('fc_status' => '1'))->get('tm_jabatan');
        return $query->result();
    }
    function getBranch(){
        $query = $this->db->where(array('fc_status' => '1'))->get('tm_branch');
        return $query->result();
    }
}