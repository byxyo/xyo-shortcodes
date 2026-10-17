<?php

namespace Xyo\Shortcodes;

use Xyo\Shortcodes\Renderer\ShortcodeInterface;
use Xyo\Shortcodes\Renderer\Youtube;
use Xyo\Shortcodes\Renderer\Vimeo;
use Xyo\Shortcodes\Renderer\Video;
use Xyo\Shortcodes\Renderer\VideoFlash;
use Xyo\Shortcodes\Renderer\Source;

/**
 * Registry: wires every ShortcodeInterface implementation to WordPress.
 */
class Shortcodes
{
    /**
     * @return ShortcodeInterface[]
     */
    private static function all(): array
    {
        return [
            new Youtube(),
            new Vimeo(),
            new Video(),
            new VideoFlash(),
            new Source(),
        ];
    }

    public static function register(): void
    {
        foreach (self::all() as $shortcode) {
            add_shortcode($shortcode->tag(), [$shortcode, 'render']);
        }
    }
}
