<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
 class M_model extends CI_Model {
  
    /*
    * fieldnya
    'fc_id','fc_branch','fc_wh','fd_tgl','fc_stock','fv_stock',
	'fc_variant','fv_variant','fc_size','fv_size','fc_warna',
	'fv_warna','fn_in','fn_out','fn_sisa','fc_referensi',
    'fc_ket','fn_hargajual','fn_hargabeli','fc_useri'
    */
     var $table = 'v_printBPB';
     var $column_order = array(null,'fc_nobpb','fc_nopo','fd_bpb','fv_supplier','warehouse','untuk_cabang','fm_total'); //set column field database for datatable orderable
     var $column_search = array('fc_nobpb','fc_nopo','fv_supplier'); //set column field database for datatable searchable 
     var $order = array('fc_nobpb' => 'asc'); // default order 
  
     public function __construct()
     {
         parent::__construct();
     }
  
     private function _get_datatables_query($table_name = '')
     {     
        //add custom filter here
        $this->db->where(array('fc_branch' => $this->session->userdata("branch"),"fc_status" => 'F'));
        //jika filternya ada maka buat spt dibawah ini
        if($table_name=='') 
        { 
            $this->db->from($this->table); // default
        } else 
        {
            $this->db->from( $table_name ); 
        }

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
  
     public function get_datatables()
     {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
     }
  
     public function count_filtered($table_name = '')
     {
        if($table_name == '') 
        { 
            $this->_get_datatables_query();
            $query = $this->db->get();
        } else 
        {
            // prepare this if you want to call custom query
            $columnOrder = array();
            $columnSearch = array();
            $orderAble = array();
            $this->_get_datatables_query_from_table( $table_name, $columnOrder, $columnSearch, $orderAble);
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
      * @columnOrder (array)   list kolom yang ingin bisa di urutkan (orderable)
      * @columnSearch (array)  list kolom yang ingin bisa di cari (searchable)
      * @orderAble (array)          kolom yang dijadikan standar pengurutan (default order)
      */
     private function _get_datatables_query_from_table($table_name = '', $columnOrder = array(), $columnSearch = array(), $orderAble = array('fc_id' => 'asc'))
     {     
        //add custom filter here
        if($this->input->post('f_branch'))
        {
            $this->db->where(array('fc_branch' => $this->input->post('f_branch'),'fc_status' => "F"));
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
        else if(isset($orderAble))
        {
            $this->db->order_by(key($orderAble), $orderAble[key($orderAble)]);
        }
     }

     //get data table
    public function getData($tabel,$where){
        $query = $this->db->where($where)->get($tabel);
        if($query->num_rows()>0)
        { return $query->row();}
        else{return null;}
    }
    public function getDetail($table,$where){
        $data = $this->db->where($where)->get($table);
        return $data->result();
    }
    public function update($tabel,$data,$where){
		$query = $this->db->update($tabel,$data,$where);
		return $this->db->affected_rows();
    }
    public function addHutang($nota){
        $query = $this->db->query("call proc_addhutang('".$nota."')"); 
        return $this->db->affected_rows();
    }
 }