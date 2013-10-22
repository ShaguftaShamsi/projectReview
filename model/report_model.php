<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Report_model extends CI_Model{
    
   function get_workspace()
   {
          //$u_id =$this->session->userdata('u_id');
         //echo $u_id;
        // $u_id=8;
         $sql = 'select w_name from workspace where owner ="'.$this->session->userdata('u_id').'"
             or team in(select team from workspace where owner =  "'.$this->session->userdata('u_id').'" 
             and team!= "'.$this->session->userdata('u_id').'" )';
         // echo $sql;
          $return =$this->db->query($sql); 
          return $return->result_array();
   }
}
?>
