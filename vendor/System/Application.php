<?php

	namespace System;
	
	class Application
{
	
	  /**
	 * application instance object
	 * 
	 * @var \System\Application
 	 */
  private static $instance;
  
    /**
	 * the Classes Objects Container 
	 *
	 * @param [$objecs]
	 */
  private $container = [];
	
    /**
	 * the Helpers File Path
	 *
	 * @const string
	 */
  const HELPER = "/vendor/Helper.php";

	  /**
   * constructor 
   *
   * @param \System\File
   */
  private function __construct(File $file){
			  
				$this->share("file", $file);
				static::$instance = $this;
				$this->registerClasses();
				$this->loadHelpers();
				
	}

    /**
   * Run the Application
   * 
   * @return void
   */
  public function run(){
     $this->session->start();
     $this->request->prepareUrl();
     $this->file->call('App/index.php');
    list($controller, 
           $method,
           $arguments) = $this->route->getProperRoute();
     $output = (string) $this->loader->action($controller, $method, (array) $arguments);
     $this->response->setOutPut($output);
     $this->response->send();
    }
	 	/**
	 * Get Application instance
	 * 
	 * @return System\Application
	 */
  public static function getInstance($file = null){
	     if(is_null(static::$instance)) {
	     static::$instance = new static($file);
	     }
	     return static::$instance;
	 }
	  
  	/**
	 * initialize Application  Core Classes
	 * 
	 * 
	 * @return string
   */
  private function coreClasses(){
     return [
           "request" => "\\System\\Http\\Request",
           "response" => "\\System\\Http\\Response" ,
           "session" => "\\System\\Session" ,
           "cookie" => "\\System\\Cookie" ,
           "route" => "\\System\\route" ,
           "loader" => "\\System\\Loader" ,
           "view" => "\\System\\View\\ViewFactory" ,
           "html" => "\\System\\Html" ,
           "db" => "\\System\\Database" ,
           "request" => "\\System\\Http\\Request" ,
           "url" => "\\System\\Url" ,
           
       ];
   }

  
   	/**
	 * Detemine wether given alliase is core class
	 * 
	 * @param string $allias
	 * @return bool
   */
  private function isCoreClass($allias){
	  $coreClasses = $this->coreClasses();
	  return isset($coreClasses[$allias]);
	}
	
	  /**
	 * Create a New Object of given alliase
	 * 
	 * @param string $allias
	 * @return Object
   */
  private function createNewCoreObject($allias){
	  $coreClasses = $this->coreClasses();
	  return new $coreClasses[$allias]($this);
	}
	
    /**
	 * share the given key|value through application 
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
  public function share($key, $value){
		
	  $this->container[$key] =  $value;
	}
	
 	  /**
	 * register Classes on spl auto load register 
	 *
	 * @return void
	 */
  private function registerClasses(){
	spl_autoload_register([$this, 'load']);
	}
	
	  /**
	 * load classes through auto loading
	 *
	 * @param mixed $class
	 * @return void
	 */
  public function load($class){
	 if (strpos($class, "App") === 0){
		   $file = $class . ".php";
		} else {
				$file = "vendor" . DIRECTORY_SEPARATOR . $class . ".php";
		} 
			if ($this->file->exists($file)){
					 		$this->file->call($file);
					}
	}
	
	  /**
	 * get shared value
	 *
	 * @param string $key
	 * @return mixed
	 */
  public function get($key){
	  if (! $this->isSharing($key)){
	    if ($this->isCoreClass($key)){
	       $this->share($key , $this->createNewCoreObject($key));
	        }else{
	      die($key ." is not on the Application container <br> ");
	        }
	  }
	  return  $this->container[$key] ;
	}
	
	  /**
	 * Detemine  wether giving key exist in the container
	 * 
	 * @param string $key
	 * @return  bool
 	 */
  private function isSharing($key){
    return isset($this->container[$key]);
	}
	 
	  /**
	 * get shared value dynamically 
	 *
	 * @param string $key
	 * @return void
	 */
  public function __get($key){
			return $this->get($key);
	}
	
	  /**
	 * Load Helpers File
	 *
	 * @return void
	 */
  private function loadHelpers(){
			$this->file->call(static::HELPER);
	}
	
    /**
	 * viualize the givin key as preformated
	 * 
	 * @param mixed $key 
	 * @return mixed
   */
  public function pre($key){
	 return pre($key);
	}
}

	