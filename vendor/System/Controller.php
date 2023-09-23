<?php

namespace System;

class Controller {
    /**
   * The Application Class object
   * 
   * @var \System\Application
   */
  protected $app;
   
     /**
    * Controllers Errors
    * 
    * @var array
    */
   protected $error = [];
  
    /**
   * constructor 
   * 
   * @param $app System\Application
   */
  public function __construct(Application $app){
     $this->app = $app;
  }
   /**
   * call application shared objects dynamiclly
   * 
   * application get function
   * 
   * @param $key
   * @return object
   */
  public function __get($key){
    return $this->app->get($key);
  }
}