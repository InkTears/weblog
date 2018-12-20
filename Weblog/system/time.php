<?php

$time = date_create();
date_timestamp_set($time,strtotime($billet->created));
echo date_format($time,'d-m-Y à H:i:s');

?>