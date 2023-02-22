<?php
header('Content-type: text/xml');
error_reporting(1);

include "SitemapGenerator.php";
require_once "../../includes/parse-config.php";
use Parse\ParseClient;
use Parse\ParseException;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseSessionStorage;


$outputDir = getcwd();

$generator = new \Icamys\SitemapGenerator\SitemapGenerator('https://app.fablefrog.com', $outputDir);

// will create also compressed (gzipped) sitemap
$generator->toggleGZipFileCreation();

// determine how many urls should be put into one file;
// this feature is useful in case if you have too large urls
// and your sitemap is out of allowed size (50Mb)
// according to the standard protocol 50000 is maximum value (see http://www.sitemaps.org/protocol.html)
$generator->setMaxURLsPerSitemap(50000);

// sitemap file name
$generator->setSitemapFileName("sitemap.xml");

// sitemap index file name
$generator->setSitemapIndexFileName("sitemap-index.xml");

// alternate languages
//TODO call the products
$ProductsQuery = new ParseQuery("Buzz");
$ProductsQuery->limit(10000);
$Products = $ProductsQuery->find();
foreach ($Products as $product){
    try{
        $alternates = array();
        $Url = "index.php?id=".$product->getObjectId();
        $generator->addURL('/'.$Url, new DateTime(), 'daily', 0.5, $alternates);
    }catch (Exception $ex){
        print_r($ex);
    }
}

// generate internally a sitemap
$generator->createSitemap();
// write early generated sitemap to file(s)
$generator->writeSitemap();

// update robots.txt file in output directory or create a new one
$generator->updateRobots();

// submit your sitemaps to Google, Yahoo, Bing and Ask.com
$generator->submitSitemap();

$homepage = file_get_contents('sitemap.xml');
echo $homepage;


?>