<?php 
namespace Kofus\Calendar\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kofus\Calendar\Entity\EntryEntity;
use Kofus\Calendar\Entity\CalendarEntity;


/**
 * @ORM\Entity
 */
class DateOfBirthEntity extends EntryEntity
{
    public function getNodeType()
    {
        return 'CALENTB';
    }
    
    public function getAge(\DateTime $currentDate=null)
    {
        if (! $this->getDateTime1()) return;
        
        if (! $currentDate) $currentDate = new \DateTime();
        $diff = $currentDate->diff($this->getDateTime1());
        return $diff->format('%y');
        
    }
    

	
	
	
}