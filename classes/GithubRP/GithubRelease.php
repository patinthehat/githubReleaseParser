<?php
/**
 * @package githubReleaseParser
 *
 *
 */

namespace GithubRP;

/**
 * Stores information about a GitHub release, such as author, content (description), link, tag, etc.
 *
 */
class GithubRelease extends GithubBase
{
  protected $author;
  protected $content;
  protected $link;
  protected $tag;  
  protected $title;
  protected $updated;
  protected $sourceCodeUrl;

  function getAuthor() { return $this->author; }

  function getContent() { return $this->content; }

  function getLink() { return $this->link; }

  function getTag() { return $this->tag; }

  function getTitle() { return $this->title; }
  
  function getUpdated() { return $this->updated; }
  
  function getSourceCodeUrl() {
    return 
      sprintf("https://github.com/%s/%s/archive/%s.tar.gz", 
        $this->getUsername(), $this->getRepositoryName(), $this->getTag()
      );
  }
  
  function init(GithubBaseInfo $ghi, $author, $content, $link, $tag, $title, $updated)
  {
    parent::init($ghi);
    
    $this->author = $author;
    $this->content = $content;
    $this->link = $link;
    $this->tag = $tag;
    $this->title = $title;
    $this->updated = $updated;    
  }
  
  function __construct(GithubBaseInfo $ghi, $author, $content, $link, $tag, $title, $updated) 
  {
    //parent::__construct($ghi);
    $this->init($ghi, $author, $content, $link, $tag, $title, $updated);
  }
  
}