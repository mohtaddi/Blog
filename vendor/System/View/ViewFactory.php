<?php

namespace System\View;

class ViewFactory{
    /**
   * The Application object
   * 
   * @var System\Application
   */
  private $app;
  
    /**
   * View Constructor 
   * 
   * @param System\Application
   */
  public function __construct($app){
    $this->app = $app;
  }
  
    /**
   * Render the given view path with passed variables
   *  and generate new view object
   * 
   * @param string $viewPath
   * @param array $data
   * @return System\View\ViewInterface
   */
  public function render($viewPath, $data = []){
    return new View($this->app->file, $viewPath, $data);
  }
  
  
}