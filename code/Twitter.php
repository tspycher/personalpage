<?php
/**
 * Created by PhpStorm.
 * User: tspycher
 * Date: 16/03/14
 * Time: 15:06
 */

namespace Tspycher;
include_once "NewsElement.php";

class Twitter {
    private $oauth_access_token;
    private $oauth_access_token_secret;
    private $consumer_key;
    private $consumer_secret;
    private $username;

    function __construct($username, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret)
    {
        $this->username = $username;
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;
        $this->oauth_access_token = $oauth_access_token;
        $this->oauth_access_token_secret = $oauth_access_token_secret;
    }


    public function collect() {
        $data = array();
        foreach($this->returnTweet($this->username) as $tweet) {
            $data[strtotime($tweet['created_at'])] = new NewsElement($tweet['text'],null,sprintf('https://twitter.com/%s/status/%d',$this->username, $tweet['id']), $tweet['created_at'], 'twitter');
        }
        return $data;
    }

    static function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach($params as $key=>$value){
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    static function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach($oauth as $key=>$value)
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        $r .= implode(', ', $values);
        return $r;
    }

    private function returnTweet($numOfTweets = 10){
        $twitter_timeline           = "user_timeline";  //  mentions_timeline / user_timeline / home_timeline / retweets_of_me

        //  create request
        $request = array(
            'screen_name'       => $this->username,
            'count'             => $numOfTweets
        );

        $oauth = array(
            'oauth_consumer_key'        => $this->consumer_key,
            'oauth_nonce'               => time(),
            'oauth_signature_method'    => 'HMAC-SHA1',
            'oauth_token'               => $this->oauth_access_token,
            'oauth_timestamp'           => time(),
            'oauth_version'             => '1.0'
        );

        //  merge request and oauth to one array
        $oauth = array_merge($oauth, $request);

        //  do some magic
        $base_info              = self::buildBaseString("https://api.twitter.com/1.1/statuses/$twitter_timeline.json", 'GET', $oauth);
        $composite_key          = rawurlencode($this->consumer_secret) . '&' . rawurlencode($this->oauth_access_token_secret);
        $oauth_signature            = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature']   = $oauth_signature;

        //  make request
        $header = array(self::buildAuthorizationHeader($oauth), 'Expect:');
        $options = array( CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => "https://api.twitter.com/1.1/statuses/$twitter_timeline.json?". http_build_query($request),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false);

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        return json_decode($json, true);
    }

} 