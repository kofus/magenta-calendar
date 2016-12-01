<?php

namespace Kofus\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Kofus\System\Entity\LinkEntity;
use Application\Entity\MyeAccountEntity;
use Kofus\User\Entity\AuthEntity;

class CalendarController extends AbstractActionController
{
   public function listAction()
   {
       $this->archive()->uriStack()->push();
       $entities = $this->nodes()->getRepository('CAL')->findAll();
       return new ViewModel(array(
       	    'entities' => $entities
       ));
   }
   
   public function monthAction()
   {
       $this->archive()->uriStack()->push();
       $calendar = $this->nodes()->getNode($this->params('id'), 'CAL');
       $service = $this->getServiceLocator()->get('KofusCalendarService');

       // Create month container
       $r = explode('-', $this->params('id2', date('Y-m')));
       $month = $service->getMonth($calendar, $r[0], $r[1]);

       // Build navigation
       $dt = \DateTime::createFromFormat('Y-m-d', $r[0] . '-' . $r[1] . '-01');
       $navMonths = new \Zend\Navigation\Navigation();
       $routeMatch = $this->getServiceLocator()->get('Application')->getMvcEvent()->getRouteMatch();
       for ($i = 1; $i < 13; $i += 1) {
           $dt->setDate($dt->format('Y'), $i, 1);
           $page = new \Zend\Navigation\Page\Mvc(array(
               'route' => 'kofus_calendar',
               'controller' => 'calendar',
               'action' => 'month',
               'label' => $dt->format('F'),
               'params' => array(
               'id' => $calendar->getNodeId(),
               'id2' => $dt->format('Y-m')
           )));
           $page->setRouteMatch($routeMatch);
           $navMonths->addPage($page);
       }
       
       // Years
       $years = array(date('Y'), date('Y') + 1);
       
       return new ViewModel(array(
            'month' => $month,
            'navMonths' => $navMonths,
            'years' => $years
       ));
   }
}
