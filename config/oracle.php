<?php

use Illuminate\Support\Facades\DB;

return [

    'dbedi' => [
        'driver' => 'oracle',
        'hostname' => '10.16.40.28',
        'port'     => 1521,
        'database' => 'SBABJTE',
        'username' => 'dbage',
        'password' => 'dbage',
        'charset'  => 'AL32UTF8',
        'prefix'   => '',
    ],
    
    'objapp_test' => [
        'driver' => 'oracle',
        'hostname' => '10.16.1.50',
        'port'     => 1521,
        'database' => 'SBABJTE',
        'username' => 'objapp_test',
        'password' => 'objapp_test',
        'charset'  => 'AL32UTF8',
        'prefix'   => 'HBLN_',
    ],
    'objapp_test_2' => [
        'driver' => 'oracle',
        'hostname' => '10.16.1.50',
        'port'     => 1521,
        'database' => 'SBABJTE',
        'username' => 'objapp_test',
        'password' => 'objapp_test',
        'charset'  => 'AL32UTF8',
        'prefix'   => '',
    ],



];
