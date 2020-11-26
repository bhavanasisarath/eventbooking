<?php
namespace App\Controller;

use App\Form\EventType;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class CreateEventController extends Controller
{
    /**
     * @Route("/create-event", name="create_event")
     */
    public function createEvent(Request $request)
    {
		$user = $this->getUser();
		if (!empty($user)) {
			$user_roles = $user->getRoles();
			if (!empty($user_roles) && in_array('ROLE_ADMIN', $user_roles)) {
				$admin_user = 1;
			}
		}
		
        if (isset($admin_user)) {
			$event = new Event();
			$form = $this->createForm(EventType::class, $event);

			// 2) handle the submit (will only happen on POST)
			$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid()) {
				
				 $entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($event);
				$entityManager->flush();

				// ... do any other work - like sending them an email, etc
				// maybe set a "flash" success message for the user
				return $this->redirectToRoute('event_list');
			}

			return $this->render(
				'event/createevent.html.twig',
				array('form' => $form->createView())
			);
		}
		else {
			throw new UnsupportedUserException(sprintf('Access denied'));
		}
        
    }
}