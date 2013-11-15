#!/usr/bin/php
<?php

// Hello World
print "Welcome to hubdrop.\n";
print "==================\n";

$directory = '/var/hubdrop/repos/';
if ($handle = opendir($directory)) {
  $blacklist = array('.', '..');
  while (false !== ($file = readdir($handle))) {
    if (!in_array($file, $blacklist)) {

      $full_path = $directory . $file;
      print "Updating mirror in $full_path... \n";

      chdir($full_path);

      // @TODO: Only need to leave this in for one jenkins round.
      // all new repos will get this config as they are created.
      exec('git config --local remote.origin.fetch "+refs/tags/*:refs/tags/*"');
      exec('git config --local remote.origin.fetch "+refs/heads/*:refs/heads/*" --add');

      print hexec("git fetch -p origin");
      print hexec("git push --mirror");
    }
  }
  closedir($handle);
}


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
