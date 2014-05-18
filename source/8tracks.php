<?php

require_once('workflows.php');

// define constant variables
define('API_KEY', 'effa5c21b8502fba892a0bdc96b646182de2aab8'); // api key for http request
define('API_VERSION', '3'); // api version
define('FIELD', 'mixes'); // field groups to return for mix set
define('ITEM_COUNT', '9'); // number of items to return per page
define('DIR_COVERS', './icons/covers/'); // directory for storing covers

// construct the http header
$array = array(
    CURLOPT_HTTPHEADER => array(
        'X-Api-Key: '.API_KEY,
        'X-Api-Version: '.API_VERSION
    )
);
define('OPTIONS', serialize($array));

/**
 * Description : 
 * Returns the most popular mixes on 8tracks
 */
function most_popular_mixes() {
    $args = array(
        'include' => FIELD,
        'per_page' => ITEM_COUNT
    );
    $params = http_build_query($args);
    // url requiring the most popular mixes
    $url = 'http://8tracks.com/mix_sets/all:popular.json?'.$params;
    return showMix($url);
}

/**
 * Description :
 * Returns the most trending mixes on 8tracks
 */
function most_trending_mixes() {
    $args = array(
        'include' => FIELD,
        'per_page' => ITEM_COUNT
    );
    $params = http_build_query($args);
    // url requiring the most trending mixes
    $url = 'http://8tracks.com/mix_sets/all:hot.json?'.$params;
    return showMix($url);
}

/**
 * Description :
 * Returns the most recent mixes on 8tracks
 */
function most_recent_mixes() {
    $args = array(
        'include' => FIELD,
        'per_page' => ITEM_COUNT
    );
    $params = http_build_query($args);
    // url requiring the most popular mixes
    $url = 'http://8tracks.com/mix_sets/all:recent.json?'.$params;
    return showMix($url);

}

/**
 * Description :
 * Returns the mixes including the required keyword
 */
function search_mixes_keyword($arr_keyword) {
    $args = array(
        'include' => FIELD,
        'per_page' => ITEM_COUNT
    );
    $params = http_build_query($args);
    // url requiring the mixes including the keyword
    $url = 'http://8tracks.com/mix_sets/keyword:'.implode('+', $arr_keyword).'.json?'.$params;
    return showMix($url);
}

/**
 * Description :
 * Show the mixes 
 */
function showMix($url) {
    // create a temporary directory for storing mix covers
    if (!file_exists(DIR_COVERS)) {
        mkdir(DIR_COVERS, 0777, true);
    }
    deleteAllFiles();

    $wf = new Workflows();
    $options = unserialize(OPTIONS);
    $json = $wf->request($url, $options);
    $data = json_decode($json, true);
    $mixes = $data['mix_set']['mixes'];
    $count = 1;
    foreach ($mixes as $mix) {
        // get mix info
        $mix_id = $mix['id'];
        $mix_name = $mix['name'];
        $url = "http://8tracks.com".$mix['path'];
        $plays_count = $mix['plays_count'];
        $likes_count = $mix['likes_count'];
        $tracks_count = $mix['tracks_count'];
        $duration = $mix['duration'];
        $cover_url = $mix['cover_urls']['sq56'];

        // get mix cover from url
        $image_data = file_get_contents($cover_url);
        $image_name = $mix_id.'.png';
        file_put_contents(DIR_COVERS.'/'.$image_name, $image_data); // put image into temporary directory

        $wf->result('alfred8tracksworkflow.'.$count.'.'.time(), $url, trim($mix_name), '['.number_format($plays_count).' plays] '.'['.number_format($likes_count).' likes] '.'['.$tracks_count.' tracks] ('.gmdate("H:i:s", $duration).')', DIR_COVERS.'/'.$image_name);
        $count++;
    }
    return $wf->toxml();
}

/**
 * Description : 
 * Delete all files in a directory
 */
function deleteAllFiles() {
    $files = glob(DIR_COVERS.'*'); // get all file names
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}



