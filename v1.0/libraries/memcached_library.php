<?php
/*
 * Memcached Library for Codeigniter v1.01
 * release date 07/13/2012
 * Author Erwin Setiawan 
 * visit http://erwinsetiawan.com
 * contact erwin.stwn@gmail.com
 * Feel free to use it and please do not remove this text.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Memcached_library extends CI_Config {

    private $CI;
    private $memcached_config;
    private $m;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->config('memcached_config');
        $this->memcached_config = $this->CI->config->item('memcached');

        //connect to memcache server
        $this->_connect();
    }

    private function _connect() {
        try {
            $this->m = new Memcache;
            $this->m->connect($this->memcached_config['host'], $this->memcached_config['port']);
        } catch (Exception $e) {
            log_message('info', 'Memcached Connection problem : ' . $e->getMessage());
            echo 'Error in Memcached connection.';
            exit;
        }
    }

    private function _create_key($key) {
        $full_key = $this->memcached_config['prefix'] . $key;
        return md5($full_key . $this->memcached_config['salt']);
    }

    public function set($key, $data, $flag=false, $expires=null) {
        if (is_null($expires)) {
            $expires = $this->memcached_config['expiration'];
        }

        $key_name = $this->_create_key($key);
        $this->m->set($key_name, $data, $flag, $expires);
    }

    public function replace($key, $data, $flag=false, $expires=null) {
        if (is_null($expires)) {
            $expires = $this->memcached_config['expiration'];
        }

        $key_name = $this->_create_key($key);
        $this->m->replace($key_name, $data, $flag, $expires);
    }

    public function get($key) {
        $key_name = $this->_create_key($key);
        return $this->m->get($key_name);
    }

    public function delete($key, $timeout = 0) {
        if (is_null($timeout)) {
            $timeout = $this->memcached_config['timeout'];
        }

        $key_name = $this->_create_key($key);
        $this->m->delete($key_name, $timeout);
    }

    public function flush() {
        $this->m->flush();
        sleep(1);
    }

    function close() {
        $this->m->close();
        log_message('debug', 'Closed Memcache connection.');
    }

}

/* End of file memcached_library.php */
/* Location: ./application/libraries/memcached_library.php */
