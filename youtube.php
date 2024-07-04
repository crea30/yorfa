<?php
$Live = $_GET['HLS'];
$ch = curl_init('https://www.youtube.com/tv');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_ENCODING, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'User-Agent: iCab/5.0 (Macintosh; U; PPC Mac OS X)',
'Accept-Encoding: gzip, deflate',
'Referer: https://www.youtube.com/tv',
'Host: www.youtube.com',
'Connection: Keep-Alive',
));
$site = curl_exec($ch);
curl_close ($ch);
$site = str_replace('\\','',$site);
preg_match('#INNERTUBE_API_KEY":"(.*?)"#',$site,$icerik);
$Key = $icerik[1];
preg_match('#visitorData":"(.*?)"#',$site,$icerik);
$Data = $icerik[1];

$YouTUBE = '{
	"context":
{
	"client":
{
	"clientName":"IOS",
	"clientVersion":"17.33.2",
	"clientScreen":"WATCH",
	"userAgent":"com.google.ios.youtube/17.33.2 (iPhone14,3; U; CPU iOS 15_6 like Mac OS X)",
	"deviceModel":"iPhone14,3",
	"acceptLanguage":"tr-TR",
	"acceptRegion":"TR",
	"utcOffsetMinutes":"180",
	"visitorData":"'.$Data.'"
}
,
	"user":
{
	"enableSafetyMode":false,
	"lockedSafetyMode":false
}
}
,
	"racyCheckOk":true,
	"contentCheckOk":true,
	"playbackContext":
{
	"contentPlaybackContext":
{
	"html5Preference":"HTML5_PREF_WANTS",
	"lactMilliseconds":"60000",
	"signatureTimestamp":19823
}
}
,
	"videoId":"'.$Live.'",
	"cpn":"icHtTqWFVo35-9tZ",
}';
$ch1 = curl_init('https://www.youtube.com/youtubei/v1/player?key='.$Key.'&prettyPrint=false');
curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_ENCODING, false);
curl_setopt($ch1, CURLOPT_POST, true);
curl_setopt($ch1, CURLOPT_POSTFIELDS, $YouTUBE);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
"x-goog-visitor-id: $Data",
'User-Agent: iCab/5.0 (Macintosh; U; PPC Mac OS X)',
'Accept-Encoding: gzip, deflate',
'Referer: https://www.youtube.com/tv',
'Content-Type: application/json',
'Host: www.youtube.com',
'Connection: Keep-Alive',
));
$site1 = curl_exec($ch1);
curl_close ($ch1);
$site1 = str_replace('\\','',$site1);
$site1 = str_replace('%2F','/',$site1);
$site1 = str_replace('%2C',',',$site1);
$site1 = str_replace('%3D%3D','==',$site1);
$site1 = str_replace('%3D','=',$site1);
preg_match('#"hlsManifestUrl":"(.*?)"#',$site1,$icerik);
$Link = $icerik[1];
header ("Location: $Link");
?>
