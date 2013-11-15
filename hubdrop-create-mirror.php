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
// Default path
else {
  $path = '.';
}

$hubdrop_github_org = 'drupal-project';

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

// @TODO: Invoke GitHub API to create the repo, if it doesn't exist yet.

// Change to path directory
chdir($repo_path);

// Set fetch configs to ignore pull requests
// See http://christoph.ruegg.name/blog/git-howto-mirror-a-github-repository-without-pull-refs.html
exec('git config --local --unset-all remote.origin.fetch');
exec('git config --local remote.origin.fetch "+refs/tags/*:refs/tags/*"');
exec('git config --local remote.origin.fetch "+refs/heads/*:refs/heads/*" --add');

print hexec("git remote set-url --push origin $github_git_repo");
print hexec("git fetch -p origin");
print hexec("git push --mirror");
print hexec("chmod g+w . -R");

/**
 * HubDrop Exec
 */
function hexec($cmd){
  $output = '';
  $output .= "Running $cmd \n";
  $output .="------------------\n";
  $output .= shell_exec($cmd);
  return $output;
}
