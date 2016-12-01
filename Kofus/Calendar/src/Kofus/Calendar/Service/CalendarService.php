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
        
        $qb = $this->nodes()->createQueryBuilder('CALENT');
        $entries = $qb->where('n.year IS NULL OR n.year = :year')
            ->setParameter('year', $year)
            ->andWhere('n.month IS NULL OR n.month = :month')
            ->setParameter('month', $month)
            ->getQuery()->getResult();
        $container->setEntries($entries);
        
        return $container;
    }

}