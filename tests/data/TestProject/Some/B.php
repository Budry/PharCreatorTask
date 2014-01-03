<?php
/**
 * This file is part of the PharCreator package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace TestProject;

class B 
{
	private $classA;

	public function __construct(A $classA)
	{
		$this->classA = $classA;
	}

	public function run()
	{
		return $this->classA->getMessage() . PHP_EOL;
	}
} 