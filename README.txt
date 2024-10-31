=== Post Terminal===
Contributors: bgriffith
Donate link: http://logyx.net
Tags: terminal, cmd, xterm, unix, console, command, linux
Requires at least: 2.0
Tested up to: 4.5.3
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Post Terminal provides a terminal-like box for embedding terminal commands within pages or posts.

== Description ==

Post Terminal generates a terminal-like box that you can use to demonstrate terminal output or show the entry of terminal/console commands in a manner that is more demonstrative of actually using a Linux/Unix terminal or Windows cmd shell.

The code is a fork of WP-Terminal which in turn is a modification of WP-Syntax, a source code highlighter plugin for Wordpress.

= Basic Usage =

The most basic usage is to wrap your terminal blocks with `<pre id="terminal"></pre>` tags. If no further options are defined within the tag a generic prompt is generated using  'user@computer' with no working directory shown. This is similar to exporting PS1="\u@\h:$ " in sh(1), setting prompt="%n@%m:$ " in csh(1), etc.
Other options available within the tag are user="user", computer="computer", and  cwd="/path/to/directory". These allow you to override the generic user@computer settings as well as provide a 'current working directory'.

== Installation ==

1. Unzip the plugin .zip file and upload the directory to your /wp-content/plugins/.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Create a post/page that contains a code snippet following the proper usage syntax.

== Frequently Asked Questions ==
= Does this plugin really replace the WP-Terminal plugin =
Yes, Post Terminal is 100% compatible and even adds new features, with more to come.
You can even use your customized style.css from the previous plugin.

= What is the best way to ask questions or submit patches? =
The best way to reach me is always via email: <brandon@logyx.net>

== Screenshots ==
1. Basic display with no configuration.
2. Basic display with <code>user</code> and <code>computer</code> configuration.
3. Basic display with <code>user</code> and <code>computer</code> and <code>cwd</code>configuration.
4. A more thorough example showing demonstrative purposes

== Usage ==

Wrap terminal blocks with `<pre id="terminal" user="username"
computer="computername" cwd="/path/to/directory">` and `</pre>`, being user and
computer optional ("user" and "computer" will be shown if you don't provide
them, cwd is purely optional).

**Example 1: No customized command**

    <pre id="terminal">
      ls -a
    </pre>


**Example 2: User and computer customizations**

    <pre id="terminal" user="beastie" computer="freebsd">
      ls -a
    </pre>

**Example 3: Customizing just the user**

    <pre id="terminal" user="bdobbs">
      ls -a
    </pre>

**Example 5: Customizing user, computer and displaying a working directory**

    <pre id="terminal" user="root" computer="linuxserver" cwd="/usr/src/linux">
      make mrproper
      . ..
      . .. 
    </pre>

== Changelog ==
= 0.1 = 
* Initial release


== Upgrade Notice ==
= 0.1 =
* New release.
