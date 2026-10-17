<?php

namespace Xyo\Shortcodes\Renderer;

use Xyo\Shortcodes\Hydrator\AttributeHydrator;

use Xyo\Shortcodes\Dto\VimeoAttributes;

/**
 * [vimeo 141358] | [vimeo https://vimeo.com/141358] |
 * [vimeo https://vimeo.com/289091934/cd1f466bcc] (private, + hash) |
 * [vimeo id=141358 width=640 height=360]
 * Native replacement for Jetpack's [vimeo] (unavailable here).
 */
class Vimeo implements ShortcodeInterface
{
    use EmbedContainer;

    public const QUERY_ARGS = [
        'title'    => '0',
        'byline'   => '0',
        'portrait' => '0',
        'color'    => 'ffffff',
    ];

    public function tag(): string
    {
        return 'vimeo';
    }

    public function render(array|string $atts): string
    {
        /** @var VimeoAttributes $a */
        $a = AttributeHydrator::hydrate(VimeoAttributes::class, $atts);

        // Positional value: [vimeo 12345] / [vimeo https://vimeo.com/12345]
        $raw = '';
        if (is_array($atts) && !empty($atts[0])) {
            $raw = trim($atts[0], '=');
        } elseif ($a->id !== '') {
            $raw = $a->id;
        } elseif ($a->url !== '') {
            $raw = $a->url;
        }

        [$videoId, $hash] = $this->parse($raw);
        if (!$videoId) {
            return '';
        }

        $args = [
            ...self::QUERY_ARGS,
            ...($hash !== '' ? ['h' => $hash] : []),
        ];

        $src = add_query_arg($args, 'https://player.vimeo.com/video/' . $videoId);

        return $this->embed(sprintf(
            '<iframe src="%s" width="%d" height="%d" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>',
            esc_url($src),
            $a->getWidth(),
            $a->getHeight()
        ));
    }

    /**
     * Extract a Vimeo id (and optional private hash) from a raw id or URL.
     *
     * @return array{0:int,1:string} [videoId, hash]
     */
    private function parse(string $raw): array
    {
        if (is_numeric($raw)) {
            return [(int) $raw, ''];
        }

        $pattern = '#vimeo\.com/(?:groups/\d+/videos/|album/\d+/video/|video/|channels/[^/]+/videos/|[^/]+/)?(\d+)(?:/([0-9a-z]+))?#i';
        if (preg_match($pattern, $raw, $m)) {
            return [(int) $m[1], $m[2] ?? ''];
        }

        return [0, ''];
    }
}
