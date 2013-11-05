#!/usr/bin/php
<?php

// Get Project from $argv
if (empty($argv[1])){
  exit("You need to specify a Drupal.org project.\n");
}

$project = $argv[1];

$hubdrop_github_org = 'hubdrop-projects';

$drupal_git_repo = "http://git.drupal.org/project/$project.git";
$github_git_repo = "https://github.com/$hubdrop_github_org/$project.git";

// Hello World
print "Welcome to hubdrop.\n";
print "==================\n";
print "Cloning $drupal_git_repo...\n";
print "------------------\n";

// Clone the Drupal.org repo.
// See https://help.github.com/articles/duplicating-a-repository
$clone_cmd = "git clone $drupal_git_repo --mirror";

print "Running $clone_cmd \n";
print "------------------\n";
if (!exec($clone_cmd)){
  exit("Unable to clone repo.\n");
}
chdir("$project.git");

//$cmd = "cd $project.git";
//print "Running $cmd\n";
//print "------------------\n";
//exec($cmd);


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
