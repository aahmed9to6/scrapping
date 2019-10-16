<?php
ini_set('error_reporting', -1);
use PHPHtmlParser\Dom;

require 'vendor/autoload.php';
$base_url = 'https://symfonycasts.com';
$post_fix = '/download/video';
$root = __DIR__;
$tracks = [
    '/tracks/symfony',
    '/tracks/drupal',
    '/tracks/javascript',
    '/tracks/conferences',
    '/tracks/testing',
    '/tracks/oo',
    '/tracks/symfony3',
    '/tracks/rest',
    '/tracks/php',
    '/tracks/symfony2',
    '/tracks/extras',
];


function getPageTitle($dom) {
    $pageTitle = $dom->find('title');
    $removals = ['<title>', '</title>', 'Tutorial Track for ', ' | SymfonyCasts', ' Video Tutorial Screencast'];
    $trackTitle = str_replace($removals, '', $pageTitle);
    return $trackTitle;
}
foreach ($tracks as $target) {
    $dom = new Dom;
    $dom->loadFromUrl($base_url . $target);
    echo getPageTitle($dom) . '<br/>';
    $courses = $dom->find('.course-list-item');
    foreach ($courses as $course) {
        $courseLink = $base_url . $course->find('a')->getAttribute('href');
        echo $courseLink . '<br />';
        unset($dom);
        $dom = new Dom;
        $dom->loadFromUrl($courseLink);
        echo getPageTitle($dom) . '<br/>';
        $lectures = $dom->find('.chapter-list')->find('li');
        foreach ($lectures as $lecture) {
            $lectureLink = $lecture->find('a')->getAttribute('href');
            echo $base_url . $lectureLink . $post_fix . '<br />';
        }
    }
}