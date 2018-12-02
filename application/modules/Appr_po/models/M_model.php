<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
class M_model extends CI_Model
{
	private $table = "tm_supplier";
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
    function getData($table,$where){
        $query = $this->db->where($where)->get($table);
        if($query->num_rows()>0)
        { return $query->row();}
        else{return null;}
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
        $query = $this->db->where(array("fc_status" => "F","fc_approve" => "0"))->get($tabel);
        return $query->num_rows();  
    } 
    function allposts($tabel,$limit,$start,$col,$dir)
    {   
       $query = $this->db->where(array("fc_status" => "F","fc_approve" => "0"))->limit($limit,$start)->order_by($col,$dir)->get($tabel);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_search($tabel,$field1,$field2,$limit,$start,$search,$col,$dir)
    {
        $query = $this->db->where(array("fc_status" => "F","fc_approve" => "0"))
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
    function posts_search_count($tabel,$field1,$field2,$search)
    {   $query = $this->db->where(array("fc_status" => "F","fc_approve" => "0"))
        				 ->group_start()->like($field1,$search)->or_like($field2,$search)->group_end()->get($tabel);
        return $query->num_rows();  }

        //ini khusus untuk datatable detail
    function allposts_count_Detail($nopo)
    {   
        $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_nopo='".$nopo."'");
        return $query->num_rows();  
    } 
    function allposts_Detail($limit,$start,$nopo)
    {   
    $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_nopo='".$nopo."' order by fc_id asc limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_search_Detail($limit,$start,$search,$nopo)
    {
    $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_nopo='".$nopo."' and(a.fc_stock like '%".$search."%' or b.fv_stock like '%".$search."%') order by fc_id asc limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result(); }
        else { return null; }
    } 
    function posts_search_count_Detail($search,$nopo)
    {   
        $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_nopo='".$nopo."' and(a.fc_stock like '%".$search."%' or b.fv_stock like '%".$search."%')");
        return $query->num_rows();  
    }

    function allposts_count_Item($tabel,$where = "")
    {   
        if (!empty($where)) {
            $query = $this->db->where($where)->get($tabel);
        }else{
            $query = $this->db->get($tabel);
        }
        return $query->num_rows();  
    } 
    function allposts_Item($tabel,$limit,$start,$col,$dir,$where = "")
    {   
        if(!empty($where)){
            $query = $this->db->where($where)->limit($limit,$start)->order_by($col,$dir)->get($tabel);
        }else{
            $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get($tabel);
        }
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_search_Item($tabel,$field1,$field2,$limit,$start,$search,$col,$dir,$where = "")
    {
        if (!empty($where)) {
            $query = $this->db->where($where)
                         ->group_start()
                             ->like($field1,$search)
                             ->or_like($field2,$search)
                         ->group_end()
                         ->limit($limit,$start)
                         ->order_by($col,$dir)->get($tabel);
        }else{
            $query = $this->db->like($field1,$search)
                         ->or_like($field2,$search)
                         ->limit($limit,$start)
                         ->order_by($col,$dir)->get($tabel);
        }
        if($query->num_rows()>0)
        { return $query->result(); }
        else { return null; }
    } 
    function posts_search_count_Item($tabel,$field1,$field2,$search,$where = "")
    {   
        if (!empty($where)) {
            $query = $this->db->where($where)
                         ->group_start()
                             ->like($field1,$search)
                             ->or_like($field2,$search)
                         ->group_end()
                         ->limit($limit,$start)
                         ->order_by($col,$dir)->get($tabel);
        }else{
            $query = $this->db->like($field1,$search)
                         ->or_like($field2,$search)
                         ->limit($limit,$start)
                         ->order_by($col,$dir)->get($tabel);
        }
        return $query->num_rows(); 
    }
}