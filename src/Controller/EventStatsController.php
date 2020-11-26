<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use App\Entity\Event;

class EventStatsController extends AbstractController
{
    /**
     * @Route("/eventstats/{id}", name="stats")
     */
    public function indexAction(int $id)
    {	
		$event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
		
		$actual_seats = $event->getSeats();
		
		$attendees_list = $event->getAttendees();
		if (empty($attendees_list)) {
			$attendees_list = [];
		}
			
		$booked_seats = count($attendees_list);
		
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Categories', 'Pie expense'],
                ['Total Seats',  $actual_seats],
                ['Booked Seats',  $booked_seats]
                
            ]
        );
        $pieChart->getOptions()->setTitle($event->getName() . ' Statistics');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('event/stat.html.twig', array('piechart' => $pieChart));
    }
}