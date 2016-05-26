<?php //

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
    public function excelAction(Request $request, $key = null) {

        $form = $this->createFormBuilder()
                ->add('dateRange', \Admingenerator\FormExtensionsBundle\Form\Type\DateRangePickerType::class, array(
                    'label' => 'Укажите диапазон',
                    'startDate' => date('Y-m-2'),
                    'minDate' => date('2012-01-01'),
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
            $dateRang = $form->getData();
            $dateStart = split("\| ", $dateRang["dateRange"]);

            // Create the PHPExcel object with some standard values
            try {
                $phpexcel = $this->get('phpexcel');
            } catch (ServiceNotFoundException $e) {
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
                $tempFile = sys_get_temp_dir() . '/' .
                        rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
                $writer->save($tempFile);
                readfile($tempFile);
                unlink($tempFile);
            }, 200, array()
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
                ->select(' mat.name as matName, c.name as codeName, mat.id as matId')
                ->from('AppBundle\Entity\Inventory', 'inv')
                ->innerJoin('inv.material', 'mat')
                ->innerJoin('mat.code', 'c')
//                ->where('inv.date >= :from AND inv.date <= :to')
//                ->setParameter('from', $dateStart[0])
//                ->setParameter('to', $dateStart[1])
                ->getQuery()
                ->getResult();
        
        $resultBalanseConsumption = $em->createQueryBuilder()
                ->select('SUM(con.quantity) as BalanseConsumptionQuantity, mat.id as matId')
                ->from('AppBundle\Entity\Consumption', 'con')
                ->innerJoin('con.material', 'mat')
                ->where('con.date < :from ')
                ->setParameter('from', $dateStart[0])
                ->groupBy('con.material')
                ->getQuery()
                ->getResult();
        
        $resultInventory = $em->createQueryBuilder()
                ->select('inv.afterInventory as lastInventory, mat.id as matId')
                ->from('AppBundle\Entity\Inventory', 'inv')
                ->innerJoin('inv.material', 'mat')
                ->where('inv.date < :from ')
                ->andWhere('inv.afterInventory = (SELECT MAX(inv1.afterInventory) FROM AppBundle\Entity\Inventory inv1 WHERE inv1.date <= :from AND inv1.material = inv.material)')
                ->orderBy('inv.date, inv.id','DESC')
                ->setParameter('from', $dateStart[0])
                ->groupBy('inv.material')
                ->getQuery()
                ->getResult();

        $resultBalanseReceipt = $em->createQueryBuilder()
                ->select('SUM(r.quantity) as BalanseReceiptQuantity, mat.id as matId ')
                ->from('AppBundle\Entity\Receipt', 'r')
                ->innerJoin('r.material', 'mat')
                ->where('r.date < :from')
                ->setParameter('from', $dateStart[0])
                ->groupBy('r.material')
                ->getQuery()
                ->getResult();

        $result_consumption = $em->createQueryBuilder()
                ->select('SUM(con.quantity) as consumptionQuantity, gr.name as groupName, mat.id as matId')
                ->from('AppBundle\Entity\Consumption', 'con')
                ->innerJoin('con.material', 'mat')
                ->innerJoin('con.group', 'gr')
                ->where('con.date >= :from AND con.date <= :to')
                ->setParameter('from', $dateStart[0])
                ->setParameter('to', $dateStart[1])
                ->groupBy('con.material')
                ->getQuery()
                ->getResult();

        $result_receipt = $em->createQueryBuilder()
                ->select('SUM(r.quantity) as receiptQuantity, mat.id as matId ')
                ->from('AppBundle\Entity\Receipt', 'r')
                ->innerJoin('r.material', 'mat')
                ->where('r.date >= :from AND r.date <= :to')
                ->setParameter('from', $dateStart[0])
                ->setParameter('to', $dateStart[1])
                ->groupBy('r.material')
                ->getQuery()
                ->getResult();
        
        $result_receipt_price = $em->createQueryBuilder()
                ->select('r.price as lastPrice, mat.id as matId ')
                ->from('AppBundle\Entity\Receipt', 'r')
                ->innerJoin('r.material', 'mat')
                ->where('r.date >= :from AND r.date <= :to')
                ->andWhere('r.date = (SELECT MAX(r1.date) FROM AppBundle\Entity\Receipt r1 WHERE r1.material = r.material)')
                ->orderBy('r.date, r.id','DESC')
                ->setParameter('from', $dateStart[0])
                ->setParameter('to', $dateStart[1])
                ->groupBy('r.material')            
                ->getQuery()
                ->getResult();
               
             
        $recQuantiy = 0;
        $recPrice = 0;
        $balPrice = 0;
        $conPrice = 0;
        $residuePrice = 0;
        $conQuantity = 0;
        $balanceForPeriod = 0;
        $balance = 0;
        
        
        $arr = array();
       
        foreach ($result as $material){
            if(!isset($arr[$material['matId']])){
                $arr[$material['matId']] = array();
                $arr[$material['matId']]['matName'] = $material['matName'];
                $arr[$material['matId']]['codeName'] = $material['codeName'];
                $arr[$material['matId']]['receiptQuantity'] =0;
                $arr[$material['matId']]['lastPrice'] =0;
                $arr[$material['matId']]['consumptionQuantity'] =0;
                $arr[$material['matId']]['groupName'] =0;
                $arr[$material['matId']]['BalanseReceiptQuantity'] =0;
                $arr[$material['matId']]['BalanseConsumptionQuantity'] =0;
                $arr[$material['matId']]['lastInventory'] =0;
                
            }
            foreach ($result_receipt_price as $receiptPrice){
                if($receiptPrice['matId'] == $material['matId']){
                    $arr[$material['matId']]['lastPrice'] = $receiptPrice['lastPrice'];
                }
            }
            foreach ($resultInventory as $inventory){
                if($inventory['matId'] == $material['matId']){
                    $arr[$material['matId']]['lastInventory'] = $inventory['lastInventory'];
                }
            }          
            foreach ($result_receipt as $receipt){
                if($receipt['matId'] == $material['matId']){
                    $arr[$material['matId']]['receiptQuantity'] = $receipt['receiptQuantity'];
                }
            }  
            foreach ($result_consumption as $consumption){
                if($consumption['matId'] == $material['matId']){
                    $arr[$material['matId']]['consumptionQuantity'] = $consumption['consumptionQuantity'];
                    $arr[$material['matId']]['groupName'] = $consumption['groupName'];
                }
            }
            foreach ($resultBalanseReceipt as $Balansereceipt){
                if($receipt['matId'] == $material['matId']){
                    $arr[$material['matId']]['BalanseReceiptQuantity'] = $Balansereceipt['BalanseReceiptQuantity'];
                }
            }
            foreach ($resultBalanseConsumption as $BalanseConsumption){
                if($receipt['matId'] == $material['matId']){
                    $arr[$material['matId']]['BalanseConsumptionQuantity'] = $BalanseConsumption['BalanseConsumptionQuantity'];
                }
            }
        }
         $i=0;
        foreach ($arr as $value){
            $sheet->setCellValue('F' . $row, $value["lastInventory"] + $value["BalanseReceiptQuantity"] - $value["BalanseConsumptionQuantity"]);
            $sheet->setCellValue('G' . $row, ($value["lastInventory"] + $value["BalanseReceiptQuantity"] - $value["BalanseConsumptionQuantity"]) * $value["lastPrice"]);

            $balance+=$value["BalanseReceiptQuantity"] - $value["BalanseConsumptionQuantity"];
            $balPrice+=($value["BalanseReceiptQuantity"] - $value["BalanseConsumptionQuantity"]) * $value["lastPrice"];

            $id = $i + 1;
            $sheet->setCellValue('B' . $row, $id);
            $sheet->setCellValue('C' . $row, $value["groupName"]);
            $sheet->setCellValue('D' . $row, $value["codeName"]);
            $sheet->setCellValue('E' . $row, $value["matName"]);

            
            $sheet->setCellValue('H' . $row, $value["receiptQuantity"]);
            $sheet->setCellValue('I' . $row, $value["lastPrice"] * $value["receiptQuantity"]);
            $sheet->setCellValue('J' . $row, $value["consumptionQuantity"]);
            $sheet->setCellValue('K' . $row, $value["lastPrice"] * $value["consumptionQuantity"]);
            $sheet->setCellValue('L' . $row, $value["lastInventory"] + $value["receiptQuantity"] - $value["consumptionQuantity"]);
            $sheet->setCellValue('M' . $row, $value["lastPrice"] * ($value["lastInventory"] + $value["receiptQuantity"] - $value["consumptionQuantity"]));

            $recQuantiy+=$value["receiptQuantity"];
            $recPrice+=$value["lastPrice"] * $value["receiptQuantity"];
            $conQuantity+=$value["consumptionQuantity"];
            $conPrice+=$value["lastPrice"] * $value["consumptionQuantity"];
            $balanceForPeriod+=$value["lastInventory"] + $value["receiptQuantity"] - $value["consumptionQuantity"];
            $residuePrice+=$value["lastPrice"] * ($value["lastInventory"] + $value["receiptQuantity"] - $value["consumptionQuantity"]);
            $i++;
            $row++;
        }

        $sheet->setCellValue('F' . $row, $balance);
        $sheet->setCellValue('G' . $row, $balPrice);
        $sheet->setCellValue('H' . $row, $recQuantiy);
        $sheet->setCellValue('I' . $row, $recPrice);
        $sheet->setCellValue('J' . $row, $conQuantity);
        $sheet->setCellValue('K' . $row, $conPrice);
        $sheet->setCellValue('L' . $row, $balanceForPeriod);
        $sheet->setCellValue('M' . $row, $residuePrice);



        $sheet->setCellValue('B' . $row, 'Итого: ');
    }

}
