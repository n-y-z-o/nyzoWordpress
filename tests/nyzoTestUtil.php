<?php

define('__TEST_DIRECTORY__', dirname(__FILE__));
define('__ROOT_DIRECTORY__', dirname(__TEST_DIRECTORY__));
define('__LIB_DIRECTORY__', __ROOT_DIRECTORY__ . '/lib');

require_once(__TEST_DIRECTORY__ . '/nyzoStringTest.php');

class NyzoTestUtil {

    // TODO: replicate the ConsoleColor class from the Java codebase
    const SUCCESS_DARK = "\e[42m\e[97m";  // dark green, bright white letters
    const SUCCESS_LIGHT = "\e[102m\e[30m";  // bright green, black letters
    const FAILURE_DARK = "\e[41m\e[97m";  // dark red, bright white letters
    const FAILURE_LIGHT = "\e[101m\e[30m";  // bright red, black letters
    const CONSOLE_RESET = "\e[0m";

    static function run() {
        echo '*****************' . PHP_EOL;
        echo '* running tests *' . PHP_EOL;
        echo '*****************' . PHP_EOL . PHP_EOL;

        NyzoStringTest::run();

        echo PHP_EOL;
    }

    static function passFail(bool $successful): string {

        // Get information about the calling function.
        $backtrace = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT|DEBUG_BACKTRACE_IGNORE_ARGS,2)[1];

        // Build and return the result.
        if ($successful) {
            $result = NyzoTestUtil::SUCCESS_DARK . '++PASS++' . NyzoTestUtil::SUCCESS_LIGHT . ' ' .
                $backtrace['class'] . $backtrace['type'] . $backtrace['function'] . '()' . NyzoTestUtil::CONSOLE_RESET;
        } else {
            $result = NyzoTestUtil::FAILURE_DARK . '--FAIL--' . NyzoTestUtil::FAILURE_LIGHT . ' ' .
                $backtrace['class'] . $backtrace['type'] . $backtrace['function'] . '()' . NyzoTestUtil::CONSOLE_RESET;
        }
        return $result;
    }
}

NyzoTestUtil::run();
