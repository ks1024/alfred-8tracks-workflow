<?php

require_once('workflows.php');
require_once('8tracks.php');

function huittracks_helper($query) {
    $wf = new Workflows();
    $q = trim(strtolower($query));
    $args = explode(' ', $q);

    if ($args[0] == '') {
        // if no arguments
        $wf->result('alfred8tracksworkflow.mix', '', 'Search mixes on 8tracks', "Search mixes including the keyword '...'", 'icon.png', 'no', 'm');
        $wf->result('alfred8tracksworkflow.popular', '', 'Most popular mixes on 8tracks', 'explore the most popular mixes', 'icon.png', 'no', 'mostpopular');
        $wf->result('alfred8tracksworkflow.trending', '', 'Most trending mixes on 8tracks', 'explore the most trending mixes', 'icon.png', 'no', 'mosttrending');
        $wf->result('alfred8tracksworkflow.newest', '', 'Most recent mixes on 8tracks', 'explore the newest mixes', 'icon.png', 'no', 'mostrecent');
       return $wf->toxml(); 
    } elseif ($args[0] == 'mostpopular') {
        return most_popular_mixes();
    } elseif ($args[0] == 'mosttrending') {
        return most_trending_mixes();
    } elseif ($args[0] == 'mostrecent') {
        return most_recent_mixes();
    } elseif ($args[0] == 'm' && sizeof($args) > 1 && $args[1] != "") {
        array_shift($args);
        return search_mixes_by_keyword($args);
    }
}

