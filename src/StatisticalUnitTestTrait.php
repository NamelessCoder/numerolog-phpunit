<?php
namespace NamelessCoder\NumerologPhpunit;

use NamelessCoder\Numerolog\Client;
use NamelessCoder\Numerolog\NotFoundException;

/**
 * Class StatisticalUnitTestTrait
 */
trait StatisticalUnitTestTrait {

	/**
	 * @var Client
	 */
	protected static $numerologClient;

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanMinimum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'min',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanOrEqualToMinimum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'min',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertEqualToMinimum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'min',
			StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanMinimum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'min',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanOrEqualToMinimum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'min',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanAverage($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'average',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanOrEqualToAverage($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'average',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertEqualToAverage($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'average',
			StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanAverage($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'average',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanOrEqualToAverage($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'average',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanMaximum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'max',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanOrEqualToMaximum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'max',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertEqualToMaximum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'max',
			StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanMaximum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'max',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanOrEqualToMaximum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'max',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanSum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'sum',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertLessThanOrEqualToSum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'sum',
			StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertEqualToSum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'sum',
			StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanSum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'sum',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param float $value
	 * @param integer $count
	 * @return void
	 */
	protected function assertGreaterThanOrEqualToSum($counterName, $value, $count = StatisticalUnitTestCase::HISTORY_SIZE) {
		$this->performStandardAssertionOnStatisticsCounter(
			$counterName,
			'sum',
			StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL,
			$value,
			$count
		);
	}

	/**
	 * @param string $counterName
	 * @param string $statisticsName
	 * @param string $assertionType
	 * @param float $value
	 * @param integer $count
	 */
	protected function performStandardAssertionOnStatisticsCounter(
		$counterName,
		$statisticsName,
		$assertionType,
		$value,
		$count = 20
	) {
		$client = $this->getNumerologClient();
		$token = $client->getToken();
		try {
			$packageName = $client->getPackage();
			$response = $client->get($packageName, $counterName, $count);
			$expected = $response['statistics'][$statisticsName];
			$assertionMethod = 'assert' . ucfirst($assertionType);
			$this->$assertionMethod(
				$expected,
				$value,
				sprintf(
					'Value %s failed assertion %s against statistical counter %s which had value %s',
					$value,
					$assertionType,
					$counterName,
					$expected
				)
			);
		} catch (NotFoundException $error) {
			if (empty($token)) {
				throw $error;
			}
		}
		if (!empty($token)) {
			$client->save($packageName, $counterName, $value);
		}
	}

	/**
	 * @return Client
	 */
	protected function getNumerologClient() {
		if (!isset(static::$numerologClient)) {
			list ($directory, $composer) = $this->getComposerManifest();
			if (!isset($composer['name'])) {
				throw new \RuntimeException('Composer manifest does not contain a "name"');
			}
			$client = new Client();
			$client->setPackage($composer['name']);
			if (isset($composer['extra']['namelesscoder/numerolog']['host'])) {
				$client->setEndPointUrl($composer['extra']['namelesscoder/numerolog']['host']);
			}
			$tokenFile = $directory . '.numerolog-token-' . sha1($composer['name']);
			$client->setToken(file_exists($tokenFile) ? trim(file_get_contents($tokenFile)) : NULL);
			static::$numerologClient = $client;
		}
		return static::$numerologClient;
	}

	/**
	 * @param string $manifestFilename
	 * @throws \RuntimeException
	 * @return array
	 */
	protected function getComposerManifest($manifestFilename = 'composer.json') {
		// Make sure we start at the root of this current package. Allow 7 jumps
		// upwards in folders, which allows for a maximum of 4 nested folders in
		// the "vendor-dir" setting if it is custom. Which should be enough...
		$jumps = 7;
		$path = realpath(__DIR__ . '/../../') . '/';
		$candidate = NULL;
		do {
			$candidate = $path . $manifestFilename;
		} while ($jumps > 0 && --$jumps && !file_exists($candidate) && $path = realpath($path . '/../') . '/');
		if (!file_exists($candidate)) {
			throw new \RuntimeException('Could not resolve path to composer.json');
		}
		return array(
			$path . '/',
			json_decode(file_get_contents($candidate), JSON_OBJECT_AS_ARRAY)
		);
	}

}
