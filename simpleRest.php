<?php

  include 'vendor/autoload.php';

  include "api/Resources.php";

  use RestService\Server;

  Server::create('/resources', 'api\Resources')
    ->collectRoutes()
    ->run();