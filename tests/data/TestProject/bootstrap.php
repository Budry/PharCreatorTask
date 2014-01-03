<?php
/**
 * This file is part of the PharCreator package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

require __DIR__ . '/Some/Folder/A.php';
require __DIR__ . '/Some/B.php';

$a = new \TestProject\A();
$a->setMessage($_SERVER['argv'][1]);
$b = new \TestProject\B($a);
echo $b->run();