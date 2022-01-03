<?php
$link='https://headin.t8s.ru/Api/V2/GetEdUnits';

$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

curl_setopt($curl,CURLOPT_URL,$link);
curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($request));
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

$out=curl_exec($curl);
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
curl_close($curl);



$Response=json_decode($out,true);

?>
