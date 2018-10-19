<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
class M_model extends CI_Model
{
	private $table = "v_stock";
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
    //update data
    function update($tabel,$data,$where){
        $query = $this->db->update($tabel,$data,$where);
        return $this->db->affected_rows();
    }
    function getThumbnail($stockcode){
        $query = $this->db->query("select a.*,b.fv_warna from t_thumbnail a LEFT JOIN tm_warna b ON b.fc_warna=a.fc_warna WHERE a.fc_stock='".$stockcode."'");
        return $query->result();
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

    function getProperti(){
    	$query = $this->db->where(array('fc_status' => '1'))->get('tm_prop');
    	return $query->result();
    }

    function getSubProp($where){
    	extract($where);
    	$query = $this->db->query("select * from td_prop WHERE fc_kdprop = '".$fc_kdprop."' and fc_kategori = (select fc_kategori from t_stock WHERE fc_stock='".$fc_stock."') and fc_status='1'");
    	return $query->result();
    }
    function checkProp($tabel,$where_check){
    	$query = $this->db->where($where_check)->get($tabel);
    	return $query->num_rows();
    } 
    function getUkuran(){
    	$query = $this->db->where(array('fc_status' => '1'))->get('tm_size');
    	return $query->result();
    }
    function getWarna(){
    	$query = $this->db->where(array('fc_status' => '1'))->get('tm_warna');
    	return $query->result();
    }
    function getSatuan(){
    	$query = $this->db->where(array('fc_status' => '1'))->get("tm_satuan");
    	return $query->result();
    }
    function updateDefault($stock,$satuan,$sts){
    	$query = $this->db->query("update t_uom set fc_default='".$sts."' where fc_stock = '".$stock."' and fc_satuan = '".$satuan."'");
    }
    
    function getWarnaProduk($stockcode){
    	$query = $this->db->query("select * from tm_warna WHERE fc_warna in(select fc_warna from t_variant WHERE fc_stock='".$stockcode."' and fc_warna not in(select fc_warna from t_thumbnail where fc_stock = '".$stockcode."') group by fc_warna)");
    	return $query->result();
    } 
// --------------------------------------------------------------------- 
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

    //jika ada where nya
        //ini khusus untuk datatablenya
    function allposts_countWhere($tabel,$where)
    {   
        $query = $this->db->where($where)->get($tabel);
        return $query->num_rows();  
    } 
    function allpostsWhere($tabel,$limit,$start,$col,$dir,$where)
    {   
       $query = $this->db->where($where)->limit($limit,$start)->order_by($col,$dir)->get($tabel);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_searchWhere($tabel,$field1,$field2,$limit,$start,$search,$col,$dir,$where)
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
    function posts_search_countWhere($tabel,$field1,$field2,$search,$where)
    {   $query = $this->db->where($where)->group_start()->like($field1,$search)->or_like($field2,$search)->group_end()->get($tabel);
        return $query->num_rows();  }
}