<?php

namespace AppBundle\Repository;

/**
 * ReservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getReservationsDone($start_date,$end_date)
    {
        $qb1=$this->createQueryBuilder('p');
        $qb1->select('p')
            ->where('p.startDate BETWEEN :d1 AND :d2' )
            ->orWhere('p.endDate BETWEEN :d1 AND :d2' )
            ->setParameter('d1', $start_date)
            ->setParameter('d2', $end_date);


        return $qb1->getQuery();
    }
}