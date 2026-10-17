<?php

/*
  Plugin Name: Shortcodes by Xyo
  Plugin URI: https://xyo.dev/
  Description: Media shortcodes ([youtube], [vimeo], [video], [videoflash], [source]) extracted from the beehuge theme so they no longer depend on the theme (or Jetpack for [vimeo]).
  Version: 1.0.0
  Author: Patrick Petit (Xyo)
  Author URI: https://xyo.dev/
  License: GPL2
*/

if (!defined('ABSPATH')) {
    exit;
}

use Xyo\Shortcodes\Shortcodes;

define('XYO_SHORTCODES_PATH', dirname(__FILE__) . '/');

/**
 * Minimal PSR-4 autoloader: Xyo\Shortcodes\ => src/. No Composer needed — the
 * plugin ships no dependencies (same shape as the other xyo plugins).
 */
spl_autoload_register(function ($class) {
    $prefix = 'Xyo\\Shortcodes\\';
    $len = strlen($prefix);
    if (strncmp($class, $prefix, $len) !== 0) {
        return;
    }

    $file = XYO_SHORTCODES_PATH . 'src/' . str_replace('\\', '/', substr($class, $len)) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

add_action('init', [Shortcodes::class, 'register']);
