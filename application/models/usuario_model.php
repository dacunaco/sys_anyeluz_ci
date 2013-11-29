<?php
    if (!defined('BASEPATH')) {exit('No direct script access allowed');}
    Class Usuario_model extends CI_Model{
        function __construct() {
            parent::__construct();
        }
        
        function disponibility($string){
            $query = 'select usuario from sys_usuario where usuario = ?';
            $result = $this->db->query($query, array($string));
            
            if($result->num_rows() == 0){
                echo 1;
            }else{
                echo 0;
            }
        }
        
        function getNumUsers(){
            $query = 'select count(idusuario) as usuarios from sys_usuario';
            $result = $this->db->query($query);
            
            return $result->row()->usuarios;
        }
        
        function getUsers($pagination, $segment){
            $this->db->select('u.dni,u.nombres,u.apellidos,pu.perfilusuario,u.idusuario,u.sexo,u.foto, u.usuario');
            $this->db->where('u.idperfilusuario = pu.idperfilusuario');
            $this->db->order_by('u.idusuario', 'asc'); 	
            $this->db->limit($pagination, $segment);
            $query = $this->db->get('sys_usuario u, sys_perfil_usuario pu')->result();
            
            return $query;
        }
        
        function getUsersByName(){
            $this->db->select('u.dni,u.nombres,u.apellidos,pu.perfilusuario,u.idusuario,u.sexo,u.foto, u.usuario, u.estado');
            $this->db->where('u.idperfilusuario = pu.idperfilusuario');
            $query = $this->db->get('sys_usuario u, sys_perfil_usuario pu')->result();
            
            return $query;
        }
        
        function check_login($username , $password){
            $sha1_password = $password;
            $query_str = 'SELECT usuario,password,idusuario,idperfilusuario,dni,foto,nombres,apellidos,sexo FROM sys_usuario WHERE usuario = ? and password = ? LIMIT 1';
            $result = $this->db->query($query_str, array($username, $sha1_password));
            
            if($result->num_rows() == 1){
                $user_data = array('user_id' => $result->row(0)->idusuario, 'user_nick' => $result->row(0)->usuario, 'user_perfil' => $result->row(0)->idperfilusuario, 'user_dni' => $result->row(0)->dni, 'user_name' => $result->row(0)->nombres, 'user_lastname' => $result->row(0)->apellidos, 'user_sex' => $result->row(0)->sexo, 'user_foto' => $result->row(0)->foto);
                return $user_data;
            }else{
                return false;
            }
        }
    }

