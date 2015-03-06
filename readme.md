RPG example
===========

This repository contains an example of trivial RPG game core based on [Nette Framework](http://nette.org) and [Kdyby\Doctrine](https://github.com/Kdyby/Doctrine) libraries.
It is meant to be used for study purposes.

See [this post](http://forum.nette.org/cs/22304-zavislost-jednoho-modelu-na-jinych#p152039) for motivation.

![RPG](https://dl.dropboxusercontent.com/u/64984807/rpg.png)

-------

In order to get the application running please:

1. Clone this repository into some empty directory
2. Run `composer install` in that directory
3. Create an empty MySQL database and run `/_resources/schema.sql` and `/_resources/data.sql` script on it
4. Copy `/config/config.local.sample.neon` to `/config/config.local.neon`
5. Update database connection settings in `/config/config.local.neon`
6. Make sure that the web server can write into directories `/log` and `/temp`

And that's all. Now you can use "entry point" `http://localhost/<pathToApplication>/www/`

If you want to switch the application into a *dev* mode, please place empty file named `dev` into `/app/config` directory.

Requirements
-------

Application requires PHP 5.5 or newer and MySQL 5 or newer. It is intended for running on Apache or Nginx server.

License
-------

MIT

Copyright (c) 2015 Vojtěch Kohout (aka Tharos)
