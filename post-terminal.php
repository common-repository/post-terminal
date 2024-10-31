<?php
/*
Plugin Name: Post Terminal
Plugin URI: http://logyx.net/post-terminal-for-wordpress
Description: Post Terminal generates a terminal-like box around your text to give the appearance of a terminal such as xterm or cmd. Create terminal with <code>&lt;pre id="terminal"&gt;&lt;/pre&gt;</code>.
Author: Brandon Griffith
Version: 0.1
Author URI: http://logyx.net
*/

#  This is free software; you can redistribute it and/or modify it under
#  the terms of the GNU General Public License as published by the Free
#  Software Foundation; either version 2 of the License, or (at your option)
#  any later version.
#
#  It is distributed in the hope that it will be useful, but WITHOUT ANY
#  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
#  FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
#  details.
#
#  You should have received a copy of the GNU General Public License along
#  with this software, if not, write to the Free Software Foundation, Inc.,
#  59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
#

// Override allowed attributes for pre tags in order to use <pre user=""> and <pre computer=""> in
// comments. For more info see wp-includes/kses.php
if (!CUSTOM_TAGS) {
  $allowedposttags['pre'] = array(
    'user' => array(),
    'computer' => array(),
    'style' => array(),
    'width' => array(),
    'cwd' => array(),
  );
  //Allow plugin use in comments
  $allowedtags['pre'] = array(
    'user' => array(),
    'computer' => array(),
    'cwd' => array(),
    'escaped' => array(),
  );
}

function terminal_head()
{
  $css_url = get_bloginfo("wpurl") . "/wp-content/plugins/post-terminal/style/terminal.css";
  if (file_exists(TEMPLATEPATH . "/terminal.css"))
  {
    $css_url = get_bloginfo("template_url") . "/terminal.css";
  }
  echo "\n".'<link rel="stylesheet" href="' . $css_url . '" type="text/css" media="screen" />'."\n";
}

function terminal_substitute(&$match)
{
    global $terminal_token, $terminal_matches;

    $i = count($terminal_matches);
    $terminal_matches[$i] = $match;
    return "\n\n<p>" . $terminal_token . sprintf("%03d", $i) . "</p>\n\n";
}

function terminal_split_commands($code)
{
 return split("(<br>|<br/>)(\n|\r\n)*",$code);
}

function terminal_split_lines($code)
{
 return split("\n|\r\n",$code);
}

function terminal_highlight($match)
{
    global $terminal_matches;

    $i = intval($match[1]);
    $match = $terminal_matches[$i];

    $user = trim($match[1]);
    $user = $user ? $user : "user";
    $computer = trim($match[2]);
    $computer = $computer ? $computer : "computer";
    $cwd = trim($match[3]);
    $cwd = $cwd ? $cwd : "";
    $prompt = $user."@".$computer.":".$cwd."$ ";
    $code = $match[4];
    $commands =  terminal_split_commands($code);

    $output = "\n<div class=\"terminal\">";
    foreach ($commands as $command)
    {
      $output .= $prompt;
      $lines = terminal_split_lines($command);
      foreach ($lines as $line)
      {
        $output .= trim(str_replace("[prompt]", $prompt, $line . "<br/>"));
      }
    } 
   $output .= "</div>\n";

    return $output;
}

function terminal_before_filter($content)
{
    return preg_replace_callback(
//   "/\s*<pre id=[\"']terminal[\"']\s?(?:user=[\"']([\w-]*)[\"']|computer=[\"']([\w-]*)[\"']|\s?)+>(.*)<\/pre>\s*/siU",
//   "/\s*<pre id=[\"']terminal[\"']\s?(?:user=[\"']([\w-]*)[\"']|computer=[\"']([\w-]*)[\"']|cwd=[\"']([\w-]*)[\"']|\s?)+>(.*)<\/pre>\s*/siU",
	"/\s*<pre id=[\"']terminal[\"']\s?(?:user=[\"']([\w-]*)[\"']|computer=[\"']([\w-]*)[\"']|cwd=[\"']([\S]*)[\"']|\s?)+>(.*)<\/pre>\s*/siU",
        "terminal_substitute",
        $content
    );
}


function terminal_after_filter($content)
{
    global $terminal_token;

     $content = preg_replace_callback(
         "/<p>\s*".$terminal_token."(\d{3})\s*<\/p>/si",
         "terminal_highlight",
         $content
     );

    return $content;
}

$terminal_token = md5(uniqid(rand()));

// Add styling
add_action('wp_head', 'terminal_head',-1);

// We want to run before other filters; hence, a priority of 0 was chosen.
// The lower the number, the higher the priority.  10 is the default and
// several formatting filters run at or around 6.
add_filter('the_content', 'terminal_before_filter', 0);
add_filter('the_excerpt', 'terminal_before_filter', 0);
add_filter('comment_text', 'terminal_before_filter', 0);

// We want to run after other filters; hence, a priority of 99.
add_filter('the_content', 'terminal_after_filter', 99);
add_filter('the_excerpt', 'terminal_after_filter', 99);
add_filter('comment_text', 'terminal_after_filter', 99);

?>
