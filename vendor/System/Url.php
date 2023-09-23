<?php

namespace System;

class Url {
    /**
   * The Application Class object
   * 
   * @var \System\Application
   */
  protected $app;
  
    /**
   * constructor 
   * 
   * @param $app System\Application
   */
  public function __construct(Application $app){
     $this->app = $app;
  }
  
    /**
   * get full path of givin url 
   * 
   * @param string $url
   * @return void
   */
  public function link($url){
    
     return $this->app->request->baseUrl() . trim($url ,'/');
  }
  
    /**
   * redirect to the givin url
   * 
   * @param string $url
   * @return void
   */
  public function redirectTo($url){
    
     header("location: " . $this->link($url));
     exit();
  }
  


}