<?php 
namespace Kofus\Calendar\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kofus\System\Node;
use Kofus\Calendar\Entity\CalendarEntity;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE") 
 * @ORM\Table(name="kofus_calendar_entries")
 *
 */
class EntryEntity implements Node\NodeInterface, Node\EnableableNodeInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNodeType()
    {
        return 'CALENTRY';
    }
    
    public function getNodeId()
    {
        return $this->getNodeType() . $this->getId();
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Kofus\Calendar\Entity\CalendarEntity")
     */
    protected $calendar;
    
    public function setCalendar(CalendarEntity $entity)
    {
        $this->calendar = $entity; return $this;
    }
    
    public function getCalendar()
    {
        return $this->calendar;
    }
    
    
	/**
	 * @ORM\Column()
	 */
	protected $title;
	
	public function setTitle($value)
	{
		$this->title = $value; return $this;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $enabled = true;
	
	public function isEnabled($boolean=null)
	{
		if ($boolean !== null)
			$this->enabled = (bool) $boolean;
		return $this->enabled;
	}	
	
	public function __toString()
	{
		return $this->getTitle() . ' (' . $this->getNodeId() . ')';
	}
	
	
}