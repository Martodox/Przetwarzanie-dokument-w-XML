<?php

  include 'vendor/autoload.php';

  include "api/Resources.php";

  include 'libs/XMLValidator.php';

  use RestService\Server;

  libxml_use_internal_errors(true);


  Server::create('/resources', 'api\Resources')
    ->collectRoutes()
    ->run();