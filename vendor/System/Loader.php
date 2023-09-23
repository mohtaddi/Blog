<?php
namespace System;

class Loader{
    /**
   * the Application instance
   * 
   * @var \System\Application
   */
  private $app;
  
    /**
   * Controller container
   * 
   * @var array 
   */
  private $controllers = [];
  
    /**
   * models container
   * 
   * @var array
   */
  private $models = [];
  
    /**
   * Loader Conustructor
   * 
   * @param \System\Application $app 
   * @return \System\Loader
   */
  public function __construct(Application $app){
    $this->app = $app;
}

    /**
   * call the givin controller with the givin method
   * and pass the givin argumnets to the controller method
   * 
   * @param string $controller 
   * @param string $action 
   * @param array $arguments 
   * @return mixed
   */
  public function action($controller, $method, array $arguments){
    $object = $this->Controller($controller);
    return call_user_func([$object, $method] , $arguments);
  }
   
    /**
   * call the givin controller
   * 
   * @param string $controllers
   * @return object
   */
  public function controller($controller){
    $controller = $this->getControllerName($controller);
    
    if(! $this->hasController($controller)){
        $this->addController($controller);
    }
    
    return $this->getController($controller);
  }
  
    /**
   * Determine if the givin class|controller 
   * Exist in the controller container
   * 
   * @param string $controller
   * @return bool
   */
  public function hasController($controller){
    return array_key_exists($controller, $this->controllers);
  }
  
    /**
   * create a new object for the givin controller
   * and store it into the controllers container
   * 
   * @param string $controller
   * @return void
   */
  public function addController($controller){
    $object = new $controller($this->app);
    $this->controllers[$controller] = $object;
  }
  
    /**
   * get Full Class Name for the givin controller
   * 
   * @param string $controller
   */
  private function getControllerName($controller){
    $controller = $controller . 'Controller';
    $controller = 'App\\Controllers\\' . $controller;
    
    // App\Controller\HomeController
    return str_replace('/', '\\', $controller);
  }
  
    /**
   * get geven controller from container 
   * 
   * @param string $controller
   * @return object
   */
  public function getController($controller){
    return $this->controllers[$controller];
  }
  
    /**
   * call the givin model
   * 
   * @param string $models
   * @return object
   */
  public function model($model){
    $model = $this->getModelName($model);
    
    if(! $this->hasModel($model)){
        $this->addModel($model);
    }
    
    return $this->getModel($model);
  }
  
    /**
   * Determine if the givin class|model 
   * Exist in the model container
   * 
   * @param string $model
   * @return bool
   */
  public function hasModel($model){
    return array_key_exists($model, $this->models);
  }
  
    /**
   * create a new object for the givin model
   * and store it into the models container
   * 
   * @param string $model
   * @return void
   */
  public function addModel($model){
    $object = new $model($this->app);
    $this->models[$model] = $object;
  }
  
    /**
   * get Full Class Name for the givin model
   * 
   * @param string $model
   */
  private function getModelName($model){
    $model = $model . 'Model';
    $model = 'App\\Models\\' . $model;
    
    // App\Model\HomeModel
    return str_replace('/', '\\', $model);
  }
  
    /**
   * get geven model from container 
   * 
   * @param string $model
   * @return object
   */
  public function getModel($model){
    return $this->models[$model];
  }
}