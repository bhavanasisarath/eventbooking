<?php
namespace App\Controller;

use App\Form\EventType;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EventsListController extends Controller
{
    /**
     * @Route("/events-list", name="event_list")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Event::class);
		$events = $repository->findAll();
		
		$user = $this->getUser();
		if (!empty($user)) {
			$user_roles = $user->getRoles();
			if (!empty($user_roles) && in_array('ROLE_ADMIN', $user_roles)) {
				$admin_user = 1;
			}
		}
		
        return $this->render(
            'event/listevent.html.twig', ['events' => $events, 'admin_user' => isset($admin_user) ? 1 : 0]
        );
    }
}