SocietasPro
===========

Society and community group management system.

Please report any bugs on Github:
https://github.com/xmeltrut/SocietasPro/issues

Developers
----------

A nightly build of the code documentation can be found at:
http://docs.societaspro.org/

Testing
-------

Any changes should be run through the tests in the tests/ directory. These are not included in the general software releases, but can be accessed via Git in the usual manner. The unit tests use PHPUnit and there is also a Bug Scanner module which looks for simple mistakes like leaving print_r's in your code.

PHPUnit

	@todo Add instructions

PHP CodeSniffer

	@todo Add instructions

PHP Mess Detector

	phpmd ./application text application/Resources/build/phpmd.xml

PHP Copy & Paste Detector

	phpcpd ./application

To do list
----------

* Reduce directories in Framework
* Re-work framework accordingly
* Make use of cache folder and templates_c
* Update .gitignore file
* Do something with Scanner
* Check throwing of Exceptions
* JSLint integration
