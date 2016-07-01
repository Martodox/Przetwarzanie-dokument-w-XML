<?php

  namespace api;

  class Resources {


    public function getLoad($resource) {

      $file = simplexml_load_file(getcwd() . '/files/' . $resource . '.xml');

      return (array) $file;

    }

    public function postAddNewResource($resourcePart) {

      $uploadDir = getcwd() . '/uploads/' . md5(microtime()) . '_';

      $uploadFile = $uploadDir . basename( $_FILES['file']['name']);

      return move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);


    }

  }