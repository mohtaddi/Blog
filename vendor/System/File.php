<?php

	namespace System;
	
	class File
{
	 /**
	* Directory Separator 
	*
	* @const string
	*/
	const DS = DIRECTORY_SEPARATOR;
	
	 /**
	* Root Path
	*
	* @var String
	*/
	private $root;
	
	 /**
	* constructor
	*
	* @param string $root
	* @return mixed
	*/
 	public function __construct($root){
			
				$this->root = $root;
	
	}
	
	 /**
	* determine whether the given file path exists
	*
	* @param string $file
	* @return bool
	*/
	public function exists($file){
		
		return file_exists($this->
		to($file));
		}
		
   /**
	 *  generate full path to the giving path in vendor
	 *
	 * @param string $path
	 * @return string
	 */
	public function toVendor($path){
			
			return $this->to("vendor". static::DS . $path);
			
		}
		
	 /**
	 *  generate full path to the giving path 
	 *
	 * @param string $path
	 * @return string
	 */
	public function to($path){
			return $this->root . static::DS . str_replace(["/", "\\"], static::DS, $path) ; 
		}
		
   /**
	 * require class files
	 *
	 * @param string $file
	 * @return void
	 */
	public function call($file){
	  $file = str_replace('/' , static::DS, $file);
			return require $this->to($file);
	}
	
}
		







		
	