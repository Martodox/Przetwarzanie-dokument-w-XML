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
        $this->xml->load($this->fileName);
      }
    }

    public function getErrors() : array
    {
      return libxml_get_errors();
    }

    public function validate($matchAgainst) : bool
    {
      $this->isValid = $this->xml->schemaValidate('files/' . $matchAgainst . '.xsd');
      return $this->isValid;
    }


    public static function arrayToXml($data, &$xml_data) {
      foreach( $data as $key => $value ) {
        if( is_array($value) ) {
          if( is_numeric($key) ){
            $key = 'item'.$key;
          }
          $subnode = $xml_data->addChild($key);
          self::arrayToXml($value, $subnode);
        } else {
          $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
      }
    }


    public function restResponse() : array
    {
      $response = new stdClass();
      $response->valid = true;
      $response->errors = [];


      if (!$this->isValid) {
        $response->valid = false;
        $response->errors = $this->getErrors();
      }

      return (array) $response;
    }

  }
