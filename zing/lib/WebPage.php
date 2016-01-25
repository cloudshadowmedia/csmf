<?php

namespace cloudshadowmedia;

class WebPage {

    private $url;
    private $content;
    private $links;

    function __construct($url = "http://zingstudios.com") {
        $this->url = $url;
        $this->content = "";
        $URL = new \cloudshadowmedia\net\Url($this->url);

        if (!$URL->exists()):
            throw new \cloudshadowmedia\net\UrlException("This url doesn't exist.");
        endif;
    }
    
    public function visitLinks($visitor=NULL) {
        if($visitor==NULL){http://news.yahoo.com/
        $visitor=new \cloudshadowmedia\net\LinkVistor();
        }
        foreach ($this->getLinks() as $link):
            //if ($link->getIsURL() == true):
              $link->accept($visitor);
            //endif;
        endforeach;
    }

    public function getLinkArray(){
        $links=array();
        foreach ($this->getLinks() as $link):
            if($link->getIsUrl()==true){
            array_push($links,$link->toArray());
            }
        endforeach;
        return $links;
    }
    
    function getLinks() {
        return $this->links;
    }

    function getUrl() {
        return $this->url;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function getContent() {

        return $this->content;
    }

    public function loadContent() {
        $this->content = file_get_contents($this->getUrl());
    }

    public function parseLinks() {
       
        $links = Parser::parse($this->getContent(), $this->getUrl());
        $this->links = $links;
    }
    


}
