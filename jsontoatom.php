<?php
require 'vendor/autoload.php';

use PicoFeed\Syndication\Atom;


$url="http://illuminati-web.7puentes.com/cache/home/summary/5/0/q.json?proj=2&ion=All";

//  Get the JSON
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);

$json_feed = json_decode($result, true);

$writer = new Atom();
$writer->title = 'PulsoMedia';
$writer->site_url = 'http://pulsomedia.com/';
$writer->feed_url = 'http://pulsomedia.com/atom/jsontoatom.php';
$writer->author = array(
  'name' => 'Pulso Media',
  'url' => 'http://pulsomedia.com/',
  'email' => 'info@pulsomedia.com'
  );


// Feed Builder Items
foreach ($json_feed as $key => $value) {

  $writer->items[] = array(
    'title' => $value['title'],
    'id' => $value['id'],
    'published' => strtotime($value['article_date']),
    'url' => $value['url'],
    'summary' => $value['summary'],
    'content' => '<p>'.$value['text'].'</p>',
    'category' => $value['section'],
    'image' => $value['image_url']
    );

}

echo $writer->execute();