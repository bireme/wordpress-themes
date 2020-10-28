<?php
    function get_video_code($url) {
        $code = '';
        if (strpos($url, 'youtube') > 0) {
            $parts = parse_url($url);
            parse_str($parts['query'], $query);
            $code = $query['v'];
        }
        if (strpos($url, 'youtu.be') > 0) {
            $parts = parse_url($url);
            $code = end(explode('/', $parts['path']));
        }
        return $code;
    }
?>