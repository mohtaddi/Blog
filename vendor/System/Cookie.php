<?php
namespace System;

class Cookie {
  
   /**
   * The Application class object
   * 
   * @var object $app
   */
  private $app;
   
   /**
   * cookie __construct
   * 
   * @param object \System\Application
   * @return object \System\Cookie
   */
  public function __construct($app){
    $this->app = $app;
    
  }
  
   /**
   * Set new value to the cookie 
   * 
   * @param $key mixed
   * @param $value mixed
   * @hours
   * @return void
   */
  public function set($key , $value, $hours = 1800 ){
    setcookie($key, $value, time() + $hours * 3600 , '','',false , true);
  }
  
   /**
   * get value from the cookie by the givin key
   * 
   * @param string $key
   * @return mixed
   */
  public function get($key){
    return array_get($_COOKIE, $key, $default = null);
  }
  
   /**
   * determine if the cookie has the givin key
   * 
   * @param string $key
   * @return bool
   */
  public function has($key){
     return array_key_exists($key , $_COOKIE);
   }
   
   /**
    * remove the givin key from cookie
    * 
    * @param string $key 
    * @return void
    */
  public function remove($key){
    setcookie($key , null , -1);
      unset($_COOKIE[$key]);
    }
    
   /**
     * get all cookie data
     * 
     * @return array
     */
  public function all(){
      return $_COOKIE;
    }
  
  /**
   * destroy all cookies 
   * 
   * @return void
   */
  public function destroy(){
   foreach (array_keys($this->all()) as $key) {
     $this->remove($key);
   }
   unset($_COOKIE);
  }
}