<?php

  namespace libs;

  use DOMDocument;
  use stdClass;

  class XMLValidator
  {

    public $xml;
    public $fileName;
    public $isValid;

    /**
     * XMLValidator constructor.
     * @param string $fileName
     */

    function __construct(string $fileName)
    {

      $this->isValid = true;

      $this->fileName = $fileName;

      $this->xml = new DOMDocument();
      if (!empty($this->fileName)) {
        $this->xml->load('files/' . $this->fileName . '.xml');
      }
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
