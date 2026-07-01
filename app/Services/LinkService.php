<?php

namespace App\Services;

use App\Models\Link;

class LinkService
{
    public function createShortLink(string $url, int $userId): string
    {
        $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);

        Link::create([
            'code' => $code,
            'url' => $url,
            'user_id' => $userId,
            'expires_at' => now()->addMinutes(5)
        ]);

        return $code;
    }
}