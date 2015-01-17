<?php
/**
 * @package githubReleaseParser
 *
 *
 */

namespace GithubRP;


/**
 * Base class from which the other classes are derived.  Stores a GithubBaseInfo instance. 
 *
 */
class GithubBase
{
  protected $info;

  function init(GithubBaseInfo $ghi)
  {
    $this->info = $ghi;
  }
  
  function __construct(GithubBaseInfo $ghi)
  {
    $this->init($ghi);
  }

  /**
   * Return the saved github username 
   */
  function getUsername()
  {
    return $this->info->getUsername();
  }
  
  /**
   * Return the saved github repository name
   */
  function getRepositoryName()
  {
    return $this->info->getRepositoryName();
  }  
  
}