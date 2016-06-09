<?php

namespace WeavidBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\CourseLecture;
use WeavidBundle\Form\CourseLectureType;
use WeavidBundle\Form\CourseType;

class CourseController extends Controller
{
	/**
	 * @Route("/courses", name="courseIndex")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function indexAction(Request $request)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();

		$qb = $em->createQueryBuilder();

		// Query for all of the users courses
		$myCourses = $qb
			->select('c')
			->from('WeavidBundle:Course', 'c')
			->where('c.owner = :owner')
			->setParameter('owner', $this->getUser())
			->getQuery()->getResult();

		// Query for all other courses
		$otherCourses = $qb
			->where('c.owner != :owner')
			->andWhere('c.published = 1')
			->getQuery()->getResult();

		return $this->render('course/course-index.html.twig', [
			'myCourses' => $myCourses,
			'otherCourses' => $otherCourses
		]);
	}

	/**
	 * @Route("/courses/add", name="createCourse")
	 * @Security("has_role('ROLE_LECTURER')")
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
	 * @Security("course.isOwner(user)")
	 */
	public function updateAction(Request $request, \WeavidBundle\Entity\Course $course)
	{

		$form = $this->createForm( CourseLectureType::class, $course );
		$form->handleRequest($request);

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();

		if($form->isSubmitted() && $form->isValid()){
			$lecture = $form->get('lectures')->getData();
			$qb = $em->createQueryBuilder();

			// Select last element in playlist
			$previousCourseLecture = $qb->select('cl')
			                           ->from('WeavidBundle:CourseLecture', 'cl')
			                           ->where( 'cl.course = :course' )
			                           ->leftJoin( 'cl.nextLecture', 'cl2')
			                           ->andWhere('cl2.id is NULL')
			                           ->setParameter( 'course', $course )
			                           ->setMaxResults( 1 )
			                           ->getQuery()->getOneOrNullResult();

			// New lecture video object
			$courseLecture = new CourseLecture();
			$courseLecture->setCourse($course);
			$courseLecture->setLecture($lecture);
			$courseLecture->setPreviousLecture( $previousCourseLecture );

			// Persist course lecture
			$em->persist( $courseLecture );
			$em->flush();
		}

		$orderedCourseLectures = $em->getRepository( 'WeavidBundle:CourseLecture' )
			->findByCourseOrderedBySequence( $course );

		return $this->render('course/edit-course.html.twig', [
			'form' => $form->createView(),
			'orderedCourseLectures' => $orderedCourseLectures,
			'course' => $course
		]);

	}

	/**
	 * @Route("/courses/{id}", name="showCourse")
	 * @Security("has_role('ROLE_USER') and course.isPublished() or course.isOwner(user)")
	 */
	public function showAction(Request $request, \WeavidBundle\Entity\Course $course)
	{

		return $this->render('course/show-course.html.twig', [
			'course' => $course
		]);

	}

}
