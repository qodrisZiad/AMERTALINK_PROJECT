<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
class M_model extends CI_Model
{
	private $table = "tm_prop";
	function tambah($tabel,$data){
		$this->db->insert($tabel,$data);
		return $this->db->affected_rows();
	}
	//delete data
	function hapus($tabel,$where){
		$this->db->where($where);
		$this->db->delete($tabel);
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
    function getKategori(){
    	$query = $this->db->where(array('fc_status' => '1'))->get('tm_kategori');
    	return $query->result();
    }

    function getSubkategori($where){
    	$query = $this->db->where($where)->get('tm_subkategori');
    	return $query->result();
    }
    function getSubSubkategori($where){
    	$query = $this->db->where($where)->get('tm_subsubkategori');
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
    {   
        $query = $this->db->get($tabel);
        return $query->num_rows();  
    } 
    function allposts($tabel,$limit,$start,$col,$dir)
    {   
       $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get($tabel);
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
    {   $query = $this->db->like($field1,$search)->or_like($field2,$search)->get($tabel);
        return $query->num_rows();  }

    function allposts_countDetail($tabel,$where)
    {   
        $query = $this->db->where($where)->get($tabel);
        return $query->num_rows();  
    } 
    function allpostsDetail($tabel,$where,$limit,$start,$col,$dir)
    {   
       $query = $this->db->where($where)->limit($limit,$start)->order_by($col,$dir)->get($tabel);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_searchDetail($tabel,$where,$field1,$field2,$limit,$start,$search,$col,$dir)
    {
        $query = $this->db->where($where)
        				 ->group_start()
	        				 ->like($field1,$search)
	                         ->or_like($field2,$search)
	                     ->group_end()
                         ->limit($limit,$start)
                         ->order_by($col,$dir)->get($tabel);
        if($query->num_rows()>0)
        { return $query->result(); }
        else { return null; }
    } 
    function posts_search_countDetail($tabel,$where,$field1,$field2,$search)
    {   $query = $this->db->where($where)
    					->group_start()
	    					->like($field1,$search)
	    					->or_like($field2,$search)
	    				->group_end()
    					->get($tabel);
        return $query->num_rows();  }
}