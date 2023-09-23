<?php

namespace System;

class Html {
    /**
   * The Application Class object
   * 
   * @var \System\Application
   */
  protected $app;
  
    /**
   * html title
   * 
   * @var string
   */
  private $title;
  
    /**
   * html description
   * 
   * @var string
   */
  private $description;
  
    /**
   * html keywords
   * 
   * @var string
   */
  private $keywords;
  
  
    /**
   * constructor 
   * 
   * @param $app System\Application
   */
  public function __construct(Application $app){
     $this->app = $app;
  }
  
    /**
   * set title 
   * 
   * @param string $title
   * @return void
   */
  public function setTitle($title){
     $this->title = $title;
  }
  
    /**
   * get title 
   * 
   * @return string
   */
  public function getTitle(){
    return $this->title;
  }
  
    /**
   * set descriprion 
   * 
   * @param string $description
   * @return void
   */
  public function setDescription($description){
     $this->descriprion = $description;
  }
  
    /**
   * get descriprion 
   * 
   * @return string
   */
  public function getDescription(){
    return $this->descriprion;
  }
  
    /**
   * set keyword 
   * 
   * @param string $keyword
   * @return void
   */
  public function setKeyword($keyword){
     $this->keyword = $keyword;
  }
  
    /**
   * get keyword 
   * 
   * @return string
   */
  public function getKeyword(){
    return $this->keyword;
  }

}