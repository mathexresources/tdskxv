<?php
$url = 'https://status.hukot.info/';
$html = file_get_contents($url);

$services = [];

// Match each <div class="service">...</div>
preg_match_all('/<div class="service">(.*?)<\/div>\s*<\/div>/s', $html, $matches);

foreach ($matches[1] as $serviceBlock) {
    // Match service title (before <br>)
    preg_match('/<div class="service-title">(.*?)<br>/s', $serviceBlock, $titleMatch);
    $title = trim(strip_tags($titleMatch[1] ?? ''));

    // Match SLA
    preg_match('/<small class="sla">(.*?)<\/small>/', $serviceBlock, $slaMatch);
    $sla = trim($slaMatch[1] ?? '');

    // Match Status
    preg_match('/<strong class="status.*?">(.*?)<\/strong>/', $serviceBlock, $statusMatch);
    $status = trim($statusMatch[1] ?? '');

    $services[] = ['title' => $title, 'sla' => $sla, 'status' => $status];
}

// Output result
header('Content-Type: application/json');
echo json_encode($services);