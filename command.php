<?php

namespace FelixRupp\MyFitnessPalExportConverter;

require_once "vendor/autoload.php";

use FelixRupp\MyFitnessPalExportConverter\Utility\MFPProConverter;

/**
 * Main File
 * @package FelixRupp\MyFitnessPalExportConverter
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @copyright Felix Rupp <kontakt@felixrupp.com>
 */
if (($argc != 2) || (is_array($argv) && in_array($argv[1], array('--help', '-help', '-h', '-?')))) {
?>

Convert MyFitnessPal Pro exported .csv files to Excel

Usage: <?php echo $argv[0]; ?> <MyFitnessPalProExport.csv>

Access this help with --help, -help, -h oder -?

<MyFitnessPalProExport.csv> must be the path to a .csv file


<?php
} else {

    if (isset($argv[1])) {

        $file = ltrim(trim($argv[1]));

    } else {

        die(1);
    }


    echo "\nProcess file: " . $file . "\n\n";

    $mFPProConverter = new MFPProConverter();

    $result = $mFPProConverter->convert($file);

    if($result) {

        echo "Success!\n\n";
    }
    else {

        echo "Fail!\n\n";
    }
}