<?php

require_once "app/Log.php";

if(isset($_GET["clear"])){
    Log::clearLog();
}