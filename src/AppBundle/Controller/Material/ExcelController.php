<?php

namespace AppBundle\Controller\Material;

use Admingenerated\AppBundle\BaseMaterialController\ExcelController as BaseExcelController;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * ExcelController
 */
class ExcelController extends BaseExcelController {
//
//    public function excelAction(Request $request)
//    {
//        $this->request = $request;
//            
//        
//        // Create the PHPExcel object with some standard values
//        try {
//          $phpexcel = $this->get('phpexcel');
//        } catch (ServiceNotFoundException $e){
//          throw new \Exception('You will need to enable the PHPExcel bundle for this function to work.', null, $e);
//        }
//
//        $phpExcelObject = $phpexcel->createPHPExcelObject();
//        $this->createExcelObject($phpExcelObject);
//        $sheet = $phpExcelObject->setActiveSheetIndex(0);
//
//        // Create the first bold row in the Excel spreadsheet
//        $this->createExcelHeader($sheet);
//
//        // Print the data
//        $this->createExcelData($sheet);
//
//        // Create the Writer, Response and add header
//        $writer = $phpexcel->createWriter($phpExcelObject, 'Excel2007');
//        $response = new StreamedResponse(
//            function () use ($writer) {
//                $tempFile = $this->get('kernel')->getCacheDir().'/'. 
//                    rand(0, getrandmax()).rand(0, getrandmax()).".tmp";
//                $writer->save($tempFile);
//                readfile($tempFile);
//                unlink($tempFile);
//            },
//            200, array()
//        );    
//        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
//        $response->headers->set('Content-Disposition', 'attachment;filename=admin_export_material.xlsx');
//
//        return $response;
//    }
//    
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager() {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Override this method to add your own creator, title and more to the Excel spreadsheet
     */
    protected function createExcelObject(\PHPExcel $phpExcelObject) {
        $phpExcelObject->getProperties()->setCreator("AdminGeneratorBundle")
                ->setTitle('Аналитический отчет ЗИП материалов')
                ->setDescription("Отчет по выбранному периоду");
    }

    /**
     * Fill the Excel speadsheet with the headers
     */
    protected function createExcelheader(\PhpExcel_Worksheet $sheet) {
        $translator = $this->get('translator');

        $colNum = 1;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" № ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" Группа ЗИП ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" Код ЗИП ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" Наименование ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" ост. Начало периода ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans("  $  ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" приход ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans("  $  ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" расход ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans("  $  ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" остаток ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

        $colNum++;
        $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans("  $  ", array(), 'Admin'), true);
        $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
        $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        
               
    }

    /**
     * Fills the Excel spreadsheet with data
     */
    protected function createExcelData(\PhpExcel_Worksheet $sheet) {
        $row = 2;
        $em = $this->getEntityManager();

        $result = $em->createQueryBuilder()
                ->select('mat.id, mat.name as matName, c.name as codeName, con.quantity as consumptionQuantity, '
                        . 'gr.name as groupName, r.quantity as receiptQuantity, r.price as receiptPrice')
                ->from('AppBundle\Entity\Material', 'mat')
                ->leftJoin('mat.code', 'c')
                ->leftjoin('mat.consumptions', 'con') 
                ->leftjoin('mat.receipts', 'r')                               
                ->leftjoin('con.group', 'gr')
                ->getQuery()
                ->getResult();
               
        $recQuantiy=0;
        $recPrice=0;
        $conQuantity=0;
        for ($i=0; $i<count($result);$i++)
        {
        $sheet->setCellValue('B' . $row, $result[$i]["id"]);
        $sheet->setCellValue('C' . $row, $result[$i]["groupName"]);
        $sheet->setCellValue('D' . $row, $result[$i]["codeName"]);
        $sheet->setCellValue('E' . $row, $result[$i]["matName"]);
//        $sheet->setCellValue('F' . $row, $result[$i]["quantity"]);
//        $sheet->setCellValue('G' . $row, $result[$i]["quantity"]);
        $sheet->setCellValue('H' . $row, $result[$i]["receiptQuantity"]);
        $sheet->setCellValue('I' . $row, $result[$i]["receiptPrice"]);
        $sheet->setCellValue('J' . $row, $result[$i]["consumptionQuantity"]);
//        $sheet->setCellValue('K' . $row, $result[$i]["consumptionPrice"]);
        
        $recQuantiy+=$result[$i]["receiptQuantity"];
        $recPrice+=$result[$i]["receiptPrice"];
        $conQuantity+=$result[$i]["consumptionQuantity"];
        $row++;

        
        }
        $sheet->setCellValue('H' . $row, $recQuantiy);
        $sheet->setCellValue('I' . $row, $recPrice);
        $sheet->setCellValue('J' . $row, $conQuantity);
        
        
        $row2=count($result)+1;
        $sheet->setCellValue('B' . $row, 'Итого: ');
//
//        $sheet->setCellValue('F' . $row, '=SUM(F2:F' . $row2 . ')');
//        $sheet->setCellValue('G' . $row, '=SUM(G2:G' . $row2 . ')');
//        $sheet->setCellValue('H' . $row, '=SUM(H2:H' . $row2 . ')');
//        $sheet->setCellValue('I' . $row, '=SUM(I2:I' . $row2 . ')');
//        $sheet->setCellValue('J' . $row, '=SUM(J2:J' . $row2 . ')');
//        $sheet->setCellValue('K' . $row, '=SUM(K2:K' . $row2 . ')');
//        $sheet->setCellValue('L' . $row, '=SUM(L2:L' . $row2 . ')');
//        $sheet->setCellValue('M'.$row, '=SUM(M2:M'.$row2.')');
//                
        }

}
