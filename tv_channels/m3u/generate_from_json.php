<?php

$files = array();

foreach (scandir('../json') as $file) {
  if ($file !== '.' && $file !== '..') {
    generate_m3u_file($file);
  }
}

function generate_m3u_file($filename) {
  $json_raw = file_get_contents("../json/".$filename);
  $json = json_decode($json_raw);

  $m3u_string = "#EXTM3U\n";
  foreach($json as $j) {
    $m3u_string .= '#EXTINF:-1 source-type="'.$j->{'source-type'}.'" tvg-id="'.$j->{'tvg-id'}.'" tvg-logo="'.$j->logo.'" group-title="'.$j->tags.'", '.$j->name."\n";
    $m3u_string .= $j->url."\n";
  }

  $new_filename = str_replace('.json', '.m3u', $filename);
  if(file_exists($new_filename)) {
    unlink($new_filename);
  }

  $file = fopen($new_filename,"w");
  fwrite($file,$m3u_string);
  fclose($file);
}

?>