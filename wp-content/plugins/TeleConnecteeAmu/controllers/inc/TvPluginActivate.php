<?php


class TvPluginActivate
{
    public static function activate() {
        flush_rewrite_rules();
    }
}