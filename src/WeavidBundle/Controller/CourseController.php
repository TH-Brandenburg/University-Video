<?php

namespace WeavidBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Form\CourseLectureType;
use WeavidBundle\Form\CourseType;

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

	/**
	 * @Route("/courses/add", name="createCourse")
	 */
	public function createAction(Request $request)
	{

		$course = new \WeavidBundle\Entity\Course();
		$form = $this->createForm( CourseType::class, $course );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$course->setOwner($this->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist( $course );
			$em->flush();

			return $this->redirectToRoute( 'showCourse', ['id' => $course->getId()] );
		}
		
		return $this->render('course/add-course.html.twig', [
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/courses/{id}/edit", name="editCourse")
	 */
	public function editAction(Request $request, \WeavidBundle\Entity\Course $course)
	{

		$form = $this->createForm( CourseLectureType::class, $course );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$lecture = $form->get('lectures')->getData();
			$course->addLecture( $lecture );
			$em->persist( $lecture );
			$em->flush();
		}

		return $this->render('course/edit-course.html.twig', [
			'form' => $form->createView(),
			'course' => $course
		]);

	}

	/**
	 * @Route("/courses/{id}", name="showCourse")
	 */
	public function showAction(Request $request, \WeavidBundle\Entity\Course $course)
	{

		return $this->render('course/show-course.html.twig', [
			'course' => $course
		]);

	}

}
