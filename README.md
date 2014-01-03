# PharCreator

Task creating compress php files into once .phar file

Extension for [Tasker](https://github.com/tasker-org/Tasker)

## Installation

The best way to install budry/phar-creator is using Composer:

```bash
$ composer require budry/phar-creator:@dev
```

Before register task you must add path to directory with config file
and next register task

```php
$takser = new Tasker();
$takser->addConfig($rootPath . '/tasker.json')
	->registerTask(new PharCreatorTask($rootPath), 'phar', 'phar');
$takser->run();
```

Into tasker config file add config section
```json
{
	"phar": {
		"./testProject.phar": {
			"minify" false
			"source": "./TestProject",
			"main": "bootstrap.php"
		}
	}
}
```

Section minify is not required if you skip this section files won't minificate
