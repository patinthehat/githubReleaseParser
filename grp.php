#!/usr/bin/php
<?php
/**
 * Example script using GithubReleaseDownloader to retrieve all of the
 * releases for a given repository.  
 * 
 * This could be extended to automate checking a list of projects for new versions.
 * 
 * 
 */

  include('autoload.php');
  
  //various github repositories
  $infos = array(
    array("user"=>"sciactive",  "repo" => "pnotify"),
    array("user"=>"twbs",       "repo" => "bootstrap"),
    array("user"=>"jquery",     "repo" => "jquery"),
  );
  
  //select a random repository
  $ghinfo = $infos[rand(0, count($infos)-1)];  
  $username   = $ghinfo['user'];
  $repository = $ghinfo['repo'];
  
  $info = new \GithubRP\GithubBaseInfo($username, $repository); //store github repository information
  $grd = new \GithubRP\GithubReleasesDownloader($info);         //download github repository releases
  $rl = $grd->getReleaseList(FALSE, TRUE);                      //parse the releases
  
  //show release date, tag, and url to the release sourcecode.
  foreach($rl as $release) 
  {
    echo date("[d M Y] ", strtotime($release->getUpdated()) );
    echo $release->getTag();
    echo " ";
    echo $release->getSourceCodeUrl();
    echo PHP_EOL;
  }
