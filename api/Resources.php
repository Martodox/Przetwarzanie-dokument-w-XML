<?php

  namespace api;

  class Resources {


    public function getResource($resource){

      $file = simplexml_load_file(getcwd() . '/files/' . $resource . '.xml');

      return (array) $file;

    }

  }