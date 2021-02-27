<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventAdminController extends AbstractController
{
    /**
     * @Route("/eventadmin", name="event_admin")
     */
    public function index(): Response
    {

        $events=['Event1','Event2'];

        return $this->render('event_admin/eventadmin.html.twig',array('events' => $events));
    }
}
