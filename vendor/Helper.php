<?php
use \System\Application;
if (! function_exists('pre')){
    /**
   *  Visualize the givin value into browser
   * 
   * @param mixed $data
   * @return void
   */
    function pre($data){
    	echo "<pre>";
    	print_r($data);
    	echo "</pre> <br><br>";
    	}
  }

if (! function_exists('array_get')){
      /**
     *  get the givin value from givin array
     *  for the givin key if found
     *  otherwise get the default value
     * 
     * @param mixed $array
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
     function array_get($array ,$key ,$default){
       if (isset($array[$key]) ){
         return $array[$key];
       } else{
         return $default;
       } 
     }
   }
     
     if (! function_exists('_e')){
       /**
        * escape the given value 
        * 
        * @param string $value
        * @return string
        */
        function _e($value){
          return htmlspecialchars($value);
        }
     }
     
      if (! function_exists('assets')){
       /**
        * get the assets url
        * 
        * @param string $value
        * @return string
        */
        function assets($path){
            /**
          * To Do : Find why its give an error
          *  on using $this->app
          * insted of using object of Application
         */ 
          $app =  Application::getInstance();
          $path = trim($path , '/' );
          return $app->url->link('public/admin/' . $path);
        }
     }

     

     if (! function_exists('redirectTo')){
       /**
        * redirect to givin url
        * 
        * @param string $url
        * @return string
        */
        function redirectTo($url){
            /**
          * To Do : Find why its give an error
          *  on using $this->app
          * insted of using object of Application
         */ 
          $app =  Application::getInstance();
          return $app->url->redirectTo($url);
        }
     }
     
     
     
     if (! function_exists('link')){
       /**
        * get full path of givin url
        * 
        * @param string $url
        * @return string
        */
        function link($url){
            /**
          * To Do : Find why its give an error
          *  on using $this->app
          * insted of using object of Application
         */ 
          $app =  Application::getInstance();
           return $app->request->baseUrl() . trim($url ,'/');
        }
     }