<?php
/**
 * Created by PhpStorm.
 * User: felixrupp
 * Date: 04.06.18
 * Time: 23:47
 */

namespace FelixRupp\MyFitnessPalExportConverter\Utility;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class MFPProConverter
{

    public function convert($fileName, $directDownload = FALSE)
    {

        $csvFile = file($fileName);
        $data = [];

        foreach ($csvFile as $index => $line) {

            if ($index > 0) {

                $csvRow = str_getcsv($line);

                $date = date("d.m.Y", strtotime($csvRow[0]));

                $data[$date]['date'] = $date;


                if (!isset($data[$date]['calories'])) {

                    $data[$date]['calories'] = 0;
                }
                $data[$date]['calories'] += floatval($csvRow[2]);


                if (!isset($data[$date]['fats'])) {

                    $data[$date]['fats'] = 0;
                }
                $data[$date]['fats'] += floatval($csvRow[3]);


                if (!isset($data[$date]['saturatedFats'])) {

                    $data[$date]['saturatedFats'] = 0;
                }
                $data[$date]['saturatedFats'] += floatval($csvRow[4]);


                if (!isset($data[$date]['multiSaturatedFats'])) {

                    $data[$date]['multiSaturatedFats'] = 0;
                }
                $data[$date]['multiSaturatedFats'] += floatval($csvRow[5]);


                if (!isset($data[$date]['singleSaturatedFats'])) {

                    $data[$date]['singleSaturatedFats'] = 0;
                }
                $data[$date]['singleSaturatedFats'] += floatval($csvRow[6]);


                if (!isset($data[$date]['transFats'])) {

                    $data[$date]['transFats'] = 0;
                }
                $data[$date]['transFats'] += floatval($csvRow[7]);


                if (!isset($data[$date]['colesterine'])) {

                    $data[$date]['colesterine'] = 0;
                }
                $data[$date]['colesterine'] += floatval($csvRow[8]);


                if (!isset($data[$date]['natrium'])) {

                    $data[$date]['natrium'] = 0;
                }
                $data[$date]['natrium'] += floatval($csvRow[9]);


                if (!isset($data[$date]['calium'])) {

                    $data[$date]['calium'] = 0;
                }
                $data[$date]['calium'] += floatval($csvRow[10]);


                if (!isset($data[$date]['carbs'])) {

                    $data[$date]['carbs'] = 0;
                }
                $data[$date]['carbs'] += floatval($csvRow[11]);


                if (!isset($data[$date]['ruffage'])) {

                    $data[$date]['ruffage'] = 0;
                }
                $data[$date]['ruffage'] += floatval($csvRow[12]);


                if (!isset($data[$date]['sugar'])) {

                    $data[$date]['sugar'] = 0;
                }
                $data[$date]['sugar'] += floatval($csvRow[13]);


                if (!isset($data[$date]['protein'])) {

                    $data[$date]['protein'] = 0;
                }
                $data[$date]['protein'] += floatval($csvRow[14]);


                if (!isset($data[$date]['vitaminA'])) {

                    $data[$date]['vitaminA'] = 0;
                }
                $data[$date]['vitaminA'] += floatval($csvRow[15]);


                if (!isset($data[$date]['vitaminC'])) {

                    $data[$date]['vitaminC'] = 0;
                }
                $data[$date]['vitaminC'] += floatval($csvRow[16]);


                if (!isset($data[$date]['calcium'])) {

                    $data[$date]['calcium'] = 0;
                }
                $data[$date]['calcium'] += floatval($csvRow[17]);


                if (!isset($data[$date]['iron'])) {

                    $data[$date]['iron'] = 0;
                }
                $data[$date]['iron'] += floatval($csvRow[18]);


                if (!isset($data[$date]['sumsNutrients'])) {

                    $data[$date]['sumsNutrients'] = 0;
                }
                $data[$date]['sumsNutrients'] += floatval($csvRow[3]) + floatval($csvRow[11]) + floatval($csvRow[14]);
            }
        }

        $data = array_values($data);

        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['sumsNutrients'] > 0) {

                $data[$i]['proteinPercentage'] = ($data[$i]['protein'] / $data[$i]['sumsNutrients']);
                $data[$i]['fatPercentage'] = ($data[$i]['fats'] / $data[$i]['sumsNutrients']);
                $data[$i]['carbsPercentage'] = ($data[$i]['carbs'] / $data[$i]['sumsNutrients']);
            } else {

                $data[$i]['proteinPercentage'] = 0;
                $data[$i]['fatPercentage'] = 0;
                $data[$i]['carbsPercentage'] = 0;
            }
        }

        //var_dump($data);

        $spreadsheet = new Spreadsheet();

        try {

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValueByColumnAndRow(1, 1, "Datum");
            $sheet->setCellValueByColumnAndRow(2, 1, "Kalorien");
            $sheet->setCellValueByColumnAndRow(3, 1, "Fett (g)");
            $sheet->setCellValueByColumnAndRow(4, 1, "Gesättigte Fettsäuren");
            $sheet->setCellValueByColumnAndRow(5, 1, "Mehrfach ungesättigte Fettsäuren");
            $sheet->setCellValueByColumnAndRow(6, 1, "Einfach ungesättigte Fettsäuren");
            $sheet->setCellValueByColumnAndRow(7, 1, "Transfettsäuren");
            $sheet->setCellValueByColumnAndRow(8, 1, "Cholesterin");
            $sheet->setCellValueByColumnAndRow(9, 1, "Natrium (mg)");
            $sheet->setCellValueByColumnAndRow(10, 1, "Kalium");
            $sheet->setCellValueByColumnAndRow(11, 1, "Kohlehydrate");
            $sheet->setCellValueByColumnAndRow(12, 1, "Ballaststoffe");
            $sheet->setCellValueByColumnAndRow(13, 1, "Zucker");
            $sheet->setCellValueByColumnAndRow(14, 1, "Eiweiß (g)");
            $sheet->setCellValueByColumnAndRow(15, 1, "Vitamin A");
            $sheet->setCellValueByColumnAndRow(16, 1, "Vitamin C");
            $sheet->setCellValueByColumnAndRow(17, 1, "Kalzium");
            $sheet->setCellValueByColumnAndRow(18, 1, "Eisen");
            $sheet->setCellValueByColumnAndRow(20, 1, "Anteil Fett (%)");
            $sheet->setCellValueByColumnAndRow(21, 1, "Anteil Kohlehydrate (%)");
            $sheet->setCellValueByColumnAndRow(22, 1, "Anteil Eiweiß (%)");
            $sheet->setCellValueByColumnAndRow(23, 1, "Summe Nährstoffe (g)");

            for ($i = 2; $i <= count($data); $i++) {

                $sheet->setCellValueByColumnAndRow(1, $i, $data[$i - 2]['date']);
                $sheet->setCellValueByColumnAndRow(2, $i, $data[$i - 2]['calories']);
                $sheet->setCellValueByColumnAndRow(3, $i, $data[$i - 2]['fats']);
                $sheet->setCellValueByColumnAndRow(4, $i, $data[$i - 2]['saturatedFats']);
                $sheet->setCellValueByColumnAndRow(5, $i, $data[$i - 2]['multiSaturatedFats']);
                $sheet->setCellValueByColumnAndRow(6, $i, $data[$i - 2]['singleSaturatedFats']);
                $sheet->setCellValueByColumnAndRow(7, $i, $data[$i - 2]['transFats']);
                $sheet->setCellValueByColumnAndRow(8, $i, $data[$i - 2]['colesterine']);
                $sheet->setCellValueByColumnAndRow(9, $i, $data[$i - 2]['natrium']);
                $sheet->setCellValueByColumnAndRow(10, $i, $data[$i - 2]['calium']);
                $sheet->setCellValueByColumnAndRow(11, $i, $data[$i - 2]['carbs']);
                $sheet->setCellValueByColumnAndRow(12, $i, $data[$i - 2]['ruffage']);
                $sheet->setCellValueByColumnAndRow(13, $i, $data[$i - 2]['sugar']);
                $sheet->setCellValueByColumnAndRow(14, $i, $data[$i - 2]['protein']);
                $sheet->setCellValueByColumnAndRow(15, $i, $data[$i - 2]['vitaminA']);
                $sheet->setCellValueByColumnAndRow(16, $i, $data[$i - 2]['vitaminC']);
                $sheet->setCellValueByColumnAndRow(17, $i, $data[$i - 2]['calcium']);
                $sheet->setCellValueByColumnAndRow(18, $i, $data[$i - 2]['iron']);
                $sheet->setCellValueByColumnAndRow(20, $i, $data[$i - 2]['fatPercentage']);
                $sheet->setCellValueByColumnAndRow(21, $i, $data[$i - 2]['carbsPercentage']);
                $sheet->setCellValueByColumnAndRow(22, $i, $data[$i - 2]['proteinPercentage']);
                $sheet->setCellValueByColumnAndRow(23, $i, $data[$i - 2]['sumsNutrients']);
            }

        } catch (Exception $e) {

            return FALSE;
        }

        $writer = new Xlsx($spreadsheet);

        try {

            if ($directDownload) {

                // redirect output to client browser
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="export-' . date("Y-m-d-H-i-s") . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
            } else {

                $writer->save(dirname($fileName) . "/export-" . date("Y-m-d-H-i-s") . ".xlsx");
            }

        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {

            return FALSE;
        }

        return TRUE;
    }
}