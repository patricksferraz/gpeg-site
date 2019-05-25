<?php
session_name(md5('blocker_gpge' . $_SERVER['REMOTE_ADDR'] . 'blocker_gpge' . $_SERVER['HTTP_USER_AGENT'] . 'blocker_gpge'));
session_start();
?>