<?php

define('__TEST_DIRECTORY__', dirname(__FILE__));
define('__ROOT_DIRECTORY__', dirname(__TEST_DIRECTORY__));
define('__LIB_DIRECTORY__', __ROOT_DIRECTORY__ . '/lib');

require_once(__TEST_DIRECTORY__ . '/nyzoStringTest.php');

class NyzoTestUtil {

    static function run() {
        echo '*****************' . PHP_EOL;
        echo '* running tests *' . PHP_EOL;
        echo '*****************' . PHP_EOL . PHP_EOL;

        NyzoStringTest::run();

        echo PHP_EOL;
    }
}

NyzoTestUtil::run();
