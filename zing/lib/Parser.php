<?php

namespace cloudshadowmedia;

class Parser {

    public static function parse($content, $root = "") {
        $html = trim($content);
        $links = array();
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        if (preg_match_all("/$regexp/siU", $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {

                $href = trim($match[2]);
                if (startsWith($href, "'") && endsWith($href, "'")):
                    $href = substr($href, 1, -1);
                endif;

                $link = new \cloudshadowmedia\net\Link($href, trim($match[3]), $root);
                array_push($links, $link);
            }
        }
        return $links;
    }

}

