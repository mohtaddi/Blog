<?php

namespace System;

class Model {
  
    /**
   * static $table
   * 
   * @var string
   */
   protected static  $table = '';
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
  
    /**
   * Call Database Method Dynamically
   * 
   * @param string $method
   * @param string $argument
   * @return mixed
   */
  public function __call($method , $argument){
    return call_user_func_array([$this->app->db, $method], $argument);
  }
  
     /**
   * get all records
   * 
   * @return array
   */
  public function getAll(){
    return $this->fetchAll( static::$table );
  }
  
     /**
   * get record by id
   * 
   * @return array
   */
  public function getById($id){
    return $this->where(' id = ? ',$id)->fetch( static::$table );
  }
  
     /**
   * get record where some condition
   * 
   * @return array
   */
  public function getWhere($where , $bind ){
    return $this->where($where , $bind)->fetch( static::$table );
  }
  
     /**
   * insert records
   * 
   * @return 
   */
  public function insert($data){
    return $this->db->data($data)->table(static::$table)->insert();
  }
  
}