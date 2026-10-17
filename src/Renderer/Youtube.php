<?php

namespace Xyo\Shortcodes\Renderer;

use Xyo\Shortcodes\Hydrator\AttributeHydrator;

use Xyo\Shortcodes\Dto\YoutubeAttributes;

/**
 * [youtube id=XXXX start=0 end=0 poster=URL]
 * Lazy YouTube facade (poster + .playerYt, hydrated by the theme JS).
 */
class Youtube implements ShortcodeInterface
{
    use EmbedContainer;

    public function tag(): string
    {
        return 'youtube';
    }

    public function render(array|string $atts): string
    {
        /** @var YoutubeAttributes $a */
        $a = AttributeHydrator::hydrate(YoutubeAttributes::class, $atts);

        $id = sanitize_text_field($a->id);
        if ($id === '') {
            return '';
        }

        $poster = $a->poster !== ''
            ? $a->poster
            : 'https://i.ytimg.com/vi/' . $id . '/maxresdefault.jpg';

        $url = is_home() ? home_url('/') : get_permalink();

        return $this->embed(sprintf(
            '<div class="playerYt" id="yt%1$s" data-yt-id="%1$s" data-yt-start="%2$d" data-yt-end="%3$d" data-post-url="%4$s">'
            . '<div class="play"></div>'
            . '<img class="playerYtImg" src="%5$s" alt="" />'
            . '</div>',
            esc_attr($id),
            $a->start,
            $a->end,
            esc_url((string) $url),
            esc_url($poster)
        ));
    }
}
