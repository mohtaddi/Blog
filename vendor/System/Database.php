<?php

namespace System;
use PDO;
use PDOException;
class Database {
  
     /**
   * The Application object
   * 
   * @var System\Application
   */
  private $app;
  
     /**
   * PDO Connection
   * 
   * @var /PDO
   */
  private static $connection;
  
     /**
   * bindings Container
   * 
   * @var array
   */
  private $bindings = [];
  
     /**
   * select Container
   * 
   * @var array
   */
  private $selects = [];
  
     /**
   * join Container
   * 
   * @var array
   */
  private $joins = [];
  
  
     /**
   * limit 
   * 
   * @var int
   */
  private $limit;
  
     /**
   * offset
   * 
   * @var int
   */
  private $offset;
  
     /**
   * Total Rows
   * 
   * @var int
   */
  private $rows;
  
     /**
   * order by
   * 
   * @var array
   */
  private $orederBy = [];
  
     /**
   * user input data
   * 
   * @var array
   */
  private $data = [];
  
     /**
   * Last inserted id 
   * 
   * @var int
   */
  private $lastId;
  
     /**
   * wheres
   * 
   * @var array
   */
  private $wheres = [];
  
    /**
   * The  Constructor
   * 
   * @param System\Application
   */
  public function __construct(Application $app){
    $this->app = $app;
    if (! $this->isConnected()){
      $this->connect();
    }
  }
  
    /**
   * Determine if there any connection to database
   * 
   * @return bool
   */
  private function isConnected(){
    return static::$connection instanceof PDO;
  }
  
    /**
   * Connect To Database
   * 
   * @return void
   */
  private function connect(){
    $connectionData = $this->app->file->call('config.php');
    $dsn = "mysql:host=" . $connectionData['server'] . ';';
    $dsn .= 'dbname=' . $connectionData['dbname'] ;
    $user = $connectionData['dbuser'];
    $pass = $connectionData['dbpass'];
    try
    {
      static::$connection = new PDO ($dsn , $user ,$pass);
      static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      
      static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      static::$connection->exec('SET NAMES utf8');
      
    }catch(PDOExecption $e){
      die($e->getMessage());
    }
    
  }
  
    /**
   * Get the Connection object
   * 
   * @return object
   */
  public function connection(){
    return static::$connection;
  }
 
    /**
   * select clause
   * 
   * @param string $select
   * @return $this
   */
  public function select($select = null){
    $this->selects= [$select];
    return $this;
  }
 
    /**
   * join clause
   * 
   * @param string $join
   * @return $this
   */
  public function join($joins){
    $this->joins = [$joins];
    return $this;
  }
 
    /**
   * orderby clause
   * 
   * @param string $orderBy
   * @param string $sort
   * @return $this
   */
  public function orderBy($orderBy , $sort ='ASC'){
    $this->orderBy = [$orderBy, $sort];
    return $this;
  }
 
    /**
   * set limit and offset
   * 
   * @param int $limit
   * @param int $offset
   * @return $this
   */
  public function limit($limit, $offset = 0){
    $this->limit = $limit;
    $this->offset = $offset;
    return $this;
  }
  
    /**
   * Fetch Table
   * this will return only one record
   * 
   * @param string $table
   * @return \stdClass|null
   */
  public function fetch($table = null){
    if($table){
      $this->table($table);
    }
    $sql = $this->fetchStatement();
     
    $result = $this->query($sql , $this->bindings)->fetch();
    $this->resetBindings();
    return $result;
  }
  
    /**
   * fetchAll Table
   * this will return all record
   * 
   * @param string $table
   * @return \stdClass|null
   */
  public function fetchAll($table = null){
    if($table){
      $this->table($table);
    }
    $sql = $this->fetchStatement();
    
    $query = $this->query($sql , $this->bindings);
    $this->rows = $query->rowCount();
    $result = $query->fetchAll();
    
    $this->resetBindings();
    return $result;
  }
  
