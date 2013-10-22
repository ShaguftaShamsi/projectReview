<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Workspace_model extends CI_Model
{
  
    
  function save_workspace($data)
  {
      $result['w_name'] =$data['add_new_wp'];
      $temp=$this->_get_max_id('w_id', 'workspace');
      $temp['w_id'] + 1;
      $result['w_id'] =  $temp['w_id'] + 1;
      $result['owner']=$this->session->userdata("u_id");
      $result['manger']=$this->session->userdata("u_id");
      $result['team']=$this->session->userdata("u_id");
      if($this->db->insert('workspace',$result))
      {
          $this->db->insert('workspace_user',array('w_id'=>$result['w_id'],'u_id'=>$this->session->userdata("u_id")));
          return true;
      }
      return false;
     
  }

  
   function _get_max_id($id,$tbl_name)
   {
       $this->db->select_max($id);
       $query= $this->db->get($tbl_name)->row_array();
       return $query;
   }
}
?>
