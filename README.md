Nette Errbit (Airbrake) error logger
===================================

Errbit (Airbrake) error handler for nette applications.
For communication with errbit it use package [flippa/errbit-php](https://github.com/flippa/errbit-php). 

[![Build Status](https://secure.travis-ci.org/tomaj/nette-errbit.png)](http://travis-ci.org/tomaj/nette-errbit)
[![Code Climate](https://codeclimate.com/github/tomaj/nette-errbit/badges/gpa.svg)](https://codeclimate.com/github/tomaj/nette-errbit)

[![Latest Stable Version](https://poser.pugx.org/tomaj/nette-errbit/v/stable.svg)](https://packagist.org/packages/tomaj/nette-errbit)
[![Latest Unstable Version](https://poser.pugx.org/tomaj/nette-errbit/v/unstable.svg)](https://packagist.org/packages/tomaj/nette-errbit)
[![License](https://poser.pugx.org/tomaj/nette-errbit/license.svg)](https://packagist.org/packages/tomaj/nette-errbit)


**Warning:** This logger isn't working well od developemnt mode in nette. Handling errors in production is fine. In development you have Tracy with all stack trace and you don't need to log this errros on errbit.

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
Tomaj\Errbit\ErrbitLogger::ignoreNotices();
Tomaj\Errbit\ErrbitLogger::addIgnoreMessage('Some exception message text');

// Default log priorities: error, exception. To rewrite call:
Tomaj\Errbit\ErrbitLogger::setLogPriorities(array('error', 'exception', 'access'));
```

**Thats it!** You should see your logs in your errbit



