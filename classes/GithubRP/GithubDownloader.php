<?php
/**
 * @package githubReleaseParser
 * 
 * 
 */

namespace GithubRP;

/**
 * Implements downloading a file from github.com, must be extended to implement getURL()
 *
 */
abstract class GithubDownloader extends GithubBase
{
  
  protected $dataFormat;
  public $extension = "html";
  
  function init(GithubBaseInfo $ghi, $dataFormat)
  {
    parent::init($ghi);
    $this->dataFormat = $this->processDataFilenameFormat($dataFormat);
  }
  
  function __construct(GithubBaseInfo $ghi, $dataFormat = "%username%-%repositoryname%.html") 
  {
    //parent::__construct($ghi);
    $this->init($ghi, $dataFormat); 
  }
  
  /**
   * Replaces certian keywords in the $format with their actual values.
   * @param string $format
   * @return string
   */
  function processDataFilenameFormat($format) 
  {
    $format = str_replace("%username%",       $this->processCacheFilenameStr($this->getUsername()),       $format);
    $format = str_replace("%repositoryname%", $this->processCacheFilenameStr($this->getRepositoryName()), $format);
    $format = str_replace("%extension%",      $this->processCacheFilenameStr($this->extension),           $format);
   
    return $format;
  }
    
  /**
   * Replaces some unwanted chars in $str with acceptable ones.
   * @param string $str
   * @return string
   */
  protected function processCacheFilenameStr($str) 
  {
    $str = trim($str);
    $str = str_replace(" ", "_", $str);
    $str = str_replace("-", "_", $str);
    return $str;
  }
    
  /**
   * Returns the cache filename for the current GithubBaseInfo in use.
   * @return string
   */
  function cacheFilename() 
  {
    $username = $this->getUsername();
    $repositoryName = $this->getRepositoryName(); 
    $targetFile = sprintf(
      "data/".$this->processDataFilenameFormat($this->dataFormat), 
      $this->processCacheFilenameStr($username), 
      $this->processCacheFilenameStr($repositoryName)
    );
    return $targetFile;
  }
  
  /**
   * Checks to see if the cache file exists. 
   */
  function hasCacheFile() 
  {
    $fn = $this->cacheFilename();
    return file_exists($fn);    
  }
  
  /**
   * Saves the given data to the cache file.
   * @param string $data
   */
  function saveToCache($data) 
  {
    $targetFile = $this->cacheFilename();
    file_put_contents($targetFile, $data);    
  }
  
  /**
   * Loads the cached file, if it exists.  If not, it returns an empty string.
   * @return string
   */
  function loadFromCache() 
  {
    if ($this->hasCacheFile())
      return file_get_contents($this->cacheFilename());
    return "";
  }
  
  /**
   * Downloads the specified URL using cURL, returning the retrieved data.
   * @param string $url
   * @param array $options
   * @return string
   */
  function curlDownload($url, $options = array()) 
  {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL,             $url);
    curl_setopt($ch, CURLOPT_HEADER,          0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,  5);
    curl_setopt($ch, CURLOPT_TIMEOUT,         5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,  1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,  1);
    curl_setopt($ch, CURLOPT_MAXREDIRS,       5);
    
    curl_setopt_array($ch, $options);
    
    $ret = curl_exec($ch);
    curl_close($ch);
        
    return $ret;    
  }
  
  abstract function getURL();

}