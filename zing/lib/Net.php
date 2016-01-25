<?php

namespace cloudshadowmedia\net;

class UrlException extends \Exception {

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}

class Url {

    private $url;
    private $_exists = NULL;

    function __construct($url) {
        $this->url = $url;
    }

    public function exists() {

        if ($this->_exists == NULL):
            $this->_exists = Url::checkUrl($this->url);
        endif;


        return $this->_exists;
    }

    public static function checkUrl($file) {

        $url = $file;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        if ($result !== false) {

            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($statusCode == 404) {

                return false;
            } else {
                return true;
            }
        } else {

            return false;
        }
    }

}

class Link {

    private $href;
    private $title;
    private $cleanTitle;
    private $anchor;
    private $path;
    private $samePage = false;
    private $type = "url";
    private $protocal;
    private $root;
    private $isURL = true;
    private $url;
    private $baseUrl;
    private $sameDomain;

    public function toArray(){
        return array(
            "title"=>$this->getCleanTitle(),
            "href"=>$this->getHref(),
            "anchor"=>$this->getAnchor(),
            "url"=>$this->getUrl(),
            "baseUrl"=>$this->getBaseUrl(),
            "parseUrl"=>parse_url($this->getUrl()),
            "sameHost"=>$this->getSameDomain()
            
        );
    }
    
    public function accept($visitor){
        $visitor->visit($this);
    }
    function getSameDomain() {
        return $this->sameDomain;
    }

        function getHref() {
        return $this->href;
    }

    function getTitle() {
        return $this->title;
    }

    function getCleanTitle() {
        return $this->cleanTitle;
        
    }

    function getAnchor() {
        return $this->anchor;
    }

    function getPath() {
        return $this->path;
    }

    function getSamePage() {
        return $this->samePage;
    }

    function getType() {
        return $this->type;
    }

    function getProtocal() {
        return $this->protocal;
    }

    function getRoot() {
        return $this->root;
    }

    function getIsURL() {
        return $this->isURL;
    }

    function getUrl() {
        return $this->url;
    }

    function getBaseUrl() {
        return $this->baseUrl;
    }

    public function URL($anchor = false) {
        if ($this->isURL):
            if ($this->type == "RELATIVE" || $this->type == "LOCAL_ANCHOR"):
                if ($anchor == true):
                    return $this->root . $this->href;
                endif;
                return $this->root . $this->path;
            endif;
            if ($this->type == "ABSOLUTE"):
                return $this->path;
            endif;

        endif;
    }

    private function linkType($o) {

        if (startsWith($o, "/")):
            $this->type = "RELATIVE";
        endif;
        if (startsWith($o, "#")):
            $this->type = "LOCAL_ANCHOR";
        endif;
        if (startsWith($o, "mailto:")):
            $this->type = "EMAIL";
            $this->isURL = false;
        endif;
        if (startsWith($o, "https:") || startsWith($o, "http:")):
            $this->type = "ABSOLUTE";
            $url = explode(":", $o);
            $this->protocal = $url[0];
        endif;
    }

    function __construct($href, $title = "", $root = "") {

        $title = str_replace("\n", " ", $title);

        $title = preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", $title));
        $this->root = $root;
        
        $title=trim(strip_tags($title));
        //$title=preg_replace('/[^A-Za-z0-9\-]/', '', $title);
        $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($title))))));
        
        
        $this->cleanTitle = $clear;
        
        $this->href = $href;
        $this->title = $title;
        $this->path = $href;
        $this->checkAnchors();
        $this->linkType($this->href);
        if ($this->isURL):
            $this->baseUrl = $this->URL();
            $this->url = $this->URL(true);
            
        $rurl=parse_url($this->root);
        $rhost=trim($rurl['host']);
        
        $url=parse_url($this->getUrl());
        $host=trim($url['host']);
        $this->sameDomain=false;
        if($rhost==$host):
            $this->sameDomain=true;
        endif;
        
        endif;

        
        
    }

    private function checkAnchors() {
        $pos = strpos($this->href, "#");
        if (startsWith($this->href, "#")):
            $this->samePage = true;
        endif;
        if ($pos >= 0):
            $a = explode("#", $this->href);
            $this->anchor = $a[1];
            $this->path = $a[0];
        endif;
    }

}