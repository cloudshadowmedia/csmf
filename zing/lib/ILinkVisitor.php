<?php
namespace cloudshadowmedia\net;

interface ILinkVisitor{
    public function visit(\cloudshadowmedia\net\Link $link);
}

class LinkVistor implements ILinkVisitor{
    public function visit(\cloudshadowmedia\net\Link $link){
        print_r($link);
    }
}



//parse_url($link->getUrl());