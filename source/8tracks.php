<?php

require_once('workflows.php');

// define a global variable for curl options
$options = array(
    CURLOPT_HTTPHEADER => array(
        'X-Api-Key: effa5c21b8502fba892a0bdc96b646182de2aab8', // api key for http request
        'X-Api-Version: 3', // api version
    )
);

/**
 * Description : 
 * Returns the most popular mixes on 8tracks
 */
function most_popular_mixes() {
    $wf = new Workflows();
    // url requiring the most popular mixes
    $url = "http://8tracks.com/mix_sets/all:popular.json?include=mixes&per_page=10";
    global $options;
    $json = $wf->request($url, $options);
    $arr = json_decode($json, true);
    $mixes = $arr['mix_set']['mixes'];
    $count = 1;
    foreach ($mixes as $item) {
        $url = "http://8tracks.com".$item['path'];
        $plays_count = $item['plays_count'];
        $likes_count = $item['likes_count'];
        $wf->result('alfred8tracksworkflow.'.$count.'.'.time(), $url, trim($item['name']), 'Number of plays: '.$plays_count.' | '.'Number of likes: '.$likes_count.' | '.'Duration: '.gmdate("H:i:s", $item['duration']).' ('.$item['tracks_count'].' tracks)', 'icon.png');
        $count++;
    }
    return $wf->toxml();
}

/**
 * Description :
 * Returns the most trending mixes on 8tracks
 */
function most_trending_mixes() {
    $wf = new Workflows();
    // url requiring the most trending mixes
    $url = "http://8tracks.com/mix_sets/all:hot.json?include=mixes&per_page=10";
    global $options;
    $json = $wf->request($url, $options);
    $arr = json_decode($json, true);
    $mixes = $arr['mix_set']['mixes'];
    $count = 1;
    foreach ($mixes as $item) {
        $url = "http://8tracks.com".$item['path'];
        $plays_count = $item['plays_count'];
        $likes_count = $item['likes_count'];
        $wf->result('alfred8tracksworkflow.'.$count.'.'.time(), $url, trim($item['name']), 'Number of plays: '.$plays_count.' | '.'Number of likes: '.$likes_count.' | '.'Duration: '.gmdate("H:i:s", $item['duration']).' ('.$item['tracks_count'].' tracks)', 'icon.png');
        $count++;
    }
    return $wf->toxml();
}

/**
 * Description :
 * Returns the most recent mixes on 8tracks
 */
function most_recent_mixes() {
    $wf = new Workflows();
    // url requiring the most recent mixes
    $url = "http://8tracks.com/mix_sets/all:recent.json?include=mixes&per_page=10";
    global $options;
    $json = $wf->request($url, $options);
    $arr = json_decode($json, true);
    $mixes = $arr['mix_set']['mixes'];
    $count = 1;
    foreach ($mixes as $item) {
        $url = "http://8tracks.com".$item['path'];
        $plays_count = $item['plays_count'];
        $likes_count = $item['likes_count'];
        $wf->result('alfred8tracksworkflow.'.$count.'.'.time(), $url, trim($item['name']), 'Number of plays: '.$plays_count.' | '.'Number of likes: '.$likes_count.' | '.'Duration: '.gmdate("H:i:s", $item['duration']).' ('.$item['tracks_count'].' tracks)', 'icon.png');
        $count++;
    }
    return $wf->toxml();
}

/**
 * Description :
 * Returns the mixes including the required keyword
 */
function search_mixes_by_keyword($arr_keyword) {
    $wf = new Workflows();
    // url requiring the mixes including the keyword
    $url = "http://8tracks.com/mix_sets/keyword:".implode('+', $arr_keyword).".json?include=mixes&per_page=10";
    global $options;
    $json = $wf->request($url, $options);
    $arr = json_decode($json, true);
    $mixes = $arr['mix_set']['mixes'];
    $count = 1;
    foreach ($mixes as $item) {
        $url = "http://8tracks.com".$item['path'];
        $plays_count = $item['plays_count'];
        $likes_count = $item['likes_count'];
        $wf->result('alfred8tracksworkflow.'.$count.'.'.time(), $url, trim($item['name']), 'Number of plays: '.$plays_count.' | '.'Number of likes: '.$likes_count.' | '.'Duration: '.gmdate("H:i:s", $item['duration']).' ('.$item['tracks_count'].' tracks)', 'icon.png');
        $count++;
    }
    return $wf->toxml();
}



