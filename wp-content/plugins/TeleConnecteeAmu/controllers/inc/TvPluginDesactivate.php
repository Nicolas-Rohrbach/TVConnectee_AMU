<?php


class TvPluginDesactivate
{
    public static function desactivate() {
        flush_rewrite_rules();
    }
}