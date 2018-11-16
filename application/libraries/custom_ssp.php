<?php 
//untuk controllernya nanti tinggal $this->M_model->allposts_count() tanpa variable table yang ada di controller.
    function allposts_count()
    {   
        $query = $this->db->query("select * from foo");
        return $query->num_rows();  
    } 
    function allposts($limit,$start,$col,$dir)
    {   
       $query = $this->db->query("select * from foo order by ".$col." ".$dir." limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result();}
        else{return null;}
    }
    function posts_search($field1,$field2,$limit,$start,$search,$col,$dir)
    {
        $query = $this->db->query("select * from foo where ".$field1." like '%".$search."%' or ".$field2." like '%".$search."%' order by ".$col." ".$dir." limit ".$start.",".$limit);
        if($query->num_rows()>0)
        { return $query->result(); }
        else { return null; }
    } 
    function posts_search_count($tabel,$field1,$field2,$search)
    {   $query = $this->db->query("select * from foo where ".$field1." like '%".$search."%' or ".$field2." like '%".$search."%' order by ".$col." ".$dir." limit ".$start.",".$limit);
        return $query->num_rows();  }