<?php

namespace App\Actions\CssColors;

use App\Models\CssColor;
use Illuminate\Support\Facades\Cache;

class GetCssColorsFromCacheAction
{
    public function __construct()
    {
        //
    }

    public function __invoke()
    {
        if (!Cache::has('css_colors')) {
            Cache::forever('css_colors', CssColor::get());
        }

        return Cache::get('css_colors');
    }
}
