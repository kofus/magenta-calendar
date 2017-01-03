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
	
	public function getTitle($maxLength=null)
	{
	    if ($maxLength && $maxLength < strlen($this->title)) {
	        $title = substr($this->title, 0, $maxLength);
	        $title .= '...';
	        return $title;
	    }
		return $this->title;
	}
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $year1;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $month1;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $day1;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $hour1;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $minute1;
	
	public function setDate1($year, $month, $day)
	{
	    $this->year1 = $year;
	    $this->month1 = $month;
	    $this->day1 = $day; 
	    return $this;
	}
	
	public function getDate1()
	{
	    return array($this->year1, $this->month1, $this->day1);
	}
	
	public function setTime1($hour, $minute)
	{
	    $this->hour1 = $hour;
	    $this->minute1 = $minute;
	    return $this;
	}
	
	public function getTime1($pretty=false)
	{
	    if ($pretty) {
	        if ($this->hour1 !== null && $this->minute1 !== null)
	            return str_pad($this->hour1, 2, 0, STR_PAD_LEFT) . ':' . str_pad($this->minute1, 2, 0, STR_PAD_LEFT);
	        return;
	    }
	    
	    return array($this->hour1, $this->minute1);
	}
	
	public function getDateTime1()
	{
	    if ($this->year1 === null && $this->month1 === null && $this->day1 === null)
	        return;
	    
	    $dt = new \DateTime();	    
	    if ($this->year1 && $this->month1 && $this->day1)
	        $dt->setDate($this->year1, $this->month1, $this->day1);
	    if ($this->hour1 && $this->minute1)
	        $dt->setTime($this->hour1, $this->minute1, 0);
	    return $dt;
	}
	
	public function setDateTime1(\DateTime $dt)
	{
	    $this->year1 = $dt->format('Y');
	    $this->month1 = $dt->format('m');
	    $this->day1 = $dt->format('d');
	    $this->hour1 = $dt->format('H');
	    $this->minute1 = $dt->format('i');
	    return $this;
	}
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $year2;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $month2;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $day2;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $hour2;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $minute2;
	
	public function setDate2($year, $month, $day)
	{
		$this->year2 = $year;
		$this->month2 = $month;
		$this->day2 = $day;
		return $this;
	}
	
	public function getDate2()
	{
		return array($this->year2, $this->month2, $this->day2);
	}
	
	public function setTime2($hour, $minute)
	{
		$this->hour2 = $hour;
		$this->minute2 = $minute;
		return $this;
	}
	
	public function getTime2($pretty=false)
	{
		if ($pretty) {
			if ($this->hour2 !== null && $this->minute2 !== null)
				return str_pad($this->hour2, 2, 0, STR_PAD_LEFT) . ':' . str_pad($this->minute2, 2, 0, STR_PAD_LEFT);
			return;
		}
		 
		return array($this->hour2, $this->minute2);
	}
	
	public function getDateTime2()
	{
		if ($this->year2 === null && $this->month2 === null && $this->day2=== null)
			return;
		 
		$dt = new \DateTime();
		if ($this->year2 && $this->month2 && $this->day2)
			$dt->setDate($this->year2, $this->month2, $this->day2);
		if ($this->hour2 && $this->minute2)
			$dt->setTime($this->hour2, $this->minute2, 0);
		return $dt;
	}
	
	public function setDateTime2(\DateTime $dt)
	{
		$this->year2 = $dt->format('Y');
		$this->month2 = $dt->format('m');
		$this->day2 = $dt->format('d');
		$this->hour2 = $dt->format('H');
		$this->minute2 = $dt->format('i');
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
	
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $content;
	
	public function setContent($value)
	{
	    $this->content = $value; return $this;
	}
	
	public function getContent()
	{
	    return $this->content; 
	}
	
	
	
	
	
}