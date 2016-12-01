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
        return 'CALENT';
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
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $year;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $month;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $day;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $hour;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $minute;
	
	public function setDate($year, $month, $day)
	{
	    $this->year = $year;
	    $this->month = $month;
	    $this->day = $day; 
	    return $this;
	}
	
	public function getDate()
	{
	    return array($this->year, $this->month, $this->day);
	}
	
	public function setTime($hour, $minute)
	{
	    $this->hour = $hour;
	    $this->minute = $minute;
	    return $this;
	}
	
	public function getTime($pretty=false)
	{
	    if ($pretty) {
	        if ($this->hour !== null && $this->minute !== null)
	            return str_pad($this->hour, 2, 0, STR_PAD_LEFT) . ':' . str_pad($this->minute, 2, 0, STR_PAD_LEFT);
	        return;
	    }
	    
	    return array($this->hour, $this->minute);
	}
	
	public function getDateTime()
	{
	    if ($this->year === null && $this->month === null && $this->day === null)
	        return;
	    
	    $dt = new \DateTime();	    
	    if ($this->year && $this->month && $this->day)
	        $dt->setDate($this->year, $this->month, $this->day);
	    if ($this->hour && $this->minute)
	        $dt->setTime($this->hour, $this->minute, 0);
	    return $dt;
	}
	
	public function setDateTime(\DateTime $dt)
	{
	    $this->year = $dt->format('Y');
	    $this->month = $dt->format('m');
	    $this->day = $dt->format('d');
	    $this->hour = $dt->format('H');
	    $this->minute = $dt->format('i');
	    return $this;
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