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
       $calendar = $this->nodes()->getNode($this->params('id', 'CAL1'), 'CAL');
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
           'calendar' => $calendar,
            'navMonths' => $navMonths,
            'years' => $years
       ));
   }
   
    public function exportAction()
    {
        date_default_timezone_set('Europe/Berlin');
        
        $calendar = $this->nodes()->getNode($this->params('id', 'CAL1'), 'CAL');
        $events = $this->nodes()->getRepository('CALENT')->findBy(array('calendar' => $calendar));
       
        $vCalendar = new \Eluceo\iCal\Component\Calendar($calendar->getTitle());
        foreach ($events as $event) {
            $vEvent = new \Eluceo\iCal\Component\Event();
            $vEvent->setDtStart($event->getDateTime1());
            $vEvent->setNoTime(! $event->hasTime1());
            
            if ($event->getDateTime2()) {
                $vEvent->setDtEnd($event->getDateTime2());
            }
            
            $vEvent->setSummary($event->getTitle());
            $vEvent->setDescriptionHTML($event->getContent());
            $vEvent->setTimezoneString('Europe/Berlin');
            if ($event->getSite()) {
                $site = $event->getSite();
                $location = array();
                if ($site->getAddressAdditional())
                    $location[] = $site->getAddressAdditional();
                if ($site->getAddress())
                    $location[] = $site->getAddress();
                if ($site->getCity())
                    $location[] = trim($site->getZipCode() . ' ' . $site->getCity());
                
                $vEvent->setLocation(implode(', ', $location), $site->getTitle());
            }
            
            $categories = array();
            foreach ($event->getCategories() as $category)
                $categories[] = $category->getTitle();
            $vEvent->setCategories($categories);
           
            $vCalendar->addComponent($vEvent);
        }
        $filter = new \Kofus\System\Filter\UriSegment();
        $filename = $filter->filter($calendar->getTitle());
       
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'.ics"');
        echo $vCalendar->render();
       
        exit();
    }
}
