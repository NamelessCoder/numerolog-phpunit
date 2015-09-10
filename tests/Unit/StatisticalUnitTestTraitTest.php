<?php
namespace NamelessCoder\NumerologPhpunit\Tests\Unit;

use NamelessCoder\Numerolog\NotFoundException;
use NamelessCoder\NumerologPhpunit\StatisticalUnitTestCase;
use NamelessCoder\NumerologPhpunit\StatisticalUnitTestTrait;
use NamelessCoder\Numerolog\Client;

/**
 * Class StatisticalUnitTestTraitTest
 */
class StatisticalUnitTestTraitTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @param string $methodName
	 * @param string $statistic
	 * @param string $assertionType
	 * @dataProvider getAssertionWrapperMethodTestValues
	 */
	public function testAssertionWrapperMethod($methodName, $statistic, $assertionType) {
		$dummyValue = 10;
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)
			->setMethods(array('performStandardAssertionOnStatisticsCounter'))
			->getMockForTrait();
		$subject->expects($this->once())->method('performStandardAssertionOnStatisticsCounter')->with(
			'foobar-counter',
			$statistic,
			$assertionType,
			$dummyValue,
			40
		)->willReturn($dummyValue);
		$method = new \ReflectionMethod($subject, $methodName);
		$method->setAccessible(TRUE);
		$method->invokeArgs($subject, array('foobar-counter', $dummyValue, 40));
	}

	/**
	 * @return array
	 */
	public function getAssertionWrapperMethodTestValues() {
		return array(
			array('assertLessThanMinimum', 'min', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN),
			array('assertLessThanOrEqualToMinimum', 'min', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL),
			array('assertEqualToMinimum', 'min', StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS),
			array('assertGreaterThanMinimum', 'min', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN),
			array('assertGreaterThanOrEqualToMinimum', 'min', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL),
			array('assertLessThanAverage', 'average', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN),
			array('assertLessThanOrEqualToAverage', 'average', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL),
			array('assertEqualToAverage', 'average', StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS),
			array('assertGreaterThanAverage', 'average', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN),
			array('assertGreaterThanOrEqualToAverage', 'average', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL),
			array('assertLessThanMaximum', 'max', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN),
			array('assertLessThanOrEqualToMaximum', 'max', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL),
			array('assertEqualToMaximum', 'max', StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS),
			array('assertGreaterThanMaximum', 'max', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN),
			array('assertGreaterThanOrEqualToMaximum', 'max', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL),
			array('assertLessThanSum', 'sum', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHAN),
			array('assertLessThanOrEqualToSum', 'sum', StatisticalUnitTestCase::ASSERTION_TYPE_LESSTHANOREQUAL),
			array('assertEqualToSum', 'sum', StatisticalUnitTestCase::ASSERTION_TYPE_EQUALS),
			array('assertGreaterThanSum', 'sum', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHAN),
			array('assertGreaterThanOrEqualToSum', 'sum', StatisticalUnitTestCase::ASSERTION_TYPE_GREATERTHANOREQUAL),
		);
	}

	/**
	 * @test
	 */
	public function testPerformStandardAssertionOnStatisticsCounterIgnoresNotFoundExceptionAndSavesIfTokenIsSet() {
		$client = $this->getMockBuilder(Client::class)->setMethods(array('get', 'getPackage', 'getToken', 'save'))->getMock();
		$client->expects($this->once())->method('getPackage')->willReturn('foobar-package');
		$client->expects($this->once())->method('get')->willThrowException(new NotFoundException());
		$client->expects($this->once())->method('getToken')->willReturn('foobar-token');
		$client->expects($this->once())->method('save');
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)
			->setMethods(array('getNumerologClient', 'assertLessThanOrEqual'))
			->getMockForTrait();
		$subject->expects($this->once())->method('getNumerologClient')->willReturn($client);
		$subject->expects($this->never())->method('assertLessThanOrEqual');
		$method = new \ReflectionMethod($subject, 'performStandardAssertionOnStatisticsCounter');
		$method->setAccessible(TRUE);
		$method->invokeArgs($subject, array('foobar-counter', 'average', 'lessThanOrEqual', 30, 50));
	}

	/**
	 * @test
	 */
	public function testPerformStandardAssertionOnStatisticsCounterRethrowsNotFoundExceptionIfTokenIsSet() {
		$client = $this->getMockBuilder(Client::class)->setMethods(array('get', 'getPackage', 'getToken'))->getMock();
		$client->expects($this->once())->method('getPackage')->willReturn('foobar-package');
		$client->expects($this->once())->method('get')->willThrowException(new NotFoundException());
		$client->expects($this->once())->method('getToken')->willReturn(NULL);
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)
			->setMethods(array('getNumerologClient', 'assertLessThanOrEqual'))
			->getMockForTrait();
		$subject->expects($this->once())->method('getNumerologClient')->willReturn($client);
		$subject->expects($this->never())->method('assertLessThanOrEqual');
		$method = new \ReflectionMethod($subject, 'performStandardAssertionOnStatisticsCounter');
		$method->setAccessible(TRUE);
		$this->setExpectedException(NotFoundException::class);
		$method->invokeArgs($subject, array('foobar-counter', 'average', 'lessThanOrEqual', 30, 50));
	}

	/**
	 * @test
	 */
	public function testPerformStandardAssertionOnStatisticsCounterAssertsTrueIfNoStatisticsRecorded() {
		$client = $this->getMockBuilder(Client::class)->setMethods(array('get', 'getPackage'))->getMock();
		$client->expects($this->once())->method('getPackage')->willReturn('foobar-package');
		$client->expects($this->once())->method('get')->with('foobar-package', $this->anything(), 50)->willReturn(array());
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)
			->setMethods(array('getNumerologClient', 'assertTrue'))
			->getMockForTrait();
		$subject->expects($this->once())->method('getNumerologClient')->willReturn($client);
		$subject->expects($this->once())->method('assertTrue')->with(TRUE);
		$method = new \ReflectionMethod($subject, 'performStandardAssertionOnStatisticsCounter');
		$method->setAccessible(TRUE);
		$method->invokeArgs($subject, array('foobar-counter', 'average', 'lessThanOrEqual', 30, 50));
	}

	/**
	 * @test
	 */
	public function testPerformStandardAssertionOnStatisticsCounter() {
		$client = $this->getMockBuilder(Client::class)->setMethods(array('get', 'getPackage'))->getMock();
		$client->expects($this->once())->method('getPackage')->willReturn('foobar-package');
		$client->expects($this->once())->method('get')->with('foobar-package', $this->anything(), 50)->willReturn(array(
			'statistics' => array(
				'average' => 20
			)
		));
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)
			->setMethods(array('getNumerologClient', 'assertLessThanOrEqual'))
			->getMockForTrait();
		$subject->expects($this->once())->method('getNumerologClient')->willReturn($client);
		$subject->expects($this->once())->method('assertLessThanOrEqual')->with(20, 30, $this->anything());
		$method = new \ReflectionMethod($subject, 'performStandardAssertionOnStatisticsCounter');
		$method->setAccessible(TRUE);
		$method->invokeArgs($subject, array('foobar-counter', 'average', 'lessThanOrEqual', 30, 50));
	}

	/**
	 * @test
	 */
	public function testGetNumerologClientThrowsRuntimeExceptionIfManifestHasNoName() {
		$manifest = array();
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)
			->setMethods(array('getComposerManifest'))
			->getMockForTrait();
		$subject->expects($this->once())->method('getComposerManifest')->willReturn(array(NULL, $manifest));
		$method = new \ReflectionMethod($subject, 'getNumerologClient');
		$method->setAccessible(TRUE);
		$this->setExpectedException('RuntimeException');
		$method->invoke($subject);
	}

	/**
	 * @param array $manifest
	 * @param array $expectedAttributes
	 * @dataProvider getClientTestValues
	 * @test
	 */
	public function testGetNumerologClientReturnsConfiguredClient(array $manifest, array $expectedAttributes) {
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)
			->setMethods(array('getComposerManifest'))
			->getMockForTrait();
		$subject->expects($this->once())->method('getComposerManifest')->willReturn(array(NULL, $manifest));
		$method = new \ReflectionMethod($subject, 'getNumerologClient');
		$method->setAccessible(TRUE);
		$client = $method->invoke($subject);
		foreach ($expectedAttributes as $name => $value) {
			$this->assertAttributeEquals($value, $name, $client);
		}
	}

	/**
	 * @return array
	 */
	public function getClientTestValues() {
		return array(
			array(
				array('name' => 'test/test'),
				array('package' => 'test/test')
			),
			array(
				array('name' => 'test/test', 'extra' => array('namelesscoder/numerolog' => array('host' => 'foobar'))),
				array('package' => 'test/test', 'endPointUrl' => 'foobar')
			)
		);
	}

	/**
	 * @test
	 */
	public function testResolvesComposerFile() {
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)->setMethods(array('dummy'))->getMockForTrait();
		$method = new \ReflectionMethod($subject, 'getComposerManifest');
		$method->setAccessible(TRUE);
		$result = $method->invokeArgs($subject, array('numerolog-phpunit/composer.json'));
		$this->assertNotEmpty($result);
	}

	/**
	 * @test
	 */
	public function testResolvesComposerFileThrowsRuntimeExceptionOnMissingManifest() {
		$subject = $this->getMockBuilder(StatisticalUnitTestTrait::class)->setMethods(array('dummy'))->getMockForTrait();
		$method = new \ReflectionMethod($subject, 'getComposerManifest');
		$method->setAccessible(TRUE);
		$this->setExpectedException('RuntimeException');
		$method->invokeArgs($subject, array('notfound.json'));
	}

}
