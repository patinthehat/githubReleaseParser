## githubReleaseParser ##

---

`githubRP` is a set of PHP classes that can be used to retrieve the releases for a github repository.

It can be used, for example, to automate checking for project updates.

## Usage ##

To use:
`<?php

  //store repository information
  $info = new \GithubRP\GithubBaseInfo($userName, $repoName);
  
  //initialize Downloader
  $grd = new \GithubRP\GithubReleasesDownloader($info);
  
  //download and parse repository releases
  $rl = $grd->getReleaseList();

  print_r($rl);
`

## License ##
`githubRP` is available under the <a href="MIT-LICENSE">MIT license</a>.
