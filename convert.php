<?php

namespace FelixRupp\MyFitnessPalExportConverter;

require_once "vendor/autoload.php";
require_once "src/Utility/MFPConverter.php";

use FelixRupp\MyFitnessPalExportConverter\Utility\MFPConverter;

#echo "test1";

if(isset($_FILES['uploadFile'])) {

    #echo "test2";

    $file = $_FILES['uploadFile']['tmp_name'];

    #echo "test3";

    $mfpConverter = new MFPConverter();

    #echo "test4";

    $mfpConverter->convert($file, TRUE);

    #echo "test5";
}