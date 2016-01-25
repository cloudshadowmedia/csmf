<?php

use \cloudshadowmedia\json as json;
use \cloudshadowmedia as csm;

class LinkVistor implements \cloudshadowmedia\net\ILinkVisitor {

    public function visit(\cloudshadowmedia\net\Link $link) {
        if ($link->getIsURL() == true):
            //if($link->getSameDomain()==true):
            $tlen = strlen($link->getCleanTitle());
            $title = strtoupper($link->getCleanTitle());
            if ($tlen > 40):
                $title = substr($title, 0, 40) . "...";
            endif;
            $href = $link->getUrl();
            $hlen = strlen($href);
            if ($hlen > 40):
                $href = substr($href, 0, 40) . "...";
            endif;


            print str_pad($title, 45) . "[" . $href . "]" . "\n";
        //endif; 
        endif;
    }

}

class LinkScraper {

    public static function renderJSON(csm\WebPage $page) {
        $o = array(
            "url" => $page->getUrl(),
            "links" => $page->getLinkArray()
        );
        $json = json\prettyPrint(json_encode($o));
        header('Content-Type: application/json');
        print($json);
    }

    public static function renderTXT(csm\WebPage $page) {
        header('Content-Type: text/plain');
        print $page->getUrl() . "\n";
        print str_pad("-", 100, "-") . "\n";
        print str_pad("Link Title", 45, " ") . str_pad("URL", 45, " ") . "\n";
        print str_pad("-", 100, "-") . "\n";
        $page->visitLinks(new LinkVistor());
        print str_pad("-", 100, "-") . "\n";
    }

    public static function parseLinks($url = "http://zingstudios.com", $render = "TXT") {
        try {
            $page = new csm\WebPage($url);
            $page->loadContent();
            $page->parseLinks();
            //LinkScraper::renderTxt($page);


            if ($render == "TXT"):
                LinkScraper::renderTXT($page);
                return;
            endif;

            if ($render == "JSON"):
                LinkScraper::renderJSON($page);
                return;
            endif;

            print_r($page->getLinks());
        } catch (csm\net\UrlException $e) {
            print $e;
        }
    }

}