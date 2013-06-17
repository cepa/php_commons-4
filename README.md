php_commons-4
=============

PHP Commons is a set of utility libraries for various types of PHP based projects.
Requires PHP 5.3+

Features
--------
-   Commons/Application - Abstract application (Web, CLI)
-   Commons/Autoloader - Simple SPL/PSR autoloader
-   Commons/Buffer - Output buffer wrapper
-   Commons/Callback - Callback wrapper with support for closures
-   Commons/Config - Configuration library (PHP Array, XML)
-   Commons/Container - Generic container classes
-   Commons/Entity - Generic entity classes
-   Commons/Event - Event abstraction and dispatcher
-   Commons/Filter - Filters
-   Commons/Http - HTTP utilities
-   Commons/Json - JSON library
-   Commons/KeyStore - Key store connectors (Session, APC, Memcache, Redis)
-   Commons/Light - Simple MVC framework (constoller, dispatcher, routing, views)
-   Commons/Log - Logging library compatible with PSR-3 Logger (stream, syslog)
-   Commons/Migration - Migration library (downgrade, upgrade, fixtures)
-   Commons/Moo - The MOO microframework inspired by Ruby's Sinatra
-   Commons/NoSql - NoSQL bindings for entitiy repositories (Apache Cassandra, MongoDB)
-   Commons/Plugin - Abstract plugin implementation
-   Commons/Process - Utility for executing external processes
-   Commons/Sql - SQL library based on entities with query builder
-   Commons/Template - Abstract templates based on associative containers
-   Commons/Timer - Timer utility
-   Commons/Utils - Miscellaneous utilities
-   Commons/Validator - Validators
-   Commons/Xml - XML library

Examples
--------
You can find a few fully working example scripts in the `examples/` directory.

Testing
-------
To run tests without 3rdparty dependencies:
    DISABLE_REDIS=1 DISABLE_CASSANDRA=1 DISABLE_MONGO=1 phing test
