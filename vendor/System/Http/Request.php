<?php
namespace System\Http;

class Request{
   
     /**
     * the url 
     * 
     * @var string
     */
    private $url;
    
     /**
     * the base url
     * 
     * @var string
     */
    private $baseUrl;
    
     /**
    * @param \System\Application $app
    * @return object \System\Request
    */
    public function __construct(){}
  
      /**
     * prepare url
     * 
     * @return void 
     */
    public function prepareUrl()
    {
      $script = dirname($this->server('SCRIPT_NAME'));
      $requestUri = $this->server('REQUEST_URI');
      if (strpos($requestUri , '?') !== false)
      {
        list($requestUri , $queryString) = explode('?',$requestUri);
      }
      $this->url = preg_replace('#^' . $script . '#' , '', $requestUri);
      $this->baseUrl = $this->server('REQUEST_SCHEME') . "://" . $this->server('HTTP_HOST') . $script .'/';
      
    
   }
  
     /**
    * Get Value From the Server 
    * using the Given key
    * 
    * @param string $key 
    * @param mixed $default
    * @return mixed
    */
    public function server($key , $default = null)
    {
    return array_get($_SERVER, $key , $default);
   }
  
     /**
    * Get Value From Get
    * using the Given key
    * 
    * @param string $key 
    * @param mixed $default
    * @return mixed
    */
    public function get($key , $default = null){
    return array_get($_GET, $key , $default);
   }
  
     /**
    * Get Value From Post
    * using the Given key
    * 
    * @param string $key 
    * @param mixed $default
    * @return mixed
    */
    public function post($key , $default = null){
    return array_get($_POST, $key , $default);
   }
   
     /**
    * Get current Request Method
    * 
    * @return string
    */
    public function method(){
     return $this->server('REQUEST_METHOD');
   }
   
     /**
    * Get The Base url
    * 
    * @return string
    */
    public function baseUrl(){
     return $this->baseUrl;
   }
   
     /**
     * get only relative url (clean url)
     * 
     * @return string
     */
    public function url(){
     return $this->url;
   }
}