<?php

namespace System\Http;
use System\Application;

class Response {
  
     /**
   * The Application object
   * 
   * @var System\Application
   */
  private $app;
  
    /**
   * Headers container That will be sent to the browser
   * 
   * @var array
   */
  private $headers = [];
  
    /**
   * content that will be sent to the browser
   * 
   * @var string
   */
  private $content;

    /**
   * The Response Constructor
   * 
   * @param System\Application
   */
  public function __construct(Application $app){
    $this->app = $app;
  }
  
    /**
   * set The Response output content
   * 
   * @param string $content
   * @return void
   */
  public function setOutPut($content){
    $this->content = $content;
  }
  
    /**
   * send the content to the browser
   * 
   * return void
   */
  public function sendContent(){
   echo $this->content;
  }
  
    /**
   * Set The Response Headers
   * 
   * @param string $header
   * @param string $value
   * @return void
   */
  public function setHeaders($header, $value){
    $this->headers[$header] = $value;
  }
  
    /**
   * Send the Headers to the browser
   * 
   * return void
   */
  public function sendHeaders(){
    foreach ($this->headers as $header => $value)
    {
      header($header . ':' . $value);
    }
    
  }
  
   /**
   * send the response headers and content
   * 
   * @return void
   */
  public function send(){
    $this->sendHeaders();
    $this->sendContent();
  }
  
}