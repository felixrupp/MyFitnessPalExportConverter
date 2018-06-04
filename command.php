<?php

namespace FelixRupp\MyFitnessPalExportConverter;

require_once "vendor/autoload.php";
require_once "src/Utility/MFPConverter.php";

use FelixRupp\MyFitnessPalExportConverter\Utility\MFPConverter;

/**
 * Main File
 * @package FelixRupp\MyFitnessPalExportConverter
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @copyright Felix Rupp <kontakt@felixrupp.com>
 */
if (($argc != 2) || (is_array($argv) && in_array($argv[1], array('--help', '-help', '-h', '-?')))) {
?>

Create comskip .plist-file and convert it to Enigma2 .cuts file.

Usage: <?php echo $argv[0]; ?> <mpeg2_ts_file> (<mode>)

Access this help with --help, -help, -h oder -?

<mpeg2_ts_file> must be the path to a .ts file

(<mode>) (optional) define the mode of operation.
    'both':     default, which executes comskip
                and converts the output file to .cuts.
    'comskip':  only execute comskip.
    'convert':  only convert the comskip output to .cuts
                (you need to run comskip beforehand).

<?php
} else {

    if (isset($argv[1])) {

        $file = ltrim(trim($argv[1]));

    } else {

        die(1);
    }


    echo "\nProcess file: " . $file . "\n\n";

    $mfpConverter = new MFPConverter();

    $result = $mfpConverter->convert($file);

    if($result) {

        echo "Success!\n\n";
    }
    else {

        echo "Fail!\n\n";
    }
}