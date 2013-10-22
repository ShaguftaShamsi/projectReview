<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tracking_model extends CI_Model
{
    /**
     * Validate User Exits Or Not
     * @param type array
     * @retrun boolean
     */
    
    public function validate()
    {   
        
        $session_id = $this->session->userdata('session_id');
        $email = $this->input->post('email') ;
        $password= $this->input->post('password');
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $query =$this->db->get('user');
        if($query->num_rows > 0)
        {
           $row = $query->row();
           list($username) = explode('@',$email);
           $this->_set_session_data($row->fullname, $row->u_id,null,$email);
           return true;
            // print_r($this->session->all_userdata());
        }
       else
         return false;
    }
    
    
     /*Get workspace name and project of user
      * @access public
      * @return array
      */
    public function ddl_fill()
      {
                $sql='SELECT w.w_name, p.p_name
                FROM workspace w, project p
                WHERE w.w_id
                IN (
                select wu.w_id  from  
                workspace_user wu 
                where wu.u_id in(select tu.u_id from 
                team_user tu where 
                tu.w_id in(
                select wu.w_id  from workspace_user wu ,workspace w where wu.u_id =
                      (
                        select u.u_id from user u where u.fullname="'.$this->session->userdata('name').'"
                        )and wu.w_id= w.w_id
                                )
                    )
               union
                select wu.w_id  from workspace_user wu ,workspace w where wu.u_id =
                (
                select u.u_id from user u where u.fullname="'.$this->session->userdata('name').'"
                )and wu.w_id= w.w_id
                )
                AND p.p_name
                IN (
                SELECT pj.p_name
                FROM project pj, workspace_project w_p
                WHERE pj.p_id = w_p.p_id
                AND w_p.w_id = w.w_id
                    )';
                
     $query=$this->db->query($sql);
     if($query->num_rows() >=1)
            {  
              foreach($query->result_array() as $row)
                $return [$row['w_name']][$row['p_name']] =$row['p_name'];
               return $return;
             }
     else 
         echo 'No workspace selected';
     }
     
    
     
     public function insert_task($records)
     {
        
        $data['t_name']= $records['t_name'];
        $data['t_diff_time'] =$records['t_diff_time'];
        $data['t_start_time'] =$this->_convert_time_format($records['t_start_time']);
        $data['t_end_time']= $this->_convert_time_format($records['t_end_time']);
        $data['p_id'] = $records['p_id_name'];
        $data['w_id'] = $records['w_id_name'];
        $data['t_start_date']= date("Y-m-d ");
                if($records['w_id_name'] == 'worksp' )
               {
                   $data['w_id'] = $this->session->userdata('w_id');
                   $data['p_id'] = null;
               }
               else
               {
               $data['p_id'] = $this->_get_id_db('p', 'project',$records['p_id_name'] );
               $data['w_id'] =$this->_get_id_db('w', 'workspace',$records['w_id_name'] );  
              }
        $data['u_id'] = $this->session->userdata('u_id');
              if($this->db->insert('task',$data))
                {
                $insert_id= $this->db->insert_id(); 
                $this->db->select('t_name,t_start_time,t_end_time,t_diff_time');
                $this->db->where('u_id',$this->session->userdata('u_id'));
                $query =$this->db->get('task');
                return $query;
                }
           else
            return false;
     }
     
     function _get_id_db($p,$tbl_name,$id)
     {
           $sql= 'select '. $p .'_id from ' . $tbl_name. ' where  '. $p. '_name="' .$id.'"';
           $result= $this->db->query($sql)->row_array();
           return $result[''.$p.'_id'];
     }
      
     public   function insert_new_user($data)
      {
      
         list($fullname) = split('@',$data['email']);
         $records['fullname'] =$fullname;
         $records['email'] =$data['email'];
         $records['password'] =$data['password'];
         $records['date_format'] = time();
         $records['begning_of_week'] = 'Monday';
         $records['token'] = uniqid();
         if($this->db->insert('user',$records))
         {
            $temp['w_name'] = $fullname .'workspace';
            $o_m_t=$this->db->insert_id();
            $temp['owner'] =$o_m_t;
            $temp['manger'] =$o_m_t;
            if($this->session->userdata('token') !=null)
            {
              $temp['team']=$this->_get_token_uid($this->session->userdata('token'));
            }
            else
            $temp['team'] =$o_m_t;
            $this->db->insert('workspace',$temp);
            $w_id =$this->db->insert_id();
             $this->db->insert('workspace_user',array('w_id'=>$w_id,'u_id' =>$o_m_t));
             if($temp['owner'] != $temp['team'])
             $this->db->insert('workspace_user',array('w_id'=>$w_id,'u_id' =>$temp['team']));
             $this->_set_session_data($fullname,$o_m_t,$w_id,$records['email']);
             return true;
         }
        else
        {
             return false;
        }
      }
      
         function _set_session_data($name,$u_id,$w_id =null,$email)
         {
             $data['w_id'] =$w_id;
             if($w_id == null)
             {
                $slct_wp = $name .' workspace';   
                $this->db->select('w_id');
                $this->db->where('w_name',$slct_wp);
                $data=$this->db->get('workspace')->row_array();
           
             }
             $data =array('name'=> $name,'u_id'=> $u_id,'w_id'=>$data['w_id'],'email'=>$email);
             $this->session->set_userdata($data);
           
         }
         
         /*
          * private function chage time format 00/00/00 to 00:00:00
          */
         function _convert_time_format($time)
         {
             $pieces= explode("/", $time);
             $result = $pieces[0] .':'.  $pieces[1].':'.$pieces[2] ;
             var_dump($result);
             return $result;
         }
          
         
         function _get_token_uid($token)
         {
         
             $this->db->select('u_id');
             $this->db->where('token',$token);
             $query=$this->db->get('user')->row_array();
             return $query['u_id'];
         }
}
         

?>
