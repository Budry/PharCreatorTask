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

/**
 * Class ShrinkPHP
 * @package PharCreator
 * @author David Grudl (https://github.com/nette/build-tools/blob/master/tasks/minify.php)
 */
class ShrinkPHP
{
	/** @var null */
	public $firstComment = NULL;

	/**
	 * @param string $file
	 */
	public function shrinkFile($file)
	{
		$tokens = token_get_all(file_get_contents($file));
		$set = '!"#$&\'()*+,-./:;<=>?@[\]^`{|}';
		$space = FALSE;
		$output = '';

		while (list(, $token) = each($tokens))
		{
			list($name, $token) = is_array($token) ? $token : array(NULL, $token);

			if ($name === T_COMMENT || $name === T_WHITESPACE) {
				$space = TRUE;
				continue;

			} elseif ($name === T_DOC_COMMENT) {
				if (!$this->firstComment) {
					$this->firstComment = $token;
					$space = TRUE;
					continue;

				} elseif (preg_match('# @[mA-Z]#', $token)) { // phpDoc annotations leave unchanged

				} else {
					$space = TRUE;
					continue;
				}

			} elseif ($token === ')' && substr($output, -1) === ',') {  // array(... ,)
				$output = substr($output, 0, -1);
			}

			if ($space) {
				if (strpos($set, substr($output, -1)) === FALSE && strpos($set, $token{0}) === FALSE) {
					$output .= "\n";
				}
				$space = FALSE;
			}

			$output .= $token;
		}

		$output = str_replace("\r\n", "\n", $output);
		$output = trim(preg_replace("#[\t ]+(\r?\n)#", '$1', $output)); // right trim
		file_put_contents($file, $output);
	}
}