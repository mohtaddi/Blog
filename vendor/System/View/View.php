<?php

namespace System\View;
use System\File;

class View implements ViewInterface{
  
   /**
   * File object
   * 
   * @var System\File
   */
  private $file;
  
    /**
   * View Path
   * 
   * @var string
   */
  private $viewPath;
  
    /**
   * passed data ( Variables ) To the view path
   * 
   * @var array
   */
  private $data = [];
  
    /**
   * the out put from the view file
   * 
   * @var string
   */
  public $output;
  
   /**
   * the constructer
   * 
   * @param System\File
   * @param string $viewPath
   * @param array $data
   */
  public function __construct(File $file, $viewPath, $data ){
    $this->file = $file;
    $this->preparePath($viewPath);
    $this->data = $data;
  }
  
    /**
   * prepare view path
   * 
   * @param string $viewPath
   * @return void
   */
  public function preparePath($viewPath){
    $relativeViewPath = "App/Views/". $viewPath . ".php";
    $this->viewPath =$this->file->to("App/Views/". $viewPath . ".php");
    if (! $this->viewFileExists($relativeViewPath)){
      die($this->viewPath . " does not Exist in Views Folder ..");
    }
  }
  
    /**
   * Determine if the view file exist
   * 
   * @return bool
   */
  private function viewFileExists($viewPath){
    return $this->file->exists($viewPath);
  }
  
    /**
   * {@inheritDoc}
   */
  public function getOutPut(){
    if (is_null($this->output))
    {
      ob_start();
      extract($this->data);
      require $this->viewPath;
      $this->output = ob_get_clean();
    }
    
    return $this->output;
  }
  
    /**
   * {@inheritDoc}
   */
  public function __toString(){

    return $this->getOutPut();
  }
  
}