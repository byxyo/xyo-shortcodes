<?php

namespace Xyo\Shortcodes\Renderer;

/**
 * Wrap markup in the theme's responsive embed container (16:9 via CSS).
 */
trait EmbedContainer
{
    protected function embed(string $inner): string
    {
        return '<div class="embed-container">' . $inner . '</div>';
    }
}
