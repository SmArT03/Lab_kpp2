<?php

namespace AppBundle\Controller\Material;

use Admingenerated\AppBundle\BaseMaterialController\ExcelController as BaseExcelController;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Admingenerator\FormExtensionsBundle\Form\Type\DateRangePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * ExcelController
 */
class ExcelController extends BaseExcelController {

    public function excelAction(Request $request)
    {
        $task = new \AppBundle\Entity\Material();
        $task->setname('Write a name');
        
         $form = $this->createFormBuilder()
            ->add('period', DateRangePickerType::class)
            ->add('name', TextType::class)
            ->add('filter', SubmitType::class, array('label' => 'date'))
            ->getForm();

        
    $form->handleRequest($request);
    
    
 if ($form->isSubmitted() && $form->isValid()) {
     
        // ... perform some action, such as saving the task to the database

        //return $this->redirectToRoute('task_success');
    }
    
    
         return $this->render('AppBundle:MaterialExcel:index.html.twig', array(
            'form' => $form->createView(),
        ));

         
     
    }
        
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
