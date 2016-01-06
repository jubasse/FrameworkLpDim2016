<?php

use Framework\Http\Request;

require "vendor/autoload.php";

$request = new Request(Request::METHOD_GET,"/home",Request::HTTP,Request::VERSION_1_1,[
    "Content-Type" => "application/json"
],'{"foo":"bar"}');
echo "<pre>";
echo $request->getMessage();
die();
echo "</pre>";