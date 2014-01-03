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
use Tasker\Tasks\Task;

/**
 * Class PharCreatorTask
 * @package PharCreator
 */
class PharCreatorTask extends Task
{
	/**
	 * @param array $config
	 * @return mixed|void
	 */
	public function run($config)
	{
		$outputs = array();
		if (count($config)) {
			foreach ($config as $dest => $options) {
				if (is_dir($options['source'])) {
					$project = new Directory($options['source'], Directory::LOAD);
				} elseif (is_file($options['source'])) {
					$project = new File($options['source'], File::LOAD);
				} else {
					$outputs[] = "Project on path {$options['source']} has not been found";

					return $outputs;
				}
				$tmpName = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $project->getBaseName() . time() . rand();
				$tmp = $project->copy($tmpName, true, true);
				$minify = new Minify($tmp);
				$minify->run();
				$phar = new \Phar($dest);
				$phar->buildFromDirectory($tmp->getPath());
				$phar->setStub("<?php\nrequire 'phar://' . __FILE__ . '/{$options['main']}';\n__HALT_COMPILER();");
				$tmp->remove();
				$outputs[] = "Phar archive {$dest} is created";
			}
		}

		return $outputs;
	}
} 