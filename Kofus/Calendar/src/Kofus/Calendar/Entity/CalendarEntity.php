<?php 
namespace Kofus\Calendar\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kofus\System\Node;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE") 
 * @ORM\Table(name="kofus_calendar_calendars")
 *
 */
class CalendarEntity implements Node\NodeInterface, Node\EnableableNodeInterface
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
        return 'CAL';
    }
    
    public function getNodeId()
    {
        return $this->getNodeType() . $this->getId();
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
	 * @ORM\Column(type="json_array")
	 */
	protected $holidayListIds = array();
	
	public function setHolidayListIds(array $value)
	{
		$this->holidayListIds = $value; return $this;
	}
	
	public function getHolidayListIds()
	{
		return $this->holidayListIds;
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