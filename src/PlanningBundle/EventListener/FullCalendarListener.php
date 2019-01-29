<?php

namespace PlanningBundle\EventListener;


use PlanningBundle\Entity\Ateliers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity

        //$ateliers = $this->em->getRepository(Ateliers::class)->findAll();

        $ateliers = $this->em->getRepository(Ateliers::class)
            ->createQueryBuilder('b')
            ->andWhere('b.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();

        foreach($ateliers as $atelier) {

            // this create the events with your own entity (here booking entity) to populate calendar
            $atelierEvent = new Event(
                $atelier->getTitle(),
                $atelier->getBeginAt(),
                $atelier->getEndAt() // If the end date is null or not defined, it creates a all day event
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $bookingEvent->setUrl('http://www.google.com');
            // $bookingEvent->setBackgroundColor($booking->getColor());
            // $bookingEvent->setCustomField('borderColor', $booking->getColor());

            $atelierEvent->setUrl(
                $this->router->generate('atelier_show', array(
                    'id' => $atelier->getId(),
                ))
            );

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($atelierEvent);
        }
    }
}