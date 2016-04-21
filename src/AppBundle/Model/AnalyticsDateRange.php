<?php

namespace AppBundle\Model;

class AnalyticsDateRange {
    
        private $dateStart;
        
        private $dateEnd;
   
        
    public function setDateStart($dateStart) {
        $this->dateStart = $dateStart;

        return $this;
    }

    
    public function getDateStart() {
        return $this->dateStart;
    }
       public function setDateEnd($dateEnd) {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    
    public function getDateEnd() {
        return $this->dateEnd;
    }
}
