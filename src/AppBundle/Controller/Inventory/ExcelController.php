<?php

namespace AppBundle\Controller\Inventory;

use Admingenerated\AppBundle\BaseInventoryController\ExcelController as BaseExcelController;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;


/**
 * ExcelController
 */
class ExcelController extends BaseExcelController {

    /**
     * 
     * @Route("/excel", name="excel")
     * @Method({"GET", "POST"})
     */
    public function excelAction(Request $request)
    {     

         $form = $this->createFormBuilder()
              ->add('dateRange', \Admingenerator\FormExtensionsBundle\Form\Type\DateRangePickerType::class, array(
                  
                   'label' => 'Укажите диапазон',
                   'startDate' => date('Y-m-2'),
                   'minDate' => date ('2012-01-01'),
                   'maxDate' => date('Y-m-d'),
                   'separator' => ' | ',
              ))   
            ->add('filter', SubmitType::class, array(
                'label' => 'Создать отчет',
                'attr' => array('style' => 'padding:20'))
                    )
            ->getForm();

        
    $form->handleRequest($request);
        
 if ($form->isSubmitted() && $form->isValid()) {
     
      $this->request = $request;
      $dateRang=$form->getData();
      $dateStart=split("\| ",$dateRang["dateRange"]);
                     
        // Create the PHPExcel object with some standard values
        try {
          $phpexcel = $this->get('phpexcel');
        } catch (ServiceNotFoundException $e){
          throw new \Exception('You will need to enable the PHPExcel bundle for this function to work.', null, $e);
        }

        $phpExcelObject = $phpexcel->createPHPExcelObject();
        $this->createExcelObject($phpExcelObject);
        $sheet = $phpExcelObject->setActiveSheetIndex(0);

        // Create the first bold row in the Excel spreadsheet
        $this->createExcelHeader($sheet);

        // Print the data
        $this->createExcelDataNew($sheet, $dateStart);

        // Create the Writer, Response and add header
        $writer = $phpexcel->createWriter($phpExcelObject, 'Excel2007');
        $response = new StreamedResponse(
            function () use ($writer) {
                $tempFile = $this->get('kernel')->getCacheDir().'/'. 
                    rand(0, getrandmax()).rand(0, getrandmax()).".tmp";
                $writer->save($tempFile);
                readfile($tempFile);
                unlink($tempFile);
            },
            200, array()
        );    
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=admin_export_material.xlsx');

        return $response;
     
        
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
    protected function createExcelDataNew(\PhpExcel_Worksheet $sheet, $dateStart) {
        $row = 2;
        $em = $this->getEntityManager();
        $result = $em->createQueryBuilder()
                ->select(' mat.name as matName, c.name as codeName, inv.date')
                ->from('AppBundle\Entity\Material', 'mat')
                ->innerJoin('mat.code', 'c') 
                ->leftjoin('mat.inventories', 'inv')   
                ->where('inv.date >= :from AND inv.date <= :to')
                ->setParameter('from' , $dateStart[0] )
                ->setParameter('to' , $dateStart[1])
                ->getQuery()
                ->getResult();
        
//        SELECT quantity,SUM(quantity) FROM receipt
//        WHERE date >= '2015-04-20' AND date <= '2016-04-29'
//        GROUP BY material_id;

 $result_consumption = $em->createQueryBuilder()
                ->select('SUM(con.quantity) as consumptionQuantity, gr.name as groupName')
                ->from('AppBundle\Entity\Consumption', 'con')
                ->innerJoin('con.group', 'gr')
                ->where('con.date >= :from AND con.date <= :to')
                ->setParameter('from' , $dateStart[0] )
                ->setParameter('to' , $dateStart[1])
                ->getQuery()
                ->getResult();
        
        $result_receipt = $em->createQueryBuilder()
                ->select('SUM(r.quantity) as receiptQuantity,SUM(r.price) as receiptPrice ')
                ->from('AppBundle\Entity\Receipt', 'r')
                ->where('r.date >= :from AND r.date <= :to')
                ->setParameter('from' , $dateStart[0] )
                ->setParameter('to' , $dateStart[1])
                ->getQuery()
                ->getResult();
        
        
        
        $recQuantiy=0;
        $recPrice=0;
        $conQuantity=0;
        $balance=0;
        for ($i=0; $i<count($result);$i++)
        {
            var_dump($result_consumption);die;
            $id=$i+1;
        $sheet->setCellValue('B' . $row, $id);
        $sheet->setCellValue('C' . $row, $result_consumption[$i]["groupName"]);
        $sheet->setCellValue('D' . $row, $result[$i]["codeName"]);
        $sheet->setCellValue('E' . $row, $result[$i]["matName"]);
//        $sheet->setCellValue('F' . $row, $result[$i]["quantity"]);
        $sheet->setCellValue('G' . $row, $result_receipt[$i]["receiptPrice"]);
        $sheet->setCellValue('H' . $row, $result_receipt[$i]["receiptQuantity"]);
        $sheet->setCellValue('I' . $row, $result_receipt[$i]["receiptPrice"]);
        $sheet->setCellValue('J' . $row, $result_consumption[$i]["consumptionQuantity"]);
        $sheet->setCellValue('K' . $row, $result_receipt[$i]["receiptPrice"]);
        $sheet->setCellValue('L' . $row, $result_receipt[$i]["receiptQuantity"]-$result_consumption[$i]["consumptionQuantity"]);
        $sheet->setCellValue('M' . $row, $result_receipt[$i]["receiptPrice"]);
        
        $recQuantiy+=$result_receipt[$i]["receiptQuantity"];
        $recPrice+=$result_receipt[$i]["receiptPrice"];
        $conQuantity+=$result_consumption[$i]["consumptionQuantity"];
        $balance+=$result_receipt[$i]["receiptQuantity"]-$result_consumption[$i]["consumptionQuantity"];
        $row++;

        
        }
//        $sheet->setCellValue('F' . $row, $recPrice);
        $sheet->setCellValue('G' . $row, $recPrice);
        $sheet->setCellValue('H' . $row, $recQuantiy);
        $sheet->setCellValue('I' . $row, $recPrice);
        $sheet->setCellValue('J' . $row, $conQuantity);
        $sheet->setCellValue('K' . $row, $recPrice);
        $sheet->setCellValue('L' . $row, $balance);
        $sheet->setCellValue('M' . $row, $recPrice);
        
        
        
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
