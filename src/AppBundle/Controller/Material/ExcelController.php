<?php

namespace AppBundle\Controller\Material;

use Admingenerated\AppBundle\BaseMaterialController\ExcelController as BaseExcelController;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * ExcelController
 */
class ExcelController extends BaseExcelController {

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
//        $results = $this->getResults();
//
//        foreach ($results as $Material) {
//            $colNum = 1;
//            $data = $this->getValueForCell('id', $Material);
//            $formatedValue = $this->formatId($data);
//
//            // Convert DateTime object to given format
//            if ($formatedValue instanceof \DateTime) {
//                $formatedValue = $formatedValue->format('Y-m-d H:i:s');
//            }
//
//            $sheet->setCellValueByColumnAndRow($colNum, $row, $formatedValue);
//
//            $colNum++;
//            $data = $this->getValueForCell('name', $Material);
//            $formatedValue = $this->formatName($data);
//
//            // Convert DateTime object to given format
//            if ($formatedValue instanceof \DateTime) {
//                $formatedValue = $formatedValue->format('Y-m-d H:i:s');
//            }
//
//            $sheet->setCellValueByColumnAndRow($colNum, $row, $formatedValue);
//
//            $colNum++;
//            $data = $this->getValueForCell('code', $Material);
//            $formatedValue = $this->formatCode($data);
//
//            // Convert DateTime object to given format
//            if ($formatedValue instanceof \DateTime) {
//                $formatedValue = $formatedValue->format('Y-m-d H:i:s');
//            }
//
//            $sheet->setCellValueByColumnAndRow($colNum, $row, $formatedValue);
//
//            $colNum++;
//
//
//
//            $row++;
//        }
         $em = $this->getEntityManager();

        $result = $em->createQueryBuilder()
                ->select('mat.id, mat.name as matName, c.name as codeName')
                ->from('AppBundle\Entity\Material', 'mat')
                ->leftJoin('mat.code', 'c')
                ->getQuery()
                ->getResult();
        
        $result1=$em->createQueryBuilder()
                ->select('con.quantity, gr.name as groupName')
                ->from('AppBundle\Entity\Consumption', 'con')
                ->leftJoin('con.group', 'gr')
                ->getQuery()
                ->getResult();
        
//        var_dump($result1);die;
        $excel_row=2;
        for ($i=0; $i<count($result);$i++)
        {
        $sheet->setCellValue('B' . $excel_row, $result[$i]["id"]);
        $sheet->setCellValue('D' . $excel_row, $result[$i]["codeName"]);
        $sheet->setCellValue('E' . $excel_row, $result[$i]["matName"]);

        $excel_row++;
        
        }
        $excel_row=2;
        for ($i=0; $i<count($result1);$i++)
        {
        $sheet->setCellValue('С' . $excel_row, $result1[$i]["groupName"]);
        $sheet->setCellValue('J' . $excel_row, $result1[$i]["quantity"]);

        $excel_row++;
        
        }
        
        $row1 = $excel_row - 1;
        var_dump($row1);die;
        $sheet->setCellValue('B' . $row, 'Итого: ');

        $sheet->setCellValue('F' . $row, '=SUM(F2:F' . $row1 . ')');
        $sheet->setCellValue('G' . $row, '=SUM(G2:G' . $row1 . ')');
        $sheet->setCellValue('H' . $row, '=SUM(H2:H' . $row1 . ')');
        $sheet->setCellValue('I' . $row, '=SUM(I2:I' . $row1 . ')');
        $sheet->setCellValue('J' . $row, '=SUM(J2:J' . $row1 . ')');
        $sheet->setCellValue('K' . $row, '=SUM(K2:K' . $row1 . ')');
        $sheet->setCellValue('L' . $row, '=SUM(L2:L' . $row1 . ')');
//    $sheet->setCellValue('M'.$row, '=SUM(M2:M'.$row1.')');


       
        
        
        }

    /**
     * Gets the value from the given field that will be place at an Excel cell
     *
     * @param string $field   The name of the field to extract the value
     * @param mixed  $Material The main entity object
     *
     * @return $data The data to place on the respective Excel cell
     */
    protected function getValueForCell($field, $Material) {
        $accessor = PropertyAccess::createPropertyAccessor();
        $data = $Material;

        // Retrieve relations, but stop on $data = null
        while (($pos = strpos($field, '.')) > 0 && $data !== null) {
            $data = $accessor->getValue($data, substr($field, 0, $pos));
            $field = substr($field, $pos + 1);
        }

        if ($data !== null) {
            $data = $accessor->getValue($data, $field);
        }

        // Convert DateTime object to given format
        if ($data instanceof \DateTime) {
            $data = $data->format('Y-m-d H:i:s');
        }

        return $data;
    }


}
