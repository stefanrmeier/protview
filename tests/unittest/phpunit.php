<?php
/*
 * (c) 2012 Damien Corpataux
 *
 * Licensed under the GNU GPL v3.0 license,
 * accessible at http://www.gnu.org/licenses/gpl-3.0.html
 *
**/

// Requires PHPUnit dependancies (using existing xfm submodules)
$vendors = __dir__.'/../../app/lib/xfm/unittests/vendors';
$paths = array(
    "{$vendors}/phpunit/",
    "{$vendors}/php-file-iterator/",
    "{$vendors}/php-code-coverage/",
    "{$vendors}/php-token-stream/",
    "{$vendors}/php-text-template/",
    "{$vendors}/php-timer/",
    "{$vendors}/phpunit-mock-objects/"
);
foreach ($paths as $path) set_include_path(
    get_include_path() . PATH_SEPARATOR . $path
);

// Requires PHPUnit library
require_once "PHPUnit/Autoload.php";

// Requires xfm custom xPHPUnit_Framework_TestCase
require_once __dir__.'/../../app/lib/xfm/unittests/lib/PHPUnit_Framework_TestCase.php';

// Requires project-specific xPHPUnit_Framework_TestCase child classes
require_once __dir__.'/lib/protviewPHPUnit_Framework_TestCase.php';

// PHPUnit autorun
if (PHP_SAPI==='cli') PHPUnit_TextUI_Command::main();








die();

define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_Command::main');

// Setups PHPUnit libs paths
$phpunit = '../app/lib/PhpUnit';
$pear = '../app/lib/PEAR';
set_include_path(get_include_path() . PATH_SEPARATOR . $pear);
set_include_path(get_include_path() . PATH_SEPARATOR . $phpunit);

// PHPUnit Autoload
require "{$phpunit}/PHPUnit/Autoload.php";

// iafbm-specific PHPUnit_Framework_TestCase classes
$lib = __DIR__.'/lib';
require_once("{$lib}/protviewPHPUnit_Framework_TestCase.php");

// PHPUnit autorun
PHPUnit_TextUI_Command::main();

?>
