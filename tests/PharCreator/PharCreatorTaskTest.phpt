<?php
/**
 * This file is part of the PharCreator package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 * 
 * @testCase
 */

namespace PharCreator\Tests;

use Kappa\Tester\TestCase;
use PharCreator\PharCreatorTask;
use Tasker\Tasker;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

/**
 * Class PharCreatorTaskTest
 * @package PharCreator\Tests
 */
class PharCreatorTaskTest extends TestCase
{
	/** @var \PharCreator\PharCreatorTask */
	private $pharCreatorTask;

	/** @var string */
	private $dataPath;

	protected function setUp()
	{
		$this->dataPath = __DIR__ . '/../data';
		$this->pharCreatorTask = new PharCreatorTask($this->dataPath);
	}

	public function testRun()
	{
		$testFile = $this->dataPath . DIRECTORY_SEPARATOR . 'testProject.phar';
		Assert::false(file_exists($testFile));
		$takser = new Tasker();
		$takser->addConfig($this->dataPath . '/tasker.json')
			->registerTask(new PharCreatorTask($this->dataPath), 'phar', 'phar');
		$takser->run();
		Assert::true(file_exists($testFile));
		Assert::same("Hello world!".PHP_EOL, shell_exec("php {$testFile} \"Hello world!\""));
		Assert::true(unlink($testFile));
	}
}

\run(new PharCreatorTaskTest());