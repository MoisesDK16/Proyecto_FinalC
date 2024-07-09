<?php

//Control de acesso para permitir quien va poder interactuar con datos restringidos(cors) 
//En este caso para logearse
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers,Authorization, x-Requested-With");