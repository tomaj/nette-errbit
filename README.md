Nette Errbit (Airbrake) error logger
===================================

Errbit (Airbrake) error handler for nette applications.
For communication with errbit it use package [flippa/errbit-php](https://github.com/flippa/errbit-php). 

Instalation
-----------

Install package via composer:

``` bash
composer require tomaj/nette-errbit
```

Usage
-----

In Nette application add config file:


``` yml
parameters:
	errbit:
		send_errors: true
		api_key: your-api-key
		host: errbit-host.com
		port: 80                                        # optional
		secure: false                                   # optional
		project_root: /your/project/root                # optional
		environment_name: production                    # optional
		params_filters: ['/password/', '/card_number/'] # optional
		backtrace_filters: ['#/some/long/path#']        # optional
```

All configurations are based on package [flippa/errbit-php](https://github.com/flippa/errbit-php)

In nette application you add this line to *bootstrap.php* after you create *$container*:

``` php
Tomaj\Errbit\ErrbitLogger::register($container->parameters['errbit']);
```

**Thats it!** You should see your logs in your errbit


