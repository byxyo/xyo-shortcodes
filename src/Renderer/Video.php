<?php

namespace Xyo\Shortcodes\Renderer;

use Xyo\Shortcodes\Hydrator\AttributeHydrator;

use Xyo\Shortcodes\Dto\VideoAttributes;

/**
 * [video mp4=URL poster=URL w=640 h=400] — self-hosted MP4 (video.js).
 */
class Video implements ShortcodeInterface
{
    public function tag(): string
    {
        return 'video';
    }

    public function render(array|string $atts): string
    {
        /** @var VideoAttributes $a */
        $a = AttributeHydrator::hydrate(VideoAttributes::class, $atts);

        $url = $a->mp4 !== '' ? $a->mp4 : $a->url;
        if ($url === '') {
            return '';
        }

        $image = $a->image !== '' ? $a->image : $a->poster;
        $w = $a->w ?: $a->width;
        $h = $a->h ?: $a->height;

        return sprintf(
            '<video id="%s" data-autoresize="fit" class="embed video-js skin-beehuge" width="%d" height="%d" preload="none" controls poster="%s" data-setup="{}">'
            . '<source type="video/mp4" src="%s" />'
            . '</video>',
            esc_attr(md5($url)),
            $w,
            $h,
            esc_url($image),
            esc_url($url)
        );
    }
}
