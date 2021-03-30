<?php

namespace App\Controller\Reservation;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/showw", name="main", methods={"GET"})
     */
    public function index(CalendarRepository $calendar)
    {
        $events = $calendar->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'allDay' => $event->getAllDay(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('Reservation/main/index.html.twig', compact('data'));
    }
    /**
     * @Route("/showw/{id}", name="mainn", methods={"GET"})
     */
    public function ind(CalendarRepository $calendar,$id)
    {
        $events = $calendar->findBy(array('field'=>$id));

        $rdvs = [];
        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'allDay' => $event->getAllDay(),
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('Reservation/main/index.html.twig', compact('data'));
    }
    /**
     * @Route("/showadmin", name="adminmain")
     */
    public function inde(CalendarRepository $calendar)
    {
        $events = $calendar->findAll();
        $rdvs = [];
        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'allDay' => $event->getAllDay(),
                'field'=>$event->getField()
            ];
        }

        $data = json_encode($rdvs);
        return $this->render('Reservation/main/admin.html.twig', compact('data'));
    }
}