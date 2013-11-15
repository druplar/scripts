#!/usr/bin/php
<?php

// Hello World
print "Welcome to hubdrop.\n";
print "==================\n";

$project = '';
$source = '';
$user = 'hubdrop';

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

    // Removing this requirement.  hubdrop user makes much more sense.
    //// If it's drupal, we need a username:
    //if ($source == 'github') {
    //  if (empty($argv[3])){
    //    exit("If source is github, you must specify a drupal user with commit access to $project.\n");
    //  } else {
    //    $user = $argv[3];
    //  }
    //}
  }
} else {
  exit("You must specify either 'drupal' or 'github' as the source repo.\n");
}

$hubdrop_github_org = 'drupal-projects';

$drupal_read_repo = "http://git.drupal.org/project/$project.git";
$drupal_write_repo = "$user@git.drupal.org:project/$project.git";
$github_git_repo = "git@github.com:$hubdrop_github_org/$project.git";

// @TODO: Un-hardcode this.
$d = "/var/hubdrop/repos/$project.git";
chdir($d);

print $d . "\n";
print "------------------\n";

// @TODO: Test for access first!
if ($source == 'github'){
  print "Setting GitHub Repo as the Source.\n";
  print "----------------------------------\n";
  print hexec("git remote set-url --push origin $drupal_write_repo");
  print hexec("git remote set-url origin $github_git_repo");
}
elseif ($source == 'drupal') {
  print "Setting Drupal Repo as the Source.\n";
  print "----------------------------------\n";
  print hexec("git remote set-url --push origin $github_git_repo");
  print hexec("git remote set-url origin $drupal_read_repo");
}

/**
 * HubDrop Exec
 */
function hexec($cmd){
  $output = '';
  $output .= "Running $cmd\n";
  $output .= "------------------\n";

  $lines = array();
  exec($cmd, $lines);
  return $output . implode("\n", $lines);
}
