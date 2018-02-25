<?php

namespace Kofus\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Kofus\System\Entity\LinkEntity;
use Application\Entity\MyeAccountEntity;
use Kofus\User\Entity\AuthEntity;

class CategoryController extends AbstractActionController
{
   public function listAction()
   {
       $this->archive()->uriStack()->push();
       $categories = $this->nodes()->getRepository('CALCAT')->findAll();
       return new ViewModel(array(
       	    'categories' => $this->paginator($categories)
       ));
   }
   
}
