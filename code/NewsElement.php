<?php
/**
 * Created by PhpStorm.
 * User: tspycher
 * Date: 16/03/14
 * Time: 15:22
 */

namespace Tspycher;


class NewsElement {
    private $title;
    private $summary;
    private $url;
    private $date;
    private $type;

    function __construct($title, $summary, $url, $date,$type = "wordpress")
    {
        $this->summary = $summary;
        $this->title = $title;
        $this->url = $url;
        $this->date = $date;
        $this->type = $type;
    }


    /**
     * @param mixed $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        $date = new \DateTime($this->date);
        return (string)$date->format('Y.m.d H:i:s');
    }


    public function __toString() {
        $x = sprintf('<li><img src="images/Social_Icons/%s.png"><h3><a href="%s" target="_new">%s</a></h3><div class="feeddate"><p>%s</p></div><p>%s</p></li>',$this->getType(), $this->getUrl(), $this->getTitle(), $this->getDate(), $this->getSummary());
        return $x;
    }

} 