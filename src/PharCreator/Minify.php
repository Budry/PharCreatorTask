<?php
/**
 * This file is part of the PharCreator package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace PharCreator;

use Kappa\FileSystem\Directory;
use Kappa\FileSystem\File;
use Kappa\FileSystem\FileStorage;

/**
 * Class Minify
 * @package PharCreator
 */
class Minify 
{
	/** @var \Kappa\FileSystem\FileStorage */
	private $fileStorage;

	/**
	 * @param FileStorage $fileStorage
	 */
	public function __construct(FileStorage $fileStorage)
	{
		$this->fileStorage = $fileStorage;
	}

	/**
	 * @throws InvalidStateException
	 */
	public function run()
	{
		$shrink = new ShrinkPHP();
		$iterator =  new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->fileStorage->getPath(), \RecursiveDirectoryIterator::SKIP_DOTS));
		foreach ($iterator as $file) {
			$fileName = $file->getBaseName();
			$nameLength = strlen($fileName);
			if (substr($fileName, $nameLength - 4, $nameLength) == ".php") {
				$shrink->shrinkFile($file);
			}
		}
	}
}