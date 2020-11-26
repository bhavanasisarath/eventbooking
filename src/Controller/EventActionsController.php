<?php
namespace App\Controller;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EventActionsController extends Controller
{
    /**
     * @Route("/event/{id}/yes", name="event_action_yes")
     */
    public function acceptEvent(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Event::class);
		
		$attendees = $repository->findAttendees($id);
		$attendees = $attendees['attendees'];
		
		if (empty($attendees)) {
			$attendees = [];
		}
		
		$user = $this->getUser();
		if (!empty($user)) {
			$user_id = $user->getId();
		}

		$new_attendees_list = [];
		$new_attendees_list = array_merge($attendees, [$user_id]);
		
		$event = $repository->find($id);
		$event->setAttendees($new_attendees_list);
		
		$em = $this
                ->getDoctrine()
                ->getManager();
				
		$em->persist($event);
        $em->flush();

        if (!$event) {
            throw $this->createNotFoundException(
                'No Event found for id '.$id
            );
        }

		return new Response("
            <html>
                <body>
                    <h1>Successfully Booked the Event " . $event->getName() . "</h1>
                </body>
            </html>
        ");

    }
}
