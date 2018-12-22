<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
class M_model extends CI_Model
{
    // for default table
    var $table = 'v_bpbnon';
    var $column_order = array(null,'fv_wh','fd_bpb','fv_supplier','fn_jenis','fn_qty','fm_total','fc_userid'); //set column field database for datatable defaultOrder
    var $column_search = array('fv_wh','fd_bpb','fv_supplier','fc_userid'); //set column field database for datatable searchable 
    var $order = array('fd_bpb' => 'desc'); // default order 

// ---------------------------------------------------------------------
    private function _get_datatables_query()
    {     
        //add custom filter here
        if($this->session->userdata('branch'))
        {
            $this->db->where('fc_branch', $this->session->userdata('branch'));
        }
        if($this->session->userdata('userid'))
        {
            $this->db->like('fc_userid', $this->session->userdata('userid'));
        }
        $this->db->from($this->table); // default
        
        $i = 0;  // for table numbering
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($tableName = '', $columnOrder = array(), $columnSearch = array(), $defaultOrder = array('fc_id' => 'asc'))
    {
        ($tableName == '') ? $this->_get_datatables_query() : $this->_get_datatables_custom_query($tableName,$columnOrder,$columnSearch,$defaultOrder);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($tableName = '', $columnOrder = array(), $columnSearch = array(), $defaultOrder = array('fc_id' => 'asc'))
    {
        if($tableName == '') 
        { 
            $this->_get_datatables_query();
            $query = $this->db->get();
        } else 
        {            
            $this->_get_datatables_custom_query( $tableName, $columnOrder, $columnSearch, $defaultOrder);
            $query = $this->db->get( $table_name );
        }     
        return $query->num_rows();
    }

    /**
     * count_all
     *
     * @param  mixed $table_name
     *
     * @return void
     */
    public function count_all($table_name='')
    {
        if($table_name == '') 
        { 
            $this->db->from($this->table); 
        } else 
        {
            $this->db->from( $table_name ); 
        } 
        return $this->db->count_all_results();
    }
    
    // === custom function for another table === //

    /**
     * @table_name (string)    nama tabel 
    * @columnOrder (array)   list kolom yang ingin bisa di urutkan (defaultOrder)
    * @columnSearch (array)  list kolom yang ingin bisa di cari (searchable)
    * @defaultOrder (array)          kolom yang dijadikan standar pengurutan (default order)
    */
    private function _get_datatables_custom_query($table_name = '', $columnOrder = array(), $columnSearch = array(), $defaultOrder = array('fc_id' => 'asc'))
    {     
        //add custom filter here as many as needed but don't forget every table has different filter
        if($this->input->post('f_bpbno'))
        {
            $this->db->where('fc_nobpb', $this->input->post('f_bpbno'));
        }
        
        $this->db->from( $table_name ); 
        
        $i = 0;  // for table numbering
        foreach ($columnSearch as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($columnSearch) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($columnOrder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($defaultOrder))
        {
            $this->db->order_by(key($defaultOrder), $defaultOrder[key($defaultOrder)]);
        }
    }
// ---------------------------------------------------------------------    
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
	//update data
	function update($table,$data,$where){
		$query = $this->db->update($table,$data,$where);
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
    function checkMst($where){
    	$query = $this->db->where($where)->get("tm_bpbnon");
    	return $query->num_rows();
    }
    //chek bpb sudah ada belum
    function checkBPB($nobpb){
    	$query = $this->db->where(array("fc_nobpb" => $nobpb))->get("tm_bpbnon");
    	return $query->num_rows();
    }	
    //function untuk melihat detail
    function getDetail($table,$where){
        $data = $this->db->where($where)->get($table);
        return $data->result();
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