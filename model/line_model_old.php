<?php 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class  Line_model_old extends CI_Model{
    
    public function  line_data(){
    {
       $today_date = date("Y-m-d");
       $this->db->select('begning_of_week');
       $query = $this->db->get_where('user',array('u_id' => $this->session->userdata('u_id')));
       $row=$query->row();
       $day =date('l');
       $temp ='Monday';
        while($day != $temp)
        {
            $d =  strtotime("-1 day", strtotime($today_date));
            $day = date('l',$d);
            $daate= date('Y-m-d',$d);
            $today_date =$daate;
            //echo '<br>'."date:".$d."day:".$day."   today-date:".$today_date. "date real".$daate."<br>";
        }
        
        $plot = array();
        for($iloop = 0 ; $iloop <= 6; $iloop++)
         {    
            $d =  strtotime("+$iloop day", strtotime($today_date));
            $day = date('l',$d);
           //  echo " hello".$day.'<BR>';
            $plot[$iloop] =date('Y-m-d',$d);
         }
     $this->db->select("t_start_date,SEC_TO_TIME(SUM(TIME_TO_SEC(`t_diff_time`)))  as difftime");
     $this->db->group_by("t_start_date"); 
     $query1 = $this->db->get_where('task',array('t_start_date >=' => $plot[0] ,'u_id' => $this->session->userdata('u_id')));
     $q =$query1->result();
  
     //var_dump($plot); 
    return array('plot' => $plot , 'plotting_line' => $query1->result());
    }
}
}
?>
