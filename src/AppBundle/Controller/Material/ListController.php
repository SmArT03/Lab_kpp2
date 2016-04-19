<?php

namespace AppBundle\Controller\Material;

use Admingenerated\AppBundle\BaseMaterialController\ListController as BaseListController;
/**
 * ListController
 */
class ListController extends BaseListController
{
    
//    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        \Symfony\Component\VarDumper\VarDumper::dump($em->getFilters());die;
//        $this->request = $request;
//            
//
//        $this->parseRequestForPager();
//
//        // Scopes have to be processed before the filter form is initialized
//        // so default scopes are synchronized with filters.
//        $scopes = $this->getScopes();
//        $form = $this->getFilterForm();
//
//        return $this->render('AppBundle:MaterialList:index.html.twig', $this->getAdditionalRenderParameters() + array(
//            'Materials' => $this->getPager(),
//            'listRoute'                 => $this->getListRoute(),
//            'filtersUrl'                => $this->getFiltersUrl(),
//            'form'                      => $form->createView(),
//            'sortColumn'                => $this->getSortColumn(),
//            'sortOrder'                 => $this->getSortOrder(),
//            'scopes'                    => $scopes,
//            'perPageChoices'            => $this->getPerPageChoices(),
//        ));
//    }
}
