#!/usr/bin/php
<?php

// Get Project from $argv 1
if (empty($argv[1])){
  exit("You need to specify a Drupal.org project.\n");
} else {
  $project = $argv[1];
}

// Get Source from $argv 2
if (!empty($argv[2])){

  // Ensure its either drupal or github
  if ($argv[2] != 'drupal' && $argv[2] != 'github'){
    exit("You must specify either 'drupal' or 'github' as the source repo.\n");
  } else {
    $source = $argv[2];

    // If it's drupal, we need a username:
    if ($source == 'drupal' && empty($argv[3])){
      exit("If source is drupal, you must specify a user with commit access.\n");
    } else {
      $user = $argv[3];
    }
  }
}

$hubdrop_github_org = 'hubdrop-projects';

$drupal_read_repo = "http://git.drupal.org/project/$project.git";
$drupal_write_repo = "$user@git.drupal.org:project/$project.git";
$github_git_repo = "git@github.com:$hubdrop_github_org/$project.git";

// @TODO: Un-hardcode this.
chdir("/var/hubdrop/repos/$project.git");




/**
 * HubDrop Exec
 */
function hexec($cmd){
  $cmd = "chmod g+w . -R";
  $output = '';
  $output .= "Running $cmd \n";
  $output .="------------------\n";
  $output .= shell_exec($cmd);
  return $output;
}
