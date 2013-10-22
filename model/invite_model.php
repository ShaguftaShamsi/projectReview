<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Invite_model extends CI_Model{
    
    function get_token()
    {
        $this->db->select('token');
        $this->db->where('u_id',$this->session->userdata('u_id'));
        $query =$this->db->get('user')->row_array();
        var_dump($query);
        return $query;
    }
    
    function check_status($data)
    {
        $this->db->select('email');
        $this->db->where('email',$data);
        $query=$this->db->get('user');
        if($query->num_rows == 1)
            return true;
        else 
            return false;
        
    }
    
}
?>
