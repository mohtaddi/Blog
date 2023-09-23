<?php

namespace System\View;

interface ViewInterface {
    /**
   * Get The View Output
   * 
   * @return string
   */
  public function getOutPut();
  
    /**
   * Covert The View Object To String in printing
   * i.e echo $object
   * 
   * @return string
   */
  public function __toString();
}