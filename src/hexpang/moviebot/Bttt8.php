<?php

namespace hexpang\moviebot;

if (file_exists('vendor/simple-html-dom/simple-html-dom/simple_html_dom.php')) {
    require_once 'vendor/simple-html-dom/simple-html-dom/simple_html_dom.php';
} else {
    require_once __DIR__.'/../../../../../simple-html-dom/simple-html-dom/simple_html_dom.php';
}

class Bttt8 implements IBot
{
    public $BASE_URL;
    public function __construct()
    {
        $this->BASE_URL = 'http://www.bttt8.com/';
    }
    public function downloadTorrent($url, $fileName = null)
    {
    }
    public function loadUrl($url, $cache = false)
    {
    }
    public function loadWithPage($page = 1, $type = 0)
    {
    }
    public function loadTorrentInfo($url)
    {
    }
    public function loadMovieInfo($id)
    {
        $url = $this->BASE_URL.'torrent/'.$id;
        //
        // $field = ['type', 'country', 'year', 'director', 'script', 'actor'];
        // $info['title'] = $title;
        // $info['url'] = "/torrent/{$id}";
        // $info['id'] = $id;
        // $info['image'] = $image;
        // $info['score'] = $score;
    }
    public function loadMovies($page, $type = 0)
    {
        $movies = [];
        $val = '';
        if (!is_array($type)) {
            if ($type == 0) {
                $val = 'newmovie';
            }
        }
        $url = $this->BASE_URL.$val;
        $source = file_get_contents($url);
        if (strlen($source) > 1024) {
            $html = str_get_html($source);
            $div = $html->find('div[class=post clearfix]');
            foreach ($div as $movieDiv) {
                $title_href = $movieDiv->find('h3[class=entry-title postli-1] a')[0];
                $title = $title_href->innertext;
                $type = $movieDiv->find('span[class=meta-author] a')[0];
                $image = $movieDiv->find('a[class=entry-thumb lazyload] img')[0];
                $id = explode('/', $title_href->href);
                $id = $id[count($id) - 1];
                $desc = $movieDiv->find('div[class=entry-excerpt] p')[0];
                $movie = [
          'title' => $title,
          'url' => $title_href->href,
          'type' => $type->innertext,
          'country' => '',
          'director' => '',
          'script' => '',
          'actor' => '',
          'image' => $image->src,
          'desc' => $desc->innertext,
          'id' => $id,
          'score' => '',
        ];
                $movies[] = $movie;
            }
        }

        return $movies;
    }
}
