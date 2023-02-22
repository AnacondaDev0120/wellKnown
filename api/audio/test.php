<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 11/19/21
 * Time: 10:26 AM
 */

require '../ffmpeg/vendor/autoload.php';

$ffmpeg = FFMpeg\FFMpeg::create();
$video = $ffmpeg->open('../TempData/1637111613_AUDIO.mp3');
$video->filters()->custom('-i ../TempData/1637111613_AUDIO.mp3 -filter:a "atempo=1.7" -c:a libfaac -q:a 100');
$format->setAudioChannels(2)->setAudioKiloBitrate(256);

$video->save( $format, '../TempData/1637111613_AUDIO.mp3');