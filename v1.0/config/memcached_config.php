<?php

/*
 * Memcached Library for Codeigniter v1.01
 * release date 07/13/2012
 * Author Erwin Setiawan 
 * visit http://erwinsetiawan.com
 * Feel free to use it and please do not remove this text.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$set_memcached = array(
    'host' => 'localhost',
    'port' => 11211,
    'prefix' => 'xxx_',
    'expiration' => 3600,
    'timeout' => 0,
    'salt' => 'd&sa23=#%'
);

$config['memcached'] = $set_memcached;

/* End of file memcached_config.php */
/* Location: ./application/libraries/memcached_library.php */