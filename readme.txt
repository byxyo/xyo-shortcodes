=== Xyo Shortcodes ===
Contributors: mrxyo
Tags: shortcode, youtube, vimeo, video, embed
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 8.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lightweight media shortcodes ([youtube], [vimeo], [video], [videoflash], [source]) with no theme or Jetpack dependency.

== Description ==

Shortcodes by Xyo provides a small set of self-contained media shortcodes,
extracted from the beehuge theme so your content no longer depends on the theme
(or on Jetpack for `[vimeo]`).

Shortcodes:

* `[youtube id=XXXX start=0 end=0 poster=URL]` — lazy YouTube facade: a poster
  image plus a placeholder that the front-end upgrades to the YouTube iframe on
  click (no third-party script loaded until the visitor plays the video).
* `[vimeo id=XXXX]` — Vimeo embed, without requiring Jetpack.
* `[video]` / `[videoflash]` — self-hosted / legacy video embeds.
* `[source]` — attribution / source credit block.

The plugin ships no external dependencies and registers nothing in the admin;
it only adds the shortcodes above.

== Installation ==

1. Upload the plugin folder to `wp-content/plugins/` and activate it.
2. Use the shortcodes above in any post or page.

== Frequently Asked Questions ==

= Does the YouTube shortcode load anything before the visitor clicks? =

No. `[youtube]` renders only a poster image and a placeholder; the YouTube
iframe (and its scripts) are loaded on click, keeping pages fast and avoiding
third-party requests until the visitor chooses to play.

= Does this plugin send any data to third parties? =

No. It only outputs embed markup. When a visitor plays a video, their browser
contacts the relevant provider (YouTube/Vimeo) as with any embed.

== Changelog ==

= 1.0.0 =
* Initial release: [youtube], [vimeo], [video], [videoflash] and [source]
  shortcodes extracted from the beehuge theme into a standalone plugin.
