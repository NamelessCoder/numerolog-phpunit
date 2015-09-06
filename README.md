Numerolog: PHPUnit extension
============================

Provides a new type of test case base class which contains additional assertion
methods based on the statistical information gathered and analysed by Numerolog.

Numerolog uses a remote server (a free, public one is used by default) to store
values - this package integrates that with PHPUnit to create assertions which
for example cause a failure if a value increases; and learns over time when it
decreases so that the expected maximum value goes lower and lower.

Intended purposes
-----------------

1. Assertions based on *statistical* information rather than hardcoded values.
2. An automatically "learning" way to measure performance of code during
   iterative development where each assertion "raises the bar" for the next.
3. Doing so in a distributed way that fits with CI platforms like Travis.

The assertions **can be used for execution time tracking** but should be used
very carefully for this: consistency is **vital** which means distributed tests
may not be a wise choice when asserting **time**-based statistics.

The assertions are naturally ideal for tracking values such as:

* Memory usage of expensive functions.
* Call stack analysis; maximum call depth, number of functions called, etc.
* Cyclomatic complexity tracking; guarding against peak increases/decreases.
* Lines-of-code vs lines-of-comments ratio; guarding against decreases.
* File sizes.
* And much, much more.

**A successful assertion performed on a system that has a Numerolog token will
result in a new value being recorded**. In other words: authenticated users and
systems both run tests and record statistics.

Statistics generated by `numerolog-phpunit` can then be retrieved using standard
Numerolog commands and integrations (among other things for generating charts).

Usage
-----

Require via composer using `composer require namelesscoder/numerolog-phpunit`, then
use `\NamelessCoder\NumerologPhpunit\StatisticsTestCase` as parent class for your
test cases (which otherwise follow all phpunit rules). Alternatively, you can use
the `\NamelessCoder\NumerologPhpunit\StatisticsTestCaseTrait` as trait in your class;
for those cases when that fits better with your unit tests' structure. Both methods
will provide the same functions for your test case.

There are six types of assertions to compare with various statistics:

```php
$this->assertLessThan******($counterName, $value, $count = 20);
$this->assertLessThanOrEqualTo******($counterName, $value, $count = 20);
$this->assertEqualTo******($counterName, $value, $count = 20);
$this->assertGreaterThan******($counterName, $value, $count = 20);
$this->assertGreaterThanOrEqualTo******($counterName, $value, $count = 20);
```

Where `$counterName` is a `lowerCamelCase` name of a single counter; where `$value`
is the new value you with to compare - and where `$count` is the number of values
to pull from history and use as data set in comparison.

And where the `******` can be one of the following:

* `Average`
* `Minimum`
* `Maximum`
* `Sum`

Which means a total of 20 (5 x 4) simple statistical assertion methods.

Your test methods can also perform the following more advanced assertions:

```php
// Success only if $value has a standard deviation inside specified tolerance:
$this->assertWithinStandardDeviation($counterName, $value, $allowedStandardDeviation = 1, $count = 20);

// Success if $value is above current minimum and below current maximum:
$this->assertWithinSetRange($counterName, $value, $count = 20);

// Opposite of the above
$this->assertNotWithinSetRange($counterName, $value, $count = 20);

// Success only if $value exists as an exact match (also for floats!) in set:
$this->assertExactlyWithinSetRange($counterName, $value, $count = 20);

// Opposite of the above
$this->assertNotExactlyWithinSetRange($counterName, $value, $count = 20);
```

Example
-------

When put together, a complete statistical unit test function can look like:

```php
public function testExpectedMemoryUsageOfMyFunctionOnMyClassIsSameOrLower() {
	$subject = new MyClass('myconstructorvalue');
	$monitor = new Monitor($subject);
	$subject->doSomethingMemoryIntensive(1000);
	$usage = $monitor->getMemoryUsage();
	// method always uses memory; no usage or freed memory is an early failure:
	$this->assertGreaterThan(0, $usage);
	// assertion: no more than 2 standard deviations allowed. Include 40 values in set:
	$this->assertWithinStandardDeviation('myFunctionMemoryUsage', $usage, 2, 40);
	// assertion: value should be less than or equal to average recorded usage:
	$this->assertLessThanOrEqualToAverage('myFunctionMemoryUsage', $usage, 40);
}
```

The `Monitor` class is not included and is hypothetical. Any measurement method
can be used. In this test, we have our `$subject` do something that's known to
cause a lot of memory usage - and then assert that, with the code base that we
currently are on, the usage does not deviate more than two standard deviations
from the recorded average. And we assert that the usage is either less than or
equal to the average recorded value.

Assuming the Numerolog token exists in the project doing the assertions, each
successful assertion adds to the statistical history. In this case, we are
continually testing that our memory usage does not **increase**; as well as
testing that it doesn't suddenly **decrease drastically**. Which means that as
you improve the code that gets tested, Numerolog ensures that your tests also
"learn" what to expect without you having to continually modify test cases to
change the expectations like you normally would with a unit test.

Pitfalls
--------

If the code you are testing depends on a framework or has other dependencies, make
sure you sufficiently mock all of those dependencies in PHPUnit or the numbers may
be inadvertedly skewed by changes occurring in the framework or dependency. For
example, in the hypothetical case that you have a Symfony component as dependency
and that component suddenly decreases in performance (whatever the reason may be)
then your tests may fail if you did not sufficiently mock that dependency. Obviously
the PHPUnit code itself also counts unless you are careful, e.g. don't include
calls to assertion methods or mock generation in the code window you profile.

Essentially: use **proper** unit test design to avoid unexpected problems with
the variables you profile and track.
