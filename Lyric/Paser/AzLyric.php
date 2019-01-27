<?php

namespace Lyric\Paser;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use \Execption;

class AzLyric
{
    private $base_url = 'https://www.azlyrics.com/lyrics/';

    public $artist;

    public $title;

    public function __construct($artist, $title)
    {
        $this->artist = $artist;
        $this->title = $title;
    }

    public function getLyric()
    {
        $client = new Client();

        $artist = str_replace(" ", "", $this->artist);

        $title  = str_replace(" ", "", $this->title);

        $url = "https://www.azlyrics.com/lyrics/". strtolower($artist) ."/". strtolower($title) .".html";
        
        try {
            $response = $client->get($url);
        } catch (RequestException $e) {
            return $e->getMessage();
        }

        return $this->parse($response);
    }

    private function parse($response)
    {
        $body = $response->getBody();

        $start_position = strpos($body, 'ringtone');

        if ($start_position == false) {
            return 'Lyric is not found.';
        }

        $lyric_position = strpos($body, '<div>', $start_position);

        $end_position = strpos($body, "</div>", $lyric_position);

        return substr($body, $lyric_position+5, $end_position-1-($lyric_position+5));
    }
}
