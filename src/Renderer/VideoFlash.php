<?php

namespace Xyo\Shortcodes\Renderer;

use Xyo\Shortcodes\Hydrator\AttributeHydrator;

use Xyo\Shortcodes\Dto\VideoFlashAttributes;

/**
 * [videoflash url=FILE image=POSTER w=640 h=360] — legacy Flash player.
 */
class VideoFlash implements ShortcodeInterface
{
    use EmbedContainer;

    public function tag(): string
    {
        return 'videoflash';
    }

    public function render(array|string $atts): string
    {
        /** @var VideoFlashAttributes $a */
        $a = AttributeHydrator::hydrate(VideoFlashAttributes::class, $atts);

        $host = (defined('ENV') && ENV === 'dev') ? 'bee.local/media' : 'media.beehuge.com';

        return $this->embed(sprintf(
            '<object width="%1$d" height="%2$d" data="//%3$s/mediaplayer.swf" type="application/x-shockwave-flash">'
            . '<param name="data" value="//%3$s/mediaplayer.swf" />'
            . '<param name="flashvars" value="file=%4$s&amp;image=%5$s" />'
            . '<param name="src" value="//%3$s/mediaplayer.swf" />'
            . '<param name="allowfullscreen" value="true" />'
            . '</object>',
            $a->w,
            $a->h,
            $host,
            esc_attr($a->url),
            esc_attr($a->image)
        ));
    }
}
