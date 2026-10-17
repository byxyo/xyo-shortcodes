<?php

namespace Xyo\Shortcodes\Dto;

class VimeoAttributes
{
    public string $id = '';
    public string $url = '';
    public int $w = 0;
    public int $h = 0;
    public int $width = 640;
    public int $height = 360;

    public function getWidth(): int
    {
        return $this->w ?: $this->width;

    }

    public function getHeight(): int
    {
        return $this->h ?: $this->height;
    }
}
