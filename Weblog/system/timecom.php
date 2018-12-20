<?php

$time = date_create();
date_timestamp_set($time,strtotime($comment->created));
echo date_format($time,'d-m-Y à H:i:s');

?>