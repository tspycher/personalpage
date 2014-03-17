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
    private $type;

    function __construct($title, $summary, $url, $type = "rss")
    {
        $this->summary = $summary;
        $this->title = $title;
        $this->url = $url;
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


    public function __toString() {
        $x = sprintf('<div class="feed %s"><div class="feed title"><a href="%s" target="_new">%s</a></div><div class="feed summary">%s</div></div>',$this->getType(), $this->getUrl(), $this->getTitle(), $this->getSummary());
        return $x;
    }

} 