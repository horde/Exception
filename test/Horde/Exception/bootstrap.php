<?php
if (!class_exists('Horde_Test_Bootstrap')) {
    require_once 'Horde/Exception/bootstrap.php';
}
Horde_Test_Bootstrap::bootstrap(dirname(__FILE__));
