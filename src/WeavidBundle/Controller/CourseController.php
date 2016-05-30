<?php

namespace WeavidBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends Controller
{
	/**
	 * @Route("/courses", name="courseIndex")
	 */
	public function indexAction(Request $request)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();

		$courses = $em->getRepository( "WeavidBundle:Course" )->findBy([
			'published' => true
		]);

		return $this->render('course/course-index.html.twig', [
			'courses' => $courses
		]);
	}
}
