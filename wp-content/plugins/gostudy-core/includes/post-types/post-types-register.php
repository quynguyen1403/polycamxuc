<?php

class RTPostTypesRegister
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            return new self();
        }

        return self::$instance;
    }

    public function init()
    {
        if (!class_exists('Gostudy_Theme_Helper')) {
            return;
        }
        new Footer();
        new Header();
    }
}

require_once plugin_dir_path(dirname(__FILE__)) . 'post-types/footer/class-pt-footer.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'post-types/header/class-pt-header.php';
