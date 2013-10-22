<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking extends CI_Controller
{
    var $temp ='';
     
        function __construct() {
        parent::__construct();
    }

     
    /** User Login
     *  @acces  public
     *  @param  void
     * @return  void
    **/
    public function user_login()
    {    
          
         $data =array('check' =>$this->input->post('signUp/login'));
         $this->session->set_userdata($data);
         $check =$this->session->userdata('check');
         print_r($this->session->all_userdata());
         $data['email'] =$this->input->post('email');
         $data['password'] =$this->input->post('password');
         $this->form_validation->set_rules('email',' Email','trim|redqired|valid_email');
         $this->form_validation->set_rules('password','Password','trim|redqired|min_length[4]|max_length[32]');
         if($this->form_validation->run() == False)
         {            
              $this->load->view('start_view.html',$data);
         }
         else
         {   
         $this->load->model('tracking_model');
         if($check  == 'Login')
             {    
              $this->load->view('start_view.html');
              $data['email'] =$this->input->post('email');
              $data['password'] =$this->input->post('password'); 
              $result=$this->tracking_model->validate();
              if($result)
              {                   
              redirect('track');   
              }
             else 
             {
              redirect('track/show_error');
             }
            }
        else 
            {     
            $this->load->view('start_view.html');
            $result=$this->tracking_model->insert_new_user($data); 
             if($result)
             {              
                 redirect('track');
             }
            }
          }
}

  public function  user_logout()
  {
      $this->session->sess_destroy();
      $this->load->view('start_view.html');
  }
}
?>
