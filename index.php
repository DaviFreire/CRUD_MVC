<?php

require 'libs/Router.php';
require 'libs/Controller.php';
require 'libs/Model.php';
require 'libs/View.php';
require 'libs/Database.php';

require 'config/paths.php';
require 'config/database.php';

session_start();  
$app = new Router();

