<?php
namespace Kofus\Calendar\Service;
use Kofus\System\Service\AbstractService;
use Kofus\Calendar\Entity\CalendarEntity;
use Kofus\Calendar\Container\Month;
use Kofus\Calendar\Container\Preview;

class CalendarService extends AbstractService
{
    public function getMonth(CalendarEntity $calendar, $year, $month)
    {
        $container = new Month($year . '-' . $month);
        $container->setCalendar($calendar);
        
        $lists = $this->config()->get('calendar.holidays.available');
        foreach ($calendar->getHolidayListIds() as $listId) {
            if (isset($lists[$listId]))
                $container->addHolidayList($listId, $lists[$listId]);
        }
        
        $qb = $this->nodes()->createQueryBuilder('CALENT');
        $entries = $qb->where('n.year1 IS NULL OR n.year1 = :year')
            ->setParameter('year', $year)
            ->andWhere('n.month1 IS NULL OR n.month1 = :month')
            ->setParameter('month', $month)
            ->andWhere('n.calendar = :calendar')
            ->setParameter('calendar', $calendar)
            ->getQuery()->getResult();
        $container->setEntries($entries);
        
        return $container;
    }
    
    public function getPreview(CalendarEntity $calendar, $date=null)
    {
        if (! $date) $date = date('Y-m-d');
    	$container = new Preview($date);
    	$container->setCalendar($calendar);
    
    	$lists = $this->config()->get('calendar.holidays.available');
    	foreach ($calendar->getHolidayListIds() as $listId) {
    		if (isset($lists[$listId]))
    			$container->addHolidayList($listId, $lists[$listId]);
    	}
    	
    	$config = $this->em()->getConfiguration();
    	$config->addCustomStringFunction('LPAD', 'DoctrineExtensions\Query\Mysql\Lpad');    	
    	
        $start = $container->getDateTimeStart();
        $end = $container->getDateTimeEnd();
        
    	$qb = $this->nodes()->createQueryBuilder('CALENT');
    	$entriesA = $qb->where('n.calendar = :calendar')
            ->setParameter('calendar', $calendar)
            ->andWhere("CONCAT(n.year1, '-', LPAD(n.month1, 2, '0'), '-', LPAD(n.day1, 2, '0')) >= :start")
            ->andWhere("CONCAT(n.year1, '-', LPAD(n.month1, 2, '0'), '-', LPAD(n.day1, 2, '0')) <= :end")
            ->setParameter('start', $start->format('Y-m-d'))
            ->setParameter('end', $end->format('Y-m-d'))
        	->getQuery()->getResult();
    	
    	$qb = $this->nodes()->createQueryBuilder('CALENTB');
    	$entriesB = $qb->where('n.calendar = :calendar')
            ->setParameter('calendar', $calendar)
    	    ->andWhere(":month1 <= n.month1 AND n.month1 <= :month2")
        	->setParameter('month1', (int) $start->format('m'))
        	->setParameter('month2', (int) $end->format('m'))
        	->andWhere(':day1 <= n.day1 AND n.day1 <= :day2')
        	->setParameter('day1', (int) $start->format('d'))
        	->setParameter('day2', (int) $end->format('d'))
        	->getQuery()->getResult();

    	$entries = array_merge($entriesA, $entriesB);
    	$container->setEntries($entries);
    
    	return $container;
    }
    
    public function getUpcomingEntries(CalendarEntity $calendar=null, $limit=5)
    {
        $today = new \DateTime();
        $dates = $this->nodes()->createQueryBuilder('CALENT')
            ->where('n.enabled = true')
            ->andWhere("CONCAT(n.year1, '-', n.month1, '-', n.day1) >= :date")
            ->setParameter('date', $today->format('Y-m-d'))
            ->setMaxResults($limit)
            ->orderBy("CONCAT(n.year1, '-', n.month1, '-', n.day1)", 'ASC')
            ->getQuery()->getResult();
        return $dates;
 
    }

}