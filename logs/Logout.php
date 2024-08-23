<?php

session_start();
session_destroy();
header('Location: alldevicelog.php');
?>