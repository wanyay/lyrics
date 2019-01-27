<?php

require "vendor/autoload.php";

use Lyric\Paser\AzLyric;

$lyric = new AzLyric('Green Day', '21 Guns');

echo $lyric->getLyric();
