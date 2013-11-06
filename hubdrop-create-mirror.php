#!/usr/bin/php
<?php

// Get Project from $argv
if (empty($argv[1])){
  exit("You need to specify a Drupal.org project.\n");
} else {
  $project = $argv[1];
}

// Get Path
if (!empty($argv[2])){
  if (!file_exists($argv[2])){
    exit("You must specify a path that exists.\n");
  } else {
    $path = $argv[2];
  }
}

$hubdrop_github_org = 'hubdrop-projects';

$drupal_git_repo = "http://git.drupal.org/project/$project.git";
$github_git_repo = "git@github.com:$hubdrop_github_org/$project.git";

// Hello World
print "Welcome to hubdrop.\n";
print "==================\n";
print "Cloning $drupal_git_repo...\n";
print "------------------\n";

// Clone the Drupal.org repo.
// See https://help.github.com/articles/duplicating-a-repository

if ($path){
  $repo_path = "$path/$project.git";
} else {
  $repo_path = "$project.git";
}
$clone_cmd = "git clone $drupal_git_repo $repo_path --mirror";

print "Running $clone_cmd \n";
print "------------------\n";
if (!exec($clone_cmd)){
  exit("Unable to clone repo.\n");
}
chdir($repo_path);

// @TODO: Invoke GitHub API to create the repo!!!

$cmd = "git remote set-url --push origin $github_git_repo";
print "Running $cmd \n";
print "------------------\n";
exec($cmd);

// @TODO: Call hubdrop-update-mirrors instead?
$cmd = "git fetch -p origin";
print "Running $cmd \n";
print "------------------\n";
exec($cmd);

$cmd = "git push --mirror";
print "Running $cmd \n";
print "------------------\n";
exec($cmd);
