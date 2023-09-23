<?php
namespace System;

class Session {
  
   /**
   * The Application class object
   * 
   * @var object $app
   */
  private $app;
   
   /**
   * session __construct
   * 
   * @param object \System\Application
   * @return object \System\Session
   */
  public function __construct($app){
    $this->app = $app;
    
  }
  
   /**
   * start the session
   * 
   * @return void
   */
  public function Start(){
    ini_set('session.use_only_cookies' ,1);
      if (! session_id()){
        session_start();
      }
   }
   
   /**
   * Set new value to the session 
   * 
   * @param $key mixed
   * @param $value mixed
   * @return void
   */
  public function set($key , $value){
    $_SESSION[$key] = $value;
  }
  
   /**
   * get value from the session by the givin key
   * 
   * @param string $key
   * @return mixed
   */
  public function get($key){
    return array_get($_SESSION, $key, $default = null);
  }
  
   /**
   * determine if the session has the givin key
   * 
   * @param string $key
   * @return bool
   */
  public function has($key){
     return isset($_SESSION[$key]);
   }
   
   /**
    * remove the givin key from session
    * 
    * @param string $key 
    * @return void
    */
  public function remove($key){
      unset($_SESSION[$key]);
    }
    
   /**
    * get the givin key
    * then delete it from the session 
    * 
    * @param string key
    * @return mixed 
    */
  public function pull($key){
     $value = $this->get($key);
     $this->remove($key);
     return $value;
    }
    
   /**
     * get all session data
     * 
     * @return array
     */
  public function all(){
      return $_SESSION;
    }
    
   /**
     * destroy session
     * 
     * @return void
     */
  public function destroy(){
       session_destroy();
       unset($_SESSION);
     }
}