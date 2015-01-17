<?php
/**
 * @package githubReleaseParser
 *
 *
 */

namespace GithubRP;

/**
 * Converts a node to a value, i.e. a string.
 * 
 * @param \SimpleXMLElement $node
 * @return mixed|string
 */
function getXmlValue($node)
{
  $n = (array)$node;
  return $n[0];  
}

class GithubReleasesDownloader extends GithubDownloader {

  function __construct(GithubBaseInfo $ghi) 
  {
    parent::__construct($ghi, "%username%-%repositoryname%.atom");
    $this->dataFormat = "%username%-%repositoryname%.atom";
    $this->extension = "atom";  
  }
  
  /**
   * Return the URL to a specified releases.atom file on github.
   * 
   * @see GithubDownloader::getURL()
   */
  function getURL()
  {
    return 
      sprintf("https://github.com/%s/%s/releases.atom", 
        $this->info->getUsername(), $this->info->getRepositoryName()
      );
  }

  /**
   * Parse a github releases.atom file and return an array of GithubRelease objects
   * 
   * @param boolean $useCache
   * @param boolean $saveToCache
   * @return array:GithubRelease 
   */
  function getReleaseList($useCache = FALSE, $saveToCache = TRUE)
  { 
    if (!$useCache || !$this->hasCacheFile()) {
      $url = $this->getURL();
      $ret = $this->curlDownload($url);
      if ($saveToCache)
        $this->saveToCache($ret);
    } else {
      $ret = $this->loadFromCache();
    }

    $releases = array();
    
    $xml = simplexml_load_string($ret);
    foreach($xml->children() as $node) {
      
      if ($node->getName() == "entry") {
        $link = "/tag/0";
        foreach($node->link->attributes() as $attr=>$val)
          if ($attr=="href")
            $link = "https://github.com".getXmlValue($val);
          
        preg_match('/\/tag\/(.*)$/', $link, $m);
        $tag = $m[1];
        
        $releases[] = new GithubRelease(
            $this->info,          
            getXmlValue($node->author->name), 
            getXmlValue($node->content), 
            $link, 
            $tag, 
            getXmlValue($node->title), 
            getXmlValue($node->updated)
          );
      }
        
    }
    
    return $releases;
  }

}