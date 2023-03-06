<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('cart', 'twig', 'database', 'session', 'pagination');

$autoload['drivers'] = array();

$autoload['helper'] = array('jwt_helper', 'socitur_helper', 'url', 'file', 'form');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('Crud_Model');

$autoload['time_zone'] = date_default_timezone_set('Europe/Istanbul');