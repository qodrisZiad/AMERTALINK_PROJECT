<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
class M_model extends CI_Model
{
	private $table = "v_POMST";
	function tambah($table,$data){
		$this->db->insert($table,$data);
		return $this->db->affected_rows();
	}
	//delete data
	function hapus($table,$where){
		$this->db->where($where);
		$this->db->delete($table,$where);
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

    //ambil data masternya
    function getMaster($where){
    	$query = $this->db->select("*,ifnull((select fn_ongkir from tm_bpb where fc_nopo= v_POMST.fc_nopo),0) as ongkir")->from("v_POMST")->where($where)->get();
    	return $query->row();
    }

    //chek bpb sudah ada belum
    function checkBPB($nobpb){
    	$query = $this->db->where(array("fc_nobpb" => $nobpb))->get("tm_bpb");
    	return $query->num_rows();
    }	
    //function untuk melihat detail
    function getDetail($table,$where){
        $data = $this->db->where($where)->get($table);
        return $data->result();
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
        $query = $this->db->where(array("fc_approve" => "1","fc_print" => "1"))
                            ->where_in("fc_sts_bpb",array("B","S"))
                            ->get($tabel);
        return $query->num_rows();  
    } 
    function allposts($tabel,$limit,$start,$col,$dir)
    {   
       $query = $this->db->where(array("fc_approve" => "1","fc_print" => "1"))
                        ->where_in("fc_sts_bpb",array("B","S"))
                        ->limit($limit,$start)->order_by($col,$dir)->get($tabel);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_search($tabel,$field1,$field2,$limit,$start,$search,$col,$dir)
    {
        $query = $this->db->where(array("fc_approve" => "1","fc_print" => "1"))
                         ->where_in("fc_sts_bpb",array("B","S"))
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
    {   $query = $this->db->where(array("fc_approve" => "1","fc_print" => "1"))->like($field1,$search)->or_like($field2,$search)->get($tabel);
        return $query->num_rows();  }

        //ini khusus untuk datatablenya
    function allposts_countDetail($nota)
    {   
        $query = $this->db->query("select ifnull(c.fc_id,a.fc_id) as fc_id,a.fc_stock,a.fv_stock,a.variant,a.fv_satuan,concat('Rp.',IFNULL(c.fn_price,a.price)) as fn_price,a.fn_qty,ifnull(c.fn_qty,0) as fn_terima,concat('Rp.',IFNULL(c.fn_total,a.total)) as fn_total,a.fv_ket from v_detailPO a LEFT OUTER JOIN tm_bpb b ON b.fc_nopo=a.fc_nopo LEFT OUTER JOIN td_bpb c ON c.fc_nobpb=b.fc_nobpb and c.fc_stock=a.fc_stock and c.fc_variant=a.fc_variant  WHERE  a.fc_nopo='".$nota."'");
        return $query->num_rows();  
    } 
    function allpostsDetail($nota,$limit,$start,$col,$dir)
    {   
       $query = $this->db->query("select ifnull(c.fc_id ,a.fc_id) as fc_id,a.fc_stock,a.fv_stock,a.variant,a.fv_satuan,concat('Rp.',IFNULL(c.fn_price,a.price)) as fn_price,a.fn_qty,ifnull(c.fn_qty,0) as fn_terima,concat('Rp.',IFNULL(c.fn_total,a.total)) as fn_total,a.fv_ket from v_detailPO a LEFT OUTER JOIN tm_bpb b ON b.fc_nopo=a.fc_nopo LEFT OUTER JOIN td_bpb c ON c.fc_nobpb=b.fc_nobpb and c.fc_stock=a.fc_stock and c.fc_variant=a.fc_variant  WHERE a.fc_nopo='".$nota."' order by a.fc_id asc limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_searchDetail($nota,$field1,$field2,$limit,$start,$search,$col,$dir)
    {
        $query = $this->db->query("select ifnull(c.fc_id,a.fc_id) as fc_id,a.fc_stock,a.fv_stock,a.variant,a.fv_satuan,concat('Rp.',IFNULL(c.fn_price,a.price)) as fn_price,a.fn_qty,ifnull(c.fn_qty,0) as fn_terima,concat('Rp.',IFNULL(c.fn_total,a.total)) as fn_total,a.fv_ket from v_detailPO a LEFT OUTER JOIN tm_bpb b ON b.fc_nopo=a.fc_nopo LEFT OUTER JOIN td_bpb c ON c.fc_nobpb=b.fc_nobpb and c.fc_stock=a.fc_stock and c.fc_variant=a.fc_variant WHERE a.fc_nopo='".$nota."' and (a.fc_stock like '".$search."' or fv_stock like '".$search."') order by a.fc_id asc limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result(); }
        else { return null; }
    } 
    function posts_search_countDetail($nota,$field1,$field2,$search)
    {   $query = $this->db->query("select ifnull(c.fc_id,a.fc_id) as fc_id,a.fc_stock,a.fv_stock,a.variant,a.fv_satuan,concat('Rp.',IFNULL(c.fn_price,a.price)) as fn_price,a.fn_qty,ifnull(c.fn_qty,0) as fn_terima,concat('Rp.',IFNULL(c.fn_total,a.total)) as fn_total,a.fv_ket from v_detailPO a LEFT OUTER JOIN tm_bpb b ON b.fc_nopo=a.fc_nopo LEFT OUTER JOIN td_bpb c ON c.fc_nobpb=b.fc_nobpb and c.fc_stock=a.fc_stock and c.fc_variant=a.fc_variant  WHERE a.fc_nopo='".$nota."' and (a.fc_stock like '".$search."' or fv_stock like '".$search."') order by a.fc_id asc");
        return $query->num_rows();  
    }
    function getdetailPO($kode){
    	$query = $this->db->query("select ifnull(c.fc_id,a.fc_id) as fc_id,a.fc_stock,a.fv_stock,a.variant,a.fv_satuan,concat('Rp.',IFNULL(c.fn_price,a.price)) as fn_price,a.fn_qty,ifnull(c.fn_qty,0) as fn_terima,concat('Rp.',IFNULL(c.fn_total,a.total)) as fn_total,a.fv_ket,a.fc_variant,a.fc_satuan from v_detailPO a LEFT OUTER JOIN tm_bpb b ON b.fc_nopo=a.fc_nopo LEFT OUTER JOIN td_bpb c ON c.fc_nobpb=b.fc_nobpb and c.fc_stock=a.fc_stock and c.fc_variant=a.fc_variant  WHERE a.fc_id='".$kode."'");
    	return $query->row();
    }
    function finalisasi($no_po){
        $query = $this->db->query("update tm_bpb set fc_status = 'F' 
        where fc_nobpb ='".$this->session->userdata('userid')."' and fc_nopo='".$no_po."'");
        $getNomor = $this->db->query("select final_bpb('".$this->session->userdata('userid')."') as no_bpb");
        return $getNomor->result();
    }
}