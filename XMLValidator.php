<?php

  class XMLValidator
  {

    public $xml;
    public $fileName;
    public $isValid;

    function __construct(string $fileName)
    {

      $this->isValid = true;

      $this->fileName = $fileName;

      $this->xml = new DOMDocument();
      $this->xml->load('files/' . $this->fileName . '.xml');
    }

    public function getErrors() : array
    {
      return libxml_get_errors();
    }

    public function validate() : bool
    {
      $this->isValid = $this->xml->schemaValidate('files/' . $this->fileName . '.xsd');
      return $this->isValid;
    }


    public function restResponse()
    {
      $response = new stdClass();
      $response->valid = true;
      $response->errors = [];


      if (!$this->isValid) {
        $response->valid = false;
        $response->errors = $this->getErrors();
      }

      echo json_encode($response);
    }

  }
