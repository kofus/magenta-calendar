<?php
namespace Kofus\Calendar\Service;
use Kofus\System\Service\AbstractService;
use Kofus\Calendar\Entity\CalendarEntity;
use Kofus\Calendar\Container\Month;

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