    /**
   * prepare select statement
   * 
   * @return string
   */
   private function fetchStatement(){
     $sql = 'SELECT ';
     if (is_array($this->selects) and $this->selects[0] != null){
       $sql .= implode( ',' , $this->selects);
     }else{
       $sql .= ' * ';
       
     }
     
     $sql .= ' FROM ' . $this->table;
     
     if ($this->joins){
       $sql .= implode(' ', $this->joins);
     }
     
     if ($this->wheres){
       $sql .=  ' WHERE ' .implode(' ', $this->wheres);
     }
     
     if ($this->orderBy){
       $sql .= ' ORDER BY ' . implode(' ', $this->orderBy);
     }
     
     if ($this->limit){
       $sql .=  ' LIMIT ' . $this->limit;
     }
     
     if ($this->offset){
       $sql .= ' OFFSET ' . $this->offset;
     }
     
     return $sql;
   }
   
   
    /**
   * set the table name 
   * 
   * @param string $table
   * @return $this
   */
  public function table($table){
    $this->table = $table;
    return $this;
  }
  
    /**
   * set the table name 
   * 
   * @param string $table
   * @return $this
   */
  public function from($table){
    $this->table($table);
    return $this;
  }
  
    /**
   * set the data that will be stored 
   * in the database table
   * 
   * @param mixed $key
   * @param mixed $value
   * @return $this
   */
  public function data($key, $value = null){
   if (is_array($key)){
     $this->data = array_merge($this->data , $key);
     $this->addToBindings($key);
   }else{
     $this->data[$key] = $value;
     $this->addToBindings($value);
   }
   
   return $this;
  }

    /**
   * update data in Database
   * 
   * @param string $table
   * @return object $this
   */
  public function update($table = null){
    if($table){
      $this->table = $table;
    }
    $sql = 'UPDATE '. $this->table . ' SET ';
    $sql .= $this->setFields();
    if($this->wheres){
      $sql .= ' WHERE ' . implode(' ', $this->wheres);
    }
    
    $this->query($sql, $this->bindings);
    $this->resetBindings();
    return $this;
  }
  
    /**
   * insert data to Database
   * 
   * @param string $table
   * @return object $this
   */
  public function insert($table = null){
    if($table){
      $this->table = $table;
    }
    
    $sql = 'INSERT INTO '. $this->table . ' SET ';
    $sql .= $this->setFields();
    $this->query($sql, $this->bindings);
    $this->lastId = $this->connection()->lastInsertId();
    $this->resetBindings();
    return $this;
  }
  
    /**
   * delete data in Database
   * 
   * @param string $table
   * @return object $this
   */
  public function delete($table = null){
    if($table){
      $this->table = $table;
    }
    $sql = 'DELETE FROM '. $this->table . ' ';
    if($this->wheres){
      $sql .= ' WHERE ' . implode(' ', $this->wheres);
    }
    
    $this->query($sql, $this->bindings);
    $this->resetBindings();
    return $this;
  }
    
  
    /**
   * add new where clause
   * 
   * @param 
   * @return $this
   */
  public function where(...$bindings){
    $sql = array_shift($bindings);
    $this->addToBindings($bindings);
    $this->wheres[] = $sql;
    return $this;
  }
  
  
    /**
   * Excute the given sql statement
   * 
   * @return \PDOStatement
   */
   public function query(...$bindings){
       $sql = array_shift($bindings);
       if(count($bindings) == 1 and is_array($bindings[0])){
         $bindings = $bindings[0];
    
       }
       try{
  
         $query = $this->connection()->prepare($sql);
         foreach ($bindings as $key => $value){
               $query->bindValue($key + 1,_e($value));
            }
         $query->execute();
        $this->rows = $query->rowCount();
         return $query;
         
       }catch(PDOException $e){
         die($e->getMessage());
       }
  }
  
    /**
   * Add to bindings 
   * 
   * @param mixed $value
   * @return void
   */
  private function addToBindings($value){
    if(is_array($value)){
      $this->bindings = array_merge($this->bindings, array_values($value));
    }else{
    $this->bindings[]= $value;
    }
  }

    /**
   * get last inserted id
   *
   * @return int
   */
  public function lastId(){
    return $this->lastId;
  }
  
    /**
   * Set query Fields
   *
   * @return string
   */
  private function setFields(){
    $sql = "";
    foreach ($this->data as $key => $value){
      $sql .= '`' . $key .'`' . ' = ?, ' ;
    }
    $sql = rtrim($sql , ', ');
    return $sql;
  }
  
      /**
   * Get row count from last 
   * fetchAll action
   *
   * @return int
   */
  public function rows(){
    return $this->rows;
  }
  
    /**
   * reset bindings fields
   *
   * @return void
   */
  private function resetBindings(){
    $this->bindings = [];
    $this->wheres = [];
    $this->data = [];
    $this->selects = [];
  }
}