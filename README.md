# XML Processing

##### to run the app you need composer with php7
##### execute in the root directory
```
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
```

##### then just start php7 built in server
```
$ php -S localhost:8000 routing.php
```


### Sample xml resources

```
<Customer CustomerID="GREAL">
    <CompanyName>Great Lakes Food Market</CompanyName>
    <ContactName>Howard Snyder</ContactName>
    <ContactTitle>Marketing Manager</ContactTitle>
    <Phone>(503) 555-7555</Phone>
    <FullAddress>
        <Address>2732 Baker Blvd.</Address>
        <City>Eugene</City>
        <Region>OR</Region>
        <PostalCode>97403</PostalCode>
        <Country>USA</Country>
    </FullAddress>
</Customer>
```

```
<Order>
    <CustomerID>GREAL</CustomerID>
    <EmployeeID>6</EmployeeID>
    <OrderDate>1997-05-06T00:00:00</OrderDate>
    <RequiredDate>1997-05-20T00:00:00</RequiredDate>
    <ShipInfo ShippedDate="1997-05-09T00:00:00">
        <ShipVia>2</ShipVia>
        <Freight>3.35</Freight>
        <ShipName>Great Lakes Food Market</ShipName>
        <ShipAddress>2732 Baker Blvd.</ShipAddress>
        <ShipCity>Eugene</ShipCity>
        <ShipRegion>OR</ShipRegion>
        <ShipPostalCode>97403</ShipPostalCode>
        <ShipCountry>USA</ShipCountry>
    </ShipInfo>
</Order>
```


License
-------

Licensed under the MIT License. See the LICENSE file for more details.