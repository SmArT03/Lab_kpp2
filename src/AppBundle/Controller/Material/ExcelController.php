<?php

namespace AppBundle\Controller\Material;

use Admingenerated\AppBundle\BaseMaterialController\ExcelController as BaseExcelController;

use Symfony\Component\PropertyAccess\PropertyAccess;
/**
 * ExcelController
 */
class ExcelController extends BaseExcelController
{
    
    
    

    /**
     * Override this method to add your own creator, title and more to the Excel spreadsheet
     */
    protected function createExcelObject(\PHPExcel $phpExcelObject)
    {
        $phpExcelObject->getProperties()->setCreator("AdminGeneratorBundle")
          ->setTitle('Аналитический отчет ЗИП материалов')
          ->setDescription("Отчет по выбранному периоду");
    }

    /**
     * Fill the Excel speadsheet with the headers
     */
    protected function createExcelheader(\PhpExcel_Worksheet $sheet)
    {
        $translator = $this->get('translator');

        $colNum = 1;
                                $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" № ", array(), 'Admin'), true);
            $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
            $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

            $colNum++;
                                            $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" Наименование ", array(), 'Admin'), true);
            $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
            $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

            $colNum++;
                                            $sheet->setCellValueByColumnAndRow($colNum, 1, $translator->trans(" Код ЗИП ", array(), 'Admin'), true);
            $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($colNum);
            $sheet->getStyle($columnLetter . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);

            $colNum++;
                        }

    /**
     * Fills the Excel spreadsheet with data
     */
    protected function createExcelData(\PhpExcel_Worksheet $sheet)
    {
        $row = 2;
        $results = $this->getResults();

        foreach($results as $Material) {
            $colNum = 1;
                                            $data = $this->getValueForCell('id', $Material);
                $formatedValue = $this->formatId($data);

                // Convert DateTime object to given format
                if ($formatedValue instanceof \DateTime){
                    $formatedValue = $formatedValue->format('Y-m-d H:i:s');
                }

                $sheet->setCellValueByColumnAndRow($colNum, $row, $formatedValue);
                            // Inc is outside of the credentials check to be sync with headers.
            // Otherwise if column X is authorized but depending on object, there will
            // be some offset. Putting inc outise of the check will always update it.
            $colNum++;
                                            $data = $this->getValueForCell('name', $Material);
                $formatedValue = $this->formatName($data);

                // Convert DateTime object to given format
                if ($formatedValue instanceof \DateTime){
                    $formatedValue = $formatedValue->format('Y-m-d H:i:s');
                }

                $sheet->setCellValueByColumnAndRow($colNum, $row, $formatedValue);
                            // Inc is outside of the credentials check to be sync with headers.
            // Otherwise if column X is authorized but depending on object, there will
            // be some offset. Putting inc outise of the check will always update it.
             $colNum++;
                                            $data = $this->getValueForCell('code', $Material);
                $formatedValue = $this->formatCode($data);

                // Convert DateTime object to given format
                if ($formatedValue instanceof \DateTime){
                    $formatedValue = $formatedValue->format('Y-m-d H:i:s');
                }

                $sheet->setCellValueByColumnAndRow($colNum, $row, $formatedValue);
                            // Inc is outside of the credentials check to be sync with headers.
            // Otherwise if column X is authorized but depending on object, there will
            // be some offset. Putting inc outise of the check will always update it.
            $colNum++;
            
            $row++;
        }
    }
    
    /**
     * Gets the value from the given field that will be place at an Excel cell
     *
     * @param string $field   The name of the field to extract the value
     * @param mixed  $Material The main entity object
     *
     * @return $data The data to place on the respective Excel cell
     */
    protected function getValueForCell($field, $Material)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $data = $Material;
        
        // Retrieve relations, but stop on $data = null
        while (($pos = strpos($field, '.')) > 0 && $data !== null) {
            $data = $accessor->getValue($data, substr($field, 0, $pos));
            $field = substr($field, $pos + 1);
        }
        
        if($data !== null) {
            $data = $accessor->getValue($data, $field);
        }

        // Convert DateTime object to given format
        if ($data instanceof \DateTime) {
            $data = $data->format('Y-m-d H:i:s');
        }

        return $data;
    }

        protected function getResults()
    {
        return $this->getQuery()->getResult();
    }

        /**
     * Format column id value
     *
     * @param mixed The value
     * @return mixed The formated value
     */
    protected function formatId($value)
    {
        return $value;
    }

        /**
     * Format column name value
     *
     * @param mixed The value
     * @return mixed The formated value
     */
    protected function formatName($value)
    {
        return $value;
    }


        /**
     * Format column code value
     *
     * @param mixed The value
     * @return mixed The formated value
     */
    protected function formatCode($value)
    {
        return $value;
    } 
    
}