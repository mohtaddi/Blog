<?php
namespace System;

class Route {
  
   /**
   * The Application object
   * 
   * @var object 
   */
  private $app; 
  
     /**
   * this flag for know if theres 
   *  matching url pattern 
   * 
   * @var object 
   */
  private $matchFlag = false; 
  
   /**
   * not found url
   * 
   * @var string
   */
  private $notFound; 
  
    /**
   * Routes Container
   * 
   * @var Array
   */
  private $routes = [];   
  
    /**
   * the contructor function 
   * 
   * @param object \System\Application 
   * @return \System\Route
   */
  public function __construct (Application $app){
    $this->app = $app;
  }
  
    /**
   * Add New Route
   * 
   * @param string $url
   * @param string $action
   * @param string $requestMethod
   * @return void
   */
  public function add($url,$action, $requestMethod ='GET') {
    $route = [
        'url'      => $url,
        'pattern'  => $this->generatePattern($url),
        'action'   => $this->getAction($action),
        'method'   => $requestMethod ,
      ];
      $this->routes[]= $route;
  }
 
    /**
   * set not found url
   * 
   * @param $url
   * @return void
   */
  public function notFound($url){
     $this->notFound = $url;
  }
   
    /**
   * Get Proper Route
   * 
   * @return array
   */
  public function getProperRoute(){
    foreach ($this->routes as $route)
    {
      if($this->isMatching($route['pattern']))
      {
        $this->matching = true;
        $arguments = $this->getArgumentsFrom($route['pattern']);
        list($controller, $method) = explode('@', $route['action']);
        return [$controller, $method, $arguments];
      }
    }
    if(! $this->matching){
        $this->notFound($route['url']);
        die($this->app->view->render('admin/notFound' , $this->notFound));
      }
    $this->matching = false;
    
  }
  
    /**
   * Determine If the Givin Pattern Mathches The Current Url
   * 
   * @param string $pattern 
   * @return bool
   */
  private function isMatching($pattern){
    return preg_match($pattern ,$this->app->request->url());
  }
  
    /**
   * get arguments from the current request url
   * based on the givin arguments
   * 
   * @param string $pattern
   * @return array
   */
  private function getArgumentsFrom($pattern){
    preg_match($pattern, $this->app->request->url(), $matches);
    array_shift($matches);
    return $matches;
  }
 
    /**
   * Generate A Regex Pattern For the given URL
   * 
   * @param string $url
   * @retun string
   */
  private function generatePattern($url){
     $pattern = '#^';
     
     $pattern .= str_replace([':text' ,':id'] ,['([a-zA-Z0-9-]+)' , '(\d+)'] , $url);
     
     $pattern .= '$#';
     return $pattern;
   }
   
    /**
   * Get The Proper Action 
   * 
   * @param string $action
   * @return string
   */
  private function getAction($action){
     
     $action = str_replace('/' , '\\' , $action);
     return strpos($action, '@') !== false ? $action : $action . '@index';
   }
   
}