<?php

  include 'vendor/autoload.php';

  include "api/Users.php";

  use RestService\Server;

  Server::create('/users', 'api\Users')
    ->collectRoutes()
    ->run();