<?php

  namespace api;

  use libs\XMLValidator;
  use SimpleXMLElement;
  use stdClass;

  class Resources {


    private function resourceFileName($resource) : string {

      return getcwd() . '/files/' . $resource . '.xml';

    }

    public function getLoad($resource) {

      return (array) simplexml_load_file($this->resourceFileName($resource));

    }

    public function getRemoveResource($resource) {

      $fileName = $this->resourceFileName($resource);

      $blankResource = $fileName . '.empty';

      return copy($blankResource, $fileName);

    }

    public function postAddNewResource($resourcePart) {

      $uploadDir = getcwd() . '/uploads/' . md5(microtime()) . '_';

      $uploadFile = $uploadDir . basename( $_FILES['file']['name']);

      $response = new stdClass();
      $response->uploaded = true;
      $response->fileName = '';
      $response->resourcePart = $resourcePart;

      if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        $response->uploaded = false;
      } else {
        $response->fileName = $uploadFile;
      }

      return (array) $response;

    }

    private function validateResource($fileName, $xmlMatch) {

      $validator = new XMLValidator($fileName);

      $validator->validate($xmlMatch);

      return $validator->restResponse();

    }

    public function getValidateResource($fileName, $part) {

      return $this->validateResource($fileName, 'part_' . $part);
    }

    private function createCustomerInstance($database, $Customer) {

      $Customer = (array) $Customer;

      /* @var $Customers SimpleXMLElement */
      $Customers = $database->Customers;

      /* @var $CustomerNode SimpleXMLElement */
      $CustomerNode = $Customers->addChild('Customer');

      $CustomerNode->addAttribute('CustomerID', $Customer['@attributes']['CustomerID']);

      $CustomerNode->addChild('CompanyName', $Customer['CompanyName']);
      $CustomerNode->addChild('ContactName', $Customer['ContactName']);
      $CustomerNode->addChild('ContactTitle', $Customer['ContactTitle']);
      $CustomerNode->addChild('Phone', $Customer['Phone']);

      /* @var $FullAddress SimpleXMLElement */
      $FullAddress = $CustomerNode->addChild('FullAddress');

      $FullAddress->addChild('Address', $Customer['FullAddress']->Address);
      $FullAddress->addChild('City', $Customer['FullAddress']->City);
      $FullAddress->addChild('Region', $Customer['FullAddress']->Region);
      $FullAddress->addChild('PostalCode', $Customer['FullAddress']->PostalCode);
      $FullAddress->addChild('Country', $Customer['FullAddress']->Country);


      return $database;

    }

    /**
     * @param $database
     * @param $Order
     * @return mixed
     */
    private function createOrderInstance($database, $Order) {

      $Order = (array) $Order;

      /* @var $Orders SimpleXMLElement */
      $Orders = $database->Orders;

      /* @var $OrderNode SimpleXMLElement */
      $OrderNode = $Orders->addChild('Order');
      
      $OrderNode->addChild('CustomerID', $Order['CustomerID']);
      $OrderNode->addChild('EmployeeID', $Order['EmployeeID']);
      $OrderNode->addChild('OrderDate', $Order['OrderDate']);
      $OrderNode->addChild('RequiredDate', $Order['RequiredDate']);
      


      /* @var $ShipInfo SimpleXMLElement */
      $ShipInfo = $OrderNode->addChild('ShipInfo');


      $ShipInfoData = (array) $Order['ShipInfo'];


      $ShipInfo->addAttribute('ShippedDate', $ShipInfoData['@attributes']['ShippedDate']);

      $ShipInfo->addChild('ShipVia', $ShipInfoData['ShipVia']);
      $ShipInfo->addChild('Freight', $ShipInfoData['Freight']);
      $ShipInfo->addChild('ShipName', $ShipInfoData['ShipName']);
      $ShipInfo->addChild('ShipAddress', $ShipInfoData['ShipAddress']);
      $ShipInfo->addChild('ShipCity', $ShipInfoData['ShipCity']);
      $ShipInfo->addChild('ShipRegion', $ShipInfoData['ShipRegion']);
      $ShipInfo->addChild('ShipPostalCode', $ShipInfoData['ShipPostalCode']);
      $ShipInfo->addChild('ShipCountry', $ShipInfoData['ShipCountry']);


      return $database;

    }


    public function getAppendResource($resource, $fileName, $part) {

      $validate = $this->validateResource($fileName, 'part_' . $part);

      if (!$validate['valid']) {
        throw new \Exception('file not valid');
      }

      $databaseFile = $this->resourceFileName($resource);

      /* @var $database SimpleXMLElement */
      $database = simplexml_load_file($databaseFile);


      if($part == 'customer') {
        $this->createCustomerInstance($database, simplexml_load_file($fileName));
      } else {
        $this->createOrderInstance($database, simplexml_load_file($fileName));
      }

      return $database->asXML($databaseFile);


    }

  }