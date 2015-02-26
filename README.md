CBTTool
===========

A simple web-based Cognitive Behavior Therapy tool


## Setup

- Install vendor packages with `composer update`
- ***copy*** `app/settings/base.SAMPLE.php` to `app/settings/base.php` and fill in your values
- ***symlink*** `app/app-settings.php` to `app/settings/development.php` with `ln -s app/settings/development.php app/app-settings.php`


## Running dev server

1. `cd` to the base directory of the project (the one that contains `app`, `www`, etc).
2. run the dev server with `./dev-server.sh`.
3. Open [`http://0.0.0.0:9909`](http://0.0.0.0:9909) in a web browser.
