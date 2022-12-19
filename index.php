<?php
ob_start();

require __DIR__ . "/src/Validate.php";
require __DIR__ . "/src/ApiConnect.php";
require __DIR__ . "/src/TicketMasterApi.php";
require __DIR__ . "/src/YouTubeApi.php";

$dataSearch = filter_input(INPUT_POST, "search", FILTER_DEFAULT);

if ($dataSearch) {
    $validateSearch = new \Src\Validate($dataSearch);
    $validateSearch->search();
    echo json_encode($validateSearch->getResponse());
} else {
    require __DIR__ . "/theme/index.php";
}

ob_end_flush();