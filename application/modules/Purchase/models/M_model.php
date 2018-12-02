<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
class M_model extends CI_Model
{
	private $table = "tm_po";
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
    function getTrxerror($where){
        $no_Trx = "";
        $data = $this->db->where($where)->get("t_trxDummy");
        foreach ($data->result() as $key) {
            $no_Trx = $key->fv_keterangan." ".$key->fc_trxNO;
        }
        return $no_Trx;
    }
// ---------------------------------------------------------------------
    //ambil data
    function getData($tabel,$where){
        $query = $this->db->where($where)->get($tabel);
        if($query->num_rows()>0)
        { return $query->row();}
        else{return null;}
    }   
// ---------------------------------------------------------------------
// ---------------------------------------------------------------------
// check master sudah ada belum
    function checkMst($where){
    	$query = $this->db->where($where)->get("tm_po");
    	return $query->num_rows();
    }
// ---------------------------------------------------------------------
    //getadata detail po
    function getDetail($table,$where){
        $data = $this->db->where($where)->get($table);
        return $data->result();
    }
	//update data
	function update($tabel,$data,$where){
		$query = $this->db->update($tabel,$data,$where);
		return $this->db->affected_rows();
	}
	//ini khusus untuk datatable produk
    function allposts_count($tabel,$where = "")
    {   
        if (!empty($where)) {
            $query = $this->db->where($where)->get($tabel);
        }else{
            $query = $this->db->get($tabel);
        }
        return $query->num_rows();  
    } 
    function allposts($tabel,$limit,$start,$col,$dir,$where = "")
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
    function posts_search($tabel,$field1,$field2,$limit,$start,$search,$col,$dir,$where = "")
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
    function posts_search_count($tabel,$field1,$field2,$search,$where = "")
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

    //ini khusus untuk datatable detail
    function allposts_count_Detail()
    {   
        $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_branch='".$this->session->userdata('branch')."' and a.fc_nopo='".$this->session->userdata('userid')."'");
        return $query->num_rows();  
    } 
    function allposts_Detail($limit,$start)
    {   
    $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_branch='".$this->session->userdata('branch')."' and a.fc_nopo='".$this->session->userdata('userid')."' order by fc_id asc limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_search_Detail($limit,$start,$search)
    {
    $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_branch='".$this->session->userdata('branch')."' and a.fc_nopo='".$this->session->userdata('userid')."' and(a.fc_stock like '%".$search."%' or b.fv_stock like '%".$search."%') order by fc_id asc limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result(); }
        else { return null; }
    } 
    function posts_search_count_Detail($search)
    {   
        $query = $this->db->query("select a.fc_id,a.fc_branch,a.fc_nopo,a.fc_stock,b.fv_stock,CONCAT(b.fv_size,' | ',b.fv_warna) as variant,c.fv_satuan,rupiah(a.fn_price) as price,a.fn_qty,c.fn_uom,(a.fn_qty * c.fn_uom) as konversi,rupiah(a.fn_total) as total from td_po a LEFT OUTER JOIN v_variant b ON b.fc_stock=a.fc_stock AND b.fc_variant=a.fc_variant LEFT OUTER JOIN v_uom c ON c.fc_uom=a.fc_satuan WHERE a.fc_branch='".$this->session->userdata('branch')."' and a.fc_nopo='".$this->session->userdata('userid')."' and(a.fc_stock like '%".$search."%' or b.fv_stock like '%".$search."%')");
        return $query->num_rows();  
    }

    } 
