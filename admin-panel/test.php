<?php

$jsonData = "[{ \"name\": \"John\", \"rollno\": \"12\", \"age\": \"26\", \"marks\": [23, 45, 35] }, { \"name\": \"Krishna\", \"rollno\": \"12\", \"age\": \"26\", \"marks\": [23, 45, 35] }, { \"name\": \"Rahul\", \"rollno\": \"12\", \"age\": \"26\", \"marks\": [23, 45, 35] }]";

$arrayData = json_decode($jsonData, true);

print_r($arrayData[1]['name']);


?>