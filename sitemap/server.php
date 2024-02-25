<?php
header('Content-Type: text/html; charset=utf-8');

$sitemapUrl = $_GET['sitemapUrl'];
$sitemapData = file_get_contents($sitemapUrl);

if ($sitemapData === FALSE) {
    echo 'Error fetching sitemap data. Please check the URL.';
    exit;
}

$xml = new SimpleXMLElement($sitemapData);
$modifiedUrls = array();

foreach ($xml->url as $url) {
    $lastModified = strtotime((string)$url->lastmod);
    $sevenDaysAgo = strtotime('-7 days');

    if ($lastModified > $sevenDaysAgo) {
        $modifiedUrls[] = (string)$url->loc;
    }
}

echo '<h2>Modified URLs in the Last 7 Days:</h2>';
if (empty($modifiedUrls)) {
    echo '<p>No modified URLs found in the last 7 days.</p>';
} else {
    echo '<ul>';
    foreach ($modifiedUrls as $url) {
        echo "<li>$url</li>";
    }
    echo '</ul>';
}
?>
