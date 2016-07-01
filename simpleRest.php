<?php

  include 'vendor/autoload.php';

  include "api/Resources.php";

  use RestService\Server;

  Server::create('/users', 'api\Resources')
    ->collectRoutes()
    ->run();