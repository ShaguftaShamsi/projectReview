<?php

class Track  extends CI_Controller
{   
     static $count_time =0;
     
        function __construct() {
        parent::__construct();
     
    }

    public function display_message()
    {
         
         $this->load->view('track_view_1.html');
       
    }
    
    /** fill dropdown form database
     *  @access public
     * @return void 
     */
    
   public function fill_dropdown() 
   {
            var_dump(static::$count_time);
            $this->load->model('tracking_model');
            $data['w_p'] =$this->tracking_model->ddl_fill();
                 if(static::$count_time === 0)
                 {  
                static::$count_time ++;
                $this->load->view('track_view_1.html',$data);
                }
                 else 
                {
                   return $data;
                }
   }
   
   /*Add user task 
    * @access public
    * @return void 
    * 
    */
   
   public function task_add()
   {
      $data['t_name'] =$this->input->post('task') ;
      $data['t_start_time'] =$this->input->post('difftime');
      $data['t_end_time'] =$this->input->post('stop_time');
      $data['t_diff_time'] =$this->input->post('start_time');
      $data['w_id_name'] =$this->input->post('worksp');
      $data['p_id_name'] = $this->input->post('project');
      $this->load->model('tracking_model');
      $data['result']= $this->tracking_model->insert_task($data);
       if($data['result'])
       {
           $data['bool_tbl']=true;
       }
       $data['w_p'] =$this->tracking_model->ddl_fill();
       $this->load->view('track_view_1.html',$data);  
   }
   
   /*Display error if user wrong email r password that is not validate with database
    * @access public
    */
   function show_error()
   {
            $data['error_message'] ='<font color =RED>Invalid email or password</font></br>';
             echo $data['error_message'];
             $this->load->view('start_view.html');
       
   }
   
}
?>
