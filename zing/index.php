<?php

define("APP_ROOT", dirname(__FILE__));

require_once APP_ROOT . "/lib/Util.php";
require_once APP_ROOT . "/lib/CloudshadowMedia.php";
require_once APP_ROOT . "/lib/Net.php";
require_once APP_ROOT . "/lib/WebPage.php";
require_once APP_ROOT . "/lib/Parser.php";
require_once APP_ROOT . "/lib/Json.php";
require_once APP_ROOT . "/lib/ILinkVisitor.php";
require_once APP_ROOT . "/lib/Newsletter.php";
require_once APP_ROOT . "/lib/LinkScraper.php";

//LinkScraper::parseLinks("http://zingstudios.com", "JSON");
LinkScraper::parseLinks("http://zingstudios.com", "TXT");
//LinkScraper::parseLinks("http://cnn.com", "TXT");
//LinkScraper::parseLinks("http://news.yahoo.com", "TXT");
//NewsLetter::getValidSubscribers();