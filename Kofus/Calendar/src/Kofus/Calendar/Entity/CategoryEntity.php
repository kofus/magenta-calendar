<?php 
namespace Kofus\Calendar\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kofus\System\Node;
use Kofus\Calendar\Entity\CalendarEntity;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE") 
 * @ORM\Table(name="kofus_calendar_categories")
 *
 */
class CategoryEntity implements Node\NodeInterface, Node\SortableNodeInterface
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
        return 'CALCAT';
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
	 * @ORM\Column()
	 */
	protected $bgColor = '#808080';
	
	public function setBackgroundColor($value)
	{
	    $this->bgColor = $value; return $this;
	}
	
	public function getBackgroundColor()
	{
	    return $this->bgColor;
	}
	
	/**
	 * @ORM\Column()
	 */
	protected $color = '#ffffff';
	
	public function setColor($value)
	{
	    $this->color = $value; return $this;
	}
	
	public function getColor()
	{
	    return $this->color;
	}
	
	/**
	 * @ORM\Column(type="bigint", nullable=true)
	 */
	protected $priority;
	
	public function setPriority($value)
	{
	    $this->priority = (int) $value; return $this;
	}
	
	public function getPriority()
	{
	    return $this->priority;
	}
	
	public function __toString()
	{
	    return $this->getTitle();
	}
	
	
	
	
	
	
}