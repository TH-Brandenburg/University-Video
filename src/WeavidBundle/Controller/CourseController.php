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
	public function editAction(Request $request, \WeavidBundle\Entity\Course $course)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();

		// Create form to edit course details
		$courseDetailForm = $this->createForm( CourseType::class, $course );
		$courseDetailForm->handleRequest($request);

		if($courseDetailForm->isSubmitted() && $courseDetailForm->isValid()){
			$em->persist( $course );
			$em->flush();
			$this->addFlash( 'success', 'Änderungen übernommen.' );
			return $this->redirectToRoute( 'editCourse', ['id'=>$course->getId()] );
		}

		// Create form to add lectures to course
		$addLectureForm = $this->createForm( CourseLectureType::class, $course );
		$addLectureForm->handleRequest($request);

		if($addLectureForm->isSubmitted() && $addLectureForm->isValid()){
			$lecture = $addLectureForm->get('lectures')->getData();
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
			$this->addFlash( 'success', 'Vorlesung hinzugefügt.' );
			return $this->redirectToRoute( 'editCourse', ['id'=>$course->getId()] );
		}

		$orderedCourseLectures = $em->getRepository( 'WeavidBundle:CourseLecture' )
			->findByCourseOrderedBySequence( $course );

		return $this->render('course/edit-course.html.twig', [
			'addLectureForm' => $addLectureForm->createView(),
			'courseDetailForm' => $courseDetailForm->createView(),
			'orderedCourseLectures' => $orderedCourseLectures,
			'course' => $course
		]);

	}

	/**
	 * @Route("/courselecture/{id}/moveup", name="moveUpCourseLecture")
	 * @Security("has_role('ROLE_LECTURER') and courseLecture.getCourse().isOwner(user)")
	 */
	public function moveUpAction(Request $request, CourseLecture $courseLecture)
	{

		// Check if video is already on first position
		if($courseLecture->hasPreviousLecture()){

			$oldPreviousCourseLecture = $courseLecture->getPreviousLecture();
			$newPreviousCourseLecture = $oldPreviousCourseLecture->getPreviousLecture();
			$oldNextCourseLecture = $courseLecture->getNextLecture();

			/** @var EntityManager $em */
			$em = $this->getDoctrine()->getManager();
			$em->getConnection()->beginTransaction();

			// Unset previous lecture videos to avoid integrity constraint violations
			$oldPreviousCourseLecture->setPreviousLecture(null);
			$courseLecture->setPreviousLecture(null);
			$em->persist( $oldPreviousCourseLecture );
			$em->persist( $courseLecture );
			if($oldNextCourseLecture !== null){
				$oldNextCourseLecture->setPreviousLecture(null);
				$em->persist( $oldNextCourseLecture );
			}
			$em->flush();

			// Set new previous lecture videos
			$oldPreviousCourseLecture->setPreviousLecture($courseLecture);
			$courseLecture->setPreviousLecture($newPreviousCourseLecture);
			$em->persist( $oldPreviousCourseLecture );
			$em->persist( $courseLecture );
			if($oldNextCourseLecture !== null){
				$oldNextCourseLecture->setPreviousLecture($oldPreviousCourseLecture);
				$em->persist( $oldNextCourseLecture );
			}
			$em->flush();

			// Commit changes
			$em->commit();

			$this->addFlash( 'success', 'Vorlesung erfolgreich verschoben.');
		} else {
			$this->addFlash( 'error', 'Vorlesung bereits an erster Stelle.' );
		}

		return $this->redirectToRoute( 'editCourse', [ 'id' => $courseLecture->getCourse()->getId() ] );

	}

	/**
	 * @Route("/courselecture/{id}/movedown", name="moveDownCourseLecture")
	 * @Security("has_role('ROLE_LECTURER') and courseLecture.getCourse().isOwner(user)")
	 */
	public function moveDownAction(Request $request, CourseLecture $courseLecture)
	{

		// Check if video is already on first position
		if($courseLecture->hasNextLecture()){

			$nextCourseLecture = $courseLecture->getNextLecture();

			$oldPreviousCourseLecture = $nextCourseLecture->getPreviousLecture();
			$newPreviousCourseLecture = $oldPreviousCourseLecture->getPreviousLecture();
			$oldNextCourseLecture = $nextCourseLecture->getNextLecture();

			/** @var EntityManager $em */
			$em = $this->getDoctrine()->getManager();
			$em->getConnection()->beginTransaction();

			// Unset previous lecture videos to avoid integrity constraint violations
			$oldPreviousCourseLecture->setPreviousLecture(null);
			$nextCourseLecture->setPreviousLecture(null);
			$em->persist( $oldPreviousCourseLecture );
			$em->persist( $nextCourseLecture );
			if($oldNextCourseLecture !== null){
				$oldNextCourseLecture->setPreviousLecture(null);
				$em->persist( $oldNextCourseLecture );
			}
			$em->flush();

			// Set new previous lecture videos
			$oldPreviousCourseLecture->setPreviousLecture($nextCourseLecture);
			$nextCourseLecture->setPreviousLecture($newPreviousCourseLecture);
			$em->persist( $oldPreviousCourseLecture );
			$em->persist( $nextCourseLecture );
			if($oldNextCourseLecture !== null){
				$oldNextCourseLecture->setPreviousLecture($oldPreviousCourseLecture);
				$em->persist( $oldNextCourseLecture );
			}
			$em->flush();

			// Commit changes
			$em->commit();

			$this->addFlash( 'success', 'Vorlesung erfolgreich verschoben.');
		} else {
			$this->addFlash( 'error', 'Vorlesung bereits an letzter Stelle.' );
		}

		return $this->redirectToRoute( 'editCourse', [ 'id' => $courseLecture->getCourse()->getId() ] );

	}

	/**
	 * @Route("/courselecture/{id}/remove", name="removeCourseLecture")
	 * @Security("has_role('ROLE_LECTURER') and courseLecture.getCourse().isOwner(user)")
	 */
	public function removeCourseLectureAction(Request $request, CourseLecture $courseLecture)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->beginTransaction();
		$course = $courseLecture->getCourse();

		if($courseLecture->hasNextLecture()){
			$nextCourseLecture = $courseLecture->getNextLecture();
			$previousCourseLecture = $courseLecture->getPreviousLecture();
			$courseLecture->setPreviousLecture(null);
			$em->persist( $courseLecture );
			$em->flush();
			$nextCourseLecture->setPreviousLecture($previousCourseLecture);
			$em->persist( $nextCourseLecture );
		}

		$em->remove( $courseLecture );
		$em->flush();

		$em->commit();
		$this->addFlash( 'success', 'Vorlesung aus Kurs entfernt.' );

		return $this->redirectToRoute( 'editCourse', ['id' => $course->getId()] );

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
