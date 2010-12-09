TinyMy MySQL console

(c) Einar Lielmanis, 2005 - 2010
    einar@spicausis.lv



Word of advice
--------------

Tinymy is not under active development, though I occasionally make
changes to it. If you need more options and/or postgresql support, I
suggest you to check out DBKiss database browser by Cezary Tomczak. It's
great.


What's this?
------------

A minimalist mysql console to manage mysql server over web.

Usually to manage mysql server over the web, phpMyAdmin is used. Being
really great product, it is somehow big, I don't need most of its
features, and is waaaay too heavy to be used comfortably over dial-up or
another slow connection. Generally, all I usually need is a small mysql
console plus the overview of databases and tables, and that's why this
little app was born.

If you need fancy wizards, or you are not intimately familiar with SQL
language, or blank console scares you, I don't think this app will help
you.


What do I need to use tinymy?
-----------------------------

You need access to web server with PHP (version doesn't really matter,
it should work with any decent php version) with mysqli libraries and
session management enabled. You obviously need a mysql server for
managing, too.

This app is error_reporting, register_globals, magic_quotes,
short_open_tag and all-that-stuff safe (E_STRICT doesn't pass for
backwards compatibility, though), so I doubt that you will run into
configuration issues, though it's possible that I've overlooked
something.


Possible problems?
------------------

Your user name and password are stored in the session variables for the
duration of the session. Depending on various settings, your system may
choose to store the session data under /tmp or other place freely
accessible for all users. Know what you are doing.

If you use some fancy character encoding other than UTF-8, non-english
characters will probably be displayed as garbage (you can work around it
by changing character set for Content-Type in the php file, though).


Any license agreement or something?
----------------------------------

This work is licensed under a Creative Commons Attribution 2.5 License. 

Mostly that means something like "I don't give a damn about the legal
stuff, so feel free to do whatever you want to do with it."

