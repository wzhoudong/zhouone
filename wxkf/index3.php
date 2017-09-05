<?php 
$urls = array(
    'http://www.afefgrw.top/index.html',
    'http://www.afefgrw.top/index.html',
);
$api = 'http://data.zz.baidu.com/urls?site=http://www.96u.com/&token=CBU8UZEg8KltiDD4&type=officialaccounts';
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
echo $result;
?>
