<?php

namespace Xyo\Shortcodes\Renderer;

use Xyo\Shortcodes\Hydrator\AttributeHydrator;

use Xyo\Shortcodes\Dto\SourceAttributes;

/**
 * [source url=URL type=flickr prefix="via" text="Source"] — inline credit link.
 */
class Source implements ShortcodeInterface
{
    public function tag(): string
    {
        return 'source';
    }

    public function render(array|string $atts): string
    {
        /** @var SourceAttributes $a */
        $a = AttributeHydrator::hydrate(SourceAttributes::class, $atts);

        $type = sanitize_html_class($a->type);
        $class = $type !== '' ? $type . ' external source' : 'external source';
        $prefix = $a->prefix !== '' ? esc_html($a->prefix) . ' ' : '';
        $icon = $type !== '' ? '<i class="fa fa-' . $type . '"></i> ' : '';

        return sprintf(
            '<span class="%s">+ %s%s<a href="%s" class="%s">%s</a></span>',
            esc_attr($type),
            $prefix,
            $icon,
            esc_url($a->url),
            esc_attr($class),
            esc_html($a->text)
        );
    }
}
