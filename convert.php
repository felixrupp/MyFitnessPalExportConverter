<?php

namespace FelixRupp\MyFitnessPalExportConverter;

require_once "vendor/autoload.php";
require_once "src/Utility/MFPProConverter.php";
require_once "src/Utility/MFPBasicConverter.php";

use FelixRupp\MyFitnessPalExportConverter\Utility\MFPBasicConverter;
use FelixRupp\MyFitnessPalExportConverter\Utility\MFPProConverter;

#echo "test1";

if(isset($_FILES['uploadFile'])) {

    #echo "test2";

    $file = $_FILES['uploadFile']['tmp_name'];

    #echo "test3";

    $fileType = $_FILES['uploadFile']['type'];


    if($fileType === "text/html") {

        $mFPConverter = new MFPBasicConverter();
    }
    elseif($fileType === "text/csv") {

        $mFPConverter = new MFPProConverter();
    }

    #echo "test4";

    $mFPConverter->convert($file, TRUE);

    #echo "test5";
}