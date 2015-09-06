<?php
namespace NamelessCoder\NumerologPhpunit;

use NamelessCoder\Numerolog\Client;
use Composer\Autoload\ClassLoader;

/**
 * Class StatisticalUnitTestCase
 */
abstract class StatisticalUnitTestCase extends \PHPUnit_Framework_TestCase {

	const HISTORY_SIZE = 100;
	const ASSERTION_TYPE_LESSTHAN = 'lessThan';
	const ASSERTION_TYPE_LESSTHANOREQUAL = 'lessThanOrEqual';
	const ASSERTION_TYPE_EQUALS = 'equals';
	const ASSERTION_TYPE_GREATERTHAN = 'greaterThan';
	const ASSERTION_TYPE_GREATERTHANOREQUAL = 'greaterThanOrEqual';

	use StatisticalUnitTestTrait;

}
