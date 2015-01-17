<?php
/**
 * @package githubReleaseParser
 * @unused
 *
 */

namespace GithubRP;



class GithubReleaseData 
{
  protected $username;
  protected $repositoryName;
  protected $data;
  
  function init($username, $repositoryName, $data)
  {
    $this->username = $username;
    $this->repositoryName = $repositoryName;
    $this->data = $data;    
  }
  
  function __construct($username, $repositoryName, $data)
  {
    $this->init($username, $repositoryName, $data);
  }
  
  function getUsername() {
    return $this->username;
  }
  
  function getRepositoryName() {
    return $this->repositoryName;
  }

  function getData() {
    return $this->data;
  }
    
}