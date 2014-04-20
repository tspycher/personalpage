<?php
/**
 * Created by PhpStorm.
 * User: tspycher
 * Date: 16/03/14
 * Time: 15:06
 */

namespace Tspycher;
include_once "NewsElement.php";

class Rss {

    private $feedurls;

    function __construct(array $feedurls) {
        $this->feedurls = $feedurls;
    }

    function collect() {
        $data = array();
        foreach($this->feedurls as $feedurl)
            $data = $data + $this->loadFeed($feedurl);
        return $data;
    }

    private function loadFeed($url) {
        $file = file_get_contents($url);
        $xml = new \SimpleXMLElement($file);
        $collection = array();
        foreach($xml->channel->item as $feed){
            $collection[strtotime($feed->pubDate)] = new NewsElement((string)$feed->title, null, $feed->link, $feed->pubDate);
        }
        return $collection;
    }
} 