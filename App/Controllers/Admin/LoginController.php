<?php

namespace  App\Controllers\Admin;
use        System\Controller;


class LoginController extends Controller {
    /**
   * display login form 
   * 
   * @return mixed
   */
  public function index(){
   echo $this->view->render('admin/users/login');
  }
  
     /**
   * get login user data
   * 
   * @return void
   */
  public function submit(){
     $userName = $this->request->post('username');
     $password = $this->request->post('password');
     try{
     $users = $this->db->where('username = ?',$userName)->from('users')->fetch();
    
     pre($users);
     }catch(PDOException $e){
       $e->getMessage();
     }
     
    
  }

}
