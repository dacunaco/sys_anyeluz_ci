<?php
    if(!defined('BASEPATH'))    exit('No direct script access allowed');
    class Usuario extends CI_Controller{
        function __construct() {
            parent::__construct();
            $this->load->library('encrypt');
            $this->load->model('Usuario_model');
        }
        /* Controlador de vista principal para el login */
        function index(){
            if(!$this->session->userdata('user_data')){
                $this->load->view('usuario/view_login'); 
            }else{
                redirect('administrador');
            }            
        }
        function login(){
                $username = $this->input->post('login_username');
                $password = $this->input->post('login_userpass');
                $user_data = $this->Usuario_model->check_login($username, $this->encrypt->encode_security($password));
                
                if(!$user_data){
                    $this->session->set_flashdata('login_error', TRUE);
                    echo 0;
                    redirect(base_url());
                }else{
                    $this->session->set_userdata('user_data', $user_data);
                    echo 1;
                }
        }
        function logout(){
            $this->session->unset_userdata('user_data');
            $this->session->sess_destroy();
            redirect('usuario');
        }
    }
?>
