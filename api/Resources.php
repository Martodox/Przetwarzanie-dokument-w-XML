<?php

  namespace api;

  class Resources {


    public function getLoad($resource){

      $file = simplexml_load_file(getcwd() . '/files/' . $resource . '.xml');

      return (array) $file;

    }

  }