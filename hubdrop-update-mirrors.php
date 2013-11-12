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

      $cmd = "git fetch -p origin";
      print "Running $cmd \n";
      print "------------------\n";
      exec($cmd);

      $cmd = "git push --mirror";
      print "Running $cmd \n";
      print "------------------\n";
      exec($cmd);

      $cmd = "chmod g+w . -R";
      print "Running $cmd \n";
      print "------------------\n";
      exec($cmd);
    }
  }
  closedir($handle);
}
