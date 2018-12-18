<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
 class M_model extends CI_Model {
  
     var $table = 'v_kartustock';
    //  var $column_order = array(
    //     null, 
    //     'fc_id', 'fc_branch','fc_wh','fd_tgl','fc_stock',
    //     'fv_stock', 'fc_variant', 'fv_variant', 'fc_size', 'fv_size',
    //     'fc_warna', 'fv_warna', 'fn_in', 'fn_out', 'fn_sisa',
    //     'fc_referensi', 'fc_ket', 'fn_hargajual', 'fn_hargabeli', 'fc_userid' 
    //     ); //set column field database for datatable orderable
     var $column_order = array('fd_tgl','fc_stock','fv_stock','fv_variant','fc_referensi','fc_ket','fc_userid');
     var $column_search = array('fc_branch','fc_wh','fv_stock'); //set column field database for datatable searchable 
     var $order = array('fc_id' => 'asc'); // default order 
  
     public function __construct()
     {
         parent::__construct();
     }
     
     /**
      * procedure to get query from table
      */
     private function _get_datatables_query()
     {
          
         //add custom filter here
         if($this->input->post('f_branch'))
         {
            $this->db->where('fc_branch', $this->input->post('f_branch'));
         }
         if($this->input->post('f_wh'))
         {
            $this->db->like('fc_wh', $this->input->post('f_wh'));
         }  
         if($this->input->post('f_namabrg'))
         {
             $this->db->like('fv_stock', $this->input->post('f_namabrg'));
         }
         $this->db->from($this->table);

         $i = 0;      
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
  
     public function count_filtered()
     {
         $this->_get_datatables_query();
         $query = $this->db->get();
         return $query->num_rows();
     }
  
     public function count_all()
     {
         $this->db->from($this->table);
         return $this->db->count_all_results();
     }      
 }