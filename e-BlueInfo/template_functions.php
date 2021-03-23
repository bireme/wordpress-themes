<?php
    if ( !function_exists('get_video_code') ) {
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
    }

    if ( !function_exists('is_webview') ) {
        function is_webview() {
            $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $wv = strpos($userAgent, 'wv');
            $safari = strpos($userAgent, 'safari');
            $ios = preg_match('/iphone|ipod|ipad|macintosh/', $userAgent);

            if ( $ios ) {
                if ( $safari !== false ) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if ( $wv !== false ) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
?>