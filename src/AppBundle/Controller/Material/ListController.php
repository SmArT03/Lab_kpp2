<?php

namespace AppBundle\Controller\Material;

use Admingenerated\AppBundle\BaseMaterialController\ListController as BaseListController;

/**
 * ListController
 */
class ListController extends BaseListController {

    protected function processSort($query) {
        if ($this->getSortColumn() == 'balance') {            
        } else {
            if ($this->getSortColumn()) {
                if (!strstr($this->getSortColumn(), '.')) { //direct column
                    $query->orderBy('q.' . $this->getSortColumn(), $this->getSortOrder());
                } else {
                    $finalColumn = $this->addJoinFor($this->getSortColumn(), $query, false);
                    $query->orderBy($finalColumn, $this->getSortOrder());
                }
            }
        }
    }

}
