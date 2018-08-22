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

class MFPBasicConverter
{

    public function convert($fileName, $directDownload = FALSE)
    {

        $data = [];

        try {
            $doc = new \DOMDocument();
            @$doc->loadHTMLFile($fileName);


            $finder = new \DomXPath($doc);
            $classname = "food";
            $allDays = $finder->query("//*[contains(concat(' ', normalize-space(@id), ' '), ' $classname ')]");


            $classname = "date";
            $allH2s = $finder->query("//*[contains(concat(' ', normalize-space(@id), ' '), ' $classname ')]");

            $rowIndex = 0;
            $lastDateTimeObject = NULL;

            foreach ($allDays as $index => $oneDay) {

                #echo "<h2>Tag: " . $allH2s->item($index)->nodeValue . "</h2>";

                $tableRows = $oneDay->getElementsByTagName('tfoot');

                foreach ($tableRows as $tableRow) {

                    $tableCells = $tableRow->getElementsByTagName('td');

                    $dateString = $allH2s->item($index)->nodeValue;

                    $dateString = str_replace("Januar", "January", $dateString);
                    $dateString = str_replace("Februar", "February", $dateString);
                    $dateString = str_replace("März", "March", $dateString);
                    #$dateString = str_replace("April", "April", $dateString);
                    $dateString = str_replace("Mai", "May", $dateString);
                    $dateString = str_replace("Juni", "June", $dateString);
                    $dateString = str_replace("Juli", "July", $dateString);
                    #$dateString = str_replace("August", "August", $dateString);
                    #$dateString = str_replace("September", "September", $dateString);
                    $dateString = str_replace("Oktober", "October", $dateString);
                    #$dateString = str_replace("November", "November", $dateString);
                    $dateString = str_replace("Dezember", "December", $dateString);

                    $dateTimeObject = date_create_from_format("j. F Y", $dateString);

                    if ($lastDateTimeObject instanceof \DateTime) {

                        $interval = $dateTimeObject->diff($lastDateTimeObject);
                        $intervalInt = intval($interval->d);


                        for ($i = 1; $i < $intervalInt; $i++) {

                            $data[$rowIndex]['date'] = '';
                            $data[$rowIndex]['kcalIn'] = '';
                            $data[$rowIndex]['fat'] = '';
                            $data[$rowIndex]['carbs'] = '';
                            $data[$rowIndex]['proteins'] = '';

                            $rowIndex++;
                        }

                    }

                    $data[$rowIndex]['date'] = $dateTimeObject->format("d.m.y");

                    $kalIn = $tableCells->item(1)->nodeValue;
                    $data[$rowIndex]['kcalIn'] = floatval(str_replace(".", "", $kalIn));

                    $fat = $tableCells->item(3)->nodeValue;
                    $data[$rowIndex]['fat'] = floatval(str_replace("g", "", $fat));

                    $carbs = $tableCells->item(2)->nodeValue;
                    $data[$rowIndex]['carbs'] = floatval(str_replace("g", "", $carbs));

                    $proteins = $tableCells->item(4)->nodeValue;
                    $data[$rowIndex]['proteins'] = floatval(str_replace("g", "", $proteins));

                    $lastDateTimeObject = $dateTimeObject;
                }

                $rowIndex++;
            }

            #var_dump($data);

        } catch (\Exception $e) {

            echo $e->getTrace();
        }

        #exit;

        $spreadsheet = new Spreadsheet();

        try {

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValueByColumnAndRow(1, 1, "Datum");
            $sheet->setCellValueByColumnAndRow(2, 1, "Tag");
            $sheet->setCellValueByColumnAndRow(3, 1, "Kcal verbraucht");
            $sheet->setCellValueByColumnAndRow(4, 1, "Kcal verbr korr");
            $sheet->setCellValueByColumnAndRow(5, 1, "Kcal in");
            $sheet->setCellValueByColumnAndRow(6, 1, "Defizit");
            $sheet->setCellValueByColumnAndRow(7, 1, "Defizit (kg)");
            $sheet->setCellValueByColumnAndRow(8, 1, "Def korr kg");
            $sheet->setCellValueByColumnAndRow(9, 1, "F (g)");
            $sheet->setCellValueByColumnAndRow(10, 1, "F Ziel");
            $sheet->setCellValueByColumnAndRow(11, 1, "KH (g)");
            $sheet->setCellValueByColumnAndRow(12, 1, "KH Ziel");
            $sheet->setCellValueByColumnAndRow(13, 1, "EW (g)");
            $sheet->setCellValueByColumnAndRow(14, 1, "EW Ziel");


            for ($i = 2; $i <= count($data); $i++) {

                $sheet->setCellValueByColumnAndRow(1, $i, $data[$i - 2]['date']);
                $sheet->setCellValueByColumnAndRow(5, $i, $data[$i - 2]['kcalIn']);
                $sheet->setCellValueByColumnAndRow(9, $i, $data[$i - 2]['fat']);
                $sheet->setCellValueByColumnAndRow(11, $i, $data[$i - 2]['carbs']);
                $sheet->setCellValueByColumnAndRow(13, $i, $data[$i - 2]['proteins']);
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