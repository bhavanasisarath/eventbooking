<?php
namespace App\Controller;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends Controller
{
    /**
     * @Route("/event/{id}", name="event_show")
     */
    public function viewEvent(int $id): Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
		
		
        if (!$event) {
            throw $this->createNotFoundException(
                'No Event found for id '.$id
            );
        }
		
		$actual_seats = $event->getSeats();
		
		$attendees_list = $event->getAttendees();
		if (empty($attendees_list)) {
			$attendees_list = [];
		}
			
		$booked_seats = count($attendees_list);
		
		$available_seats = $actual_seats - $booked_seats;
		
		$user = $this->getUser();
		if (!empty($user)) {
			$user_id = $user->getId();
			if (in_array($user_id, $attendees_list)) {
				$booked = 1;
			}
		}
		
        return $this->render('event/event-view.html.twig', ['event' => $event, 'available_seats' => $available_seats, 'booked' => isset($booked) ? $booked : 0]);
    }
}
