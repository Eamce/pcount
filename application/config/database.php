<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'pcount-live';
$query_builder = TRUE;

$db['pcount-live'] = array(
	'dsn'	=> '',
	'hostname' => '172.16.161.100',
	'username' => 'pcount-live',
	'password' => 'pcount-live2022',
	'database' => 'pcount-live',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['pis'] = array(
	'dsn'	=> '',
	'hostname' => '172.16.161.34',
	'username' => 'pcount',
	'password' => 'pcount2021',
	'database' => 'pis',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	"port" => '3307'
);
