<?php

namespace Xyo\Shortcodes\Renderer;

interface ShortcodeInterface
{
    /**
     * The shortcode tag (without brackets), e.g. "youtube".
     */
    public function tag(): string;

    /**
     * Render the shortcode to HTML.
     *
     * @param array|string $atts Raw attributes. WordPress passes an empty
     *                           string (not an array) when none are given.
     */
    public function render(array|string $atts): string;
}
