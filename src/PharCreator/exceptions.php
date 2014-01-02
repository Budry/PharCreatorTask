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

class IOException extends \LogicException
{

}

/**
 * Class DirectoryNotFoundException
 * @package PharCreator
 */
class DirectoryNotFoundException extends IOException
{

}

/**
 * Class FileNotFoundException
 * @package PharCreator
 */
class FileNotFoundException extends IOException
{

}