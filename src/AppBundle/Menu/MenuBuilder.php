<?php 
namespace AppBundle\Menu;

use Admingenerator\GeneratorBundle\Menu\AdmingeneratorMenuBuilder;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder extends AdmingeneratorMenuBuilder
{

    protected $menu = [ 
        'company_vacancies' => [
            'label' => 'Студенты',
            'children' => [
                [
                    'label' => 'Успеваемость',
                    'route' => 'AppBundle_Student_list',
                ]
            ]
        ]
    ];


    public function __construct(FactoryInterface $factory, RequestStack $requestStack, $dashboardRoute = '')
    {
        parent::__construct($factory, $requestStack, $dashboardRoute);

    }

    public function sidebarMenu(array $options)
    {

        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttributes(array('class' => 'sidebar-menu'));

        if ($dashboardRoute = $this->dashboardRoute) {
            $this->addLinkRoute($menu, '', $dashboardRoute)
                ->setExtra('icon', 'fa fa-dashboard');
        }

        $this->buildMenu($this->menu, $menu);

        return $menu;
    }

    /**
     * Формирование пунктов меню
     *
     * @param array $items
     * @param ItemInterface $menu
     */
    private function buildMenu(array $items, ItemInterface $menu)
    {
        foreach ($items as $item) {
                if (isset($item['children'])) {
                    $menuItem = $this->addDropdown($menu, $item['label']);
                    $this->buildMenu($item['children'], $menuItem);
                } else {
                    $this->addLinkRoute(
                        $menu,
                        $item['label'],
                        $item['route']
                    );

                    $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');
                    if ($currentRoute == $item['route']) {
                        $this->setActive($menu);
                    }

                }
        }
    }


}