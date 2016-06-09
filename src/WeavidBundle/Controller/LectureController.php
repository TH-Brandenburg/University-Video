<?php

namespace WeavidBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\Lecture;
use WeavidBundle\Entity\LectureVideo;
use WeavidBundle\Form\LectureType;
use WeavidBundle\Form\LectureVideoType;

class LectureController extends Controller
{

	/**
	 * @Route("/lectures", name="indexLecture")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function indexAction(Request $request)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		// Query for all of the users lectures
		$myLectures = $qb
						->select('l')
						->from('WeavidBundle:Lecture', 'l')
						->where('l.owner = :owner')
						->setParameter('owner', $this->get('security.token_storage')->getToken()->getUser())
						->getQuery()->getResult();

		// Query for all other lectures
		$otherLectures = $qb
						->where('l.owner != :owner')
						->andWhere('l.published = 1')
						->getQuery()->getResult();

		// Return template with lectures
		return $this->render('lecture/lecture-index.html.twig', [
			'myLectures' => $myLectures,
			'otherLectures' => $otherLectures
		]);

	}


	/**
	 * @Route("/lectures/new", name="newLecture")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function createAction(Request $request)
	{

		$lecture = new Lecture();
		$form = $this->createForm( LectureType::class, $lecture );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$lecture->setOwner($this->get( 'security.token_storage' )->getToken()->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist( $lecture );
			$em->flush();

			$this->addFlash( 'success', 'Video hinzugefügt.' );
			return $this->redirectToRoute( 'showLecture', ['id' => $lecture->getId()] );
		}

		return $this->render('lecture/add-lecture.html.twig', [
			'form' => $form->createView()
		]);
	}


	/**
	 * @Route("/lectures/{id}/edit", name="editLecture")
	 * @Security("has_role('ROLE_USER') and lecture.isOwner(user)")
	 */
	public function updateAction(Request $request, Lecture $lecture)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();

		// Create form to edit lecture details
		$lectureDetailForm = $this->createForm( LectureType::class, $lecture );
		$lectureDetailForm->handleRequest($request);

		if($lectureDetailForm->isSubmitted() && $lectureDetailForm->isValid()){
			$em->persist( $lecture );
			$em->flush();
			$this->addFlash( 'success', 'Änderungen übernommen.' );
			return $this->redirectToRoute( 'editLecture', ['id'=>$lecture->getId()] );
		}

		// Create form to add videos to lecture
		$addVideoForm = $this->createForm( LectureVideoType::class, $lecture );
		$addVideoForm->handleRequest($request);

		if($addVideoForm->isSubmitted() && $addVideoForm->isValid()){
			$video = $addVideoForm->get('videos')->getData();

			$qb = $em->createQueryBuilder();

			// Select last element in playlist
			$previousLectureVideo = $qb->select('lv')
			                           ->from('WeavidBundle:LectureVideo', 'lv')
			                           ->where( 'lv.lecture = :lecture' )
			                           ->leftJoin( 'lv.nextLectureVideo', 'lv2')
			                           ->andWhere('lv2.id is NULL')
			                           ->setParameter( 'lecture', $lecture )
			                           ->setMaxResults( 1 )
			                           ->getQuery()->getOneOrNullResult();

			// New lecture video object
			$lectureVideo = new LectureVideo();
			$lectureVideo->setLecture($lecture);
			$lectureVideo->setVideo($video);
			$lectureVideo->setPreviousLectureVideo($previousLectureVideo);

			// Persist lecture video
			$em->persist( $lectureVideo );
			$em->flush();

			$this->addFlash( 'success', 'Video hinzugefügt.' );
			return $this->redirectToRoute( 'editLecture', ['id'=>$lecture->getId()] );
		}

		$orderedLectureVideos = $this->getDoctrine()->getRepository( 'WeavidBundle:LectureVideo' )
		                             ->findByLectureOrderedBySequence($lecture);

		return $this->render('lecture/edit-lecture.html.twig', [
			'lecture' => $lecture,
			'orderedLectureVideos' => $orderedLectureVideos,
			'addVideoForm' => $addVideoForm->createView(),
			'lectureDetailForm' => $lectureDetailForm->createView()
		]);
	}

	/**
	 * @Route("/lecturevideo/{id}/moveup", name="moveUpLectureVideo")
	 * @Security("has_role('ROLE_LECTURER') and lectureVideo.getLecture().isOwner(user)")
	 */
	public function moveUpAction(Request $request, LectureVideo $lectureVideo)
	{

		// Check if video is already on first position
		if($lectureVideo->hasPreviousLectureVideo()){

			$oldPreviousLectureVideo = $lectureVideo->getPreviousLectureVideo();
			$newPreviousLectureVideo = $oldPreviousLectureVideo->getPreviousLectureVideo();
			$oldNextLectureVideo = $lectureVideo->getNextLectureVideo();

			/** @var EntityManager $em */
			$em = $this->getDoctrine()->getManager();
			$em->getConnection()->beginTransaction();

			// Unset previous lecture videos to avoid integrity constraint violations
			$oldPreviousLectureVideo->setPreviousLectureVideo(null);
			$lectureVideo->setPreviousLectureVideo(null);
			$em->persist( $oldPreviousLectureVideo );
			$em->persist( $lectureVideo );
			if($oldNextLectureVideo !== null){
				$oldNextLectureVideo->setPreviousLectureVideo(null);
				$em->persist( $oldNextLectureVideo );
			}
			$em->flush();

			// Set new previous lecture videos
			$oldPreviousLectureVideo->setPreviousLectureVideo($lectureVideo);
			$lectureVideo->setPreviousLectureVideo($newPreviousLectureVideo);
			$em->persist( $oldPreviousLectureVideo );
			$em->persist( $lectureVideo );
			if($oldNextLectureVideo !== null){
				$oldNextLectureVideo->setPreviousLectureVideo($oldPreviousLectureVideo);
				$em->persist( $oldNextLectureVideo );
			}
			$em->flush();

			// Commit changes
			$em->commit();

			$this->addFlash( 'success', 'Video erfolgreich verschoben.');
		} else {
			$this->addFlash( 'error', 'Video bereits an erster Stelle.' );
		}

		return $this->redirectToRoute( 'editLecture', [ 'id' => $lectureVideo->getLecture()->getId() ] );
		
	}

	/**
	 * @Route("/lecturevideo/{id}/movedown", name="moveDownLectureVideo")
	 * @Security("has_role('ROLE_LECTURER') and lectureVideo.getLecture().isOwner(user)")
	 */
	public function moveDownAction(Request $request, LectureVideo $lectureVideo)
	{

		// Check if video is already on first position
		if($lectureVideo->hasNextLectureVideo()){

			$nextLectureVideo = $lectureVideo->getNextLectureVideo();

			$oldPreviousLectureVideo = $nextLectureVideo->getPreviousLectureVideo();
			$newPreviousLectureVideo = $oldPreviousLectureVideo->getPreviousLectureVideo();
			$oldNextLectureVideo = $nextLectureVideo->getNextLectureVideo();

			/** @var EntityManager $em */
			$em = $this->getDoctrine()->getManager();
			$em->getConnection()->beginTransaction();

			// Unset previous lecture videos to avoid integrity constraint violations
			$oldPreviousLectureVideo->setPreviousLectureVideo(null);
			$nextLectureVideo->setPreviousLectureVideo(null);
			$em->persist( $oldPreviousLectureVideo );
			$em->persist( $nextLectureVideo );
			if($oldNextLectureVideo !== null){
				$oldNextLectureVideo->setPreviousLectureVideo(null);
				$em->persist( $oldNextLectureVideo );
			}
			$em->flush();

			// Set new previous lecture videos
			$oldPreviousLectureVideo->setPreviousLectureVideo($nextLectureVideo);
			$nextLectureVideo->setPreviousLectureVideo($newPreviousLectureVideo);
			$em->persist( $oldPreviousLectureVideo );
			$em->persist( $nextLectureVideo );
			if($oldNextLectureVideo !== null){
				$oldNextLectureVideo->setPreviousLectureVideo($oldPreviousLectureVideo);
				$em->persist( $oldNextLectureVideo );
			}
			$em->flush();

			// Commit changes
			$em->commit();

			$this->addFlash( 'success', 'Video erfolgreich verschoben.');
		} else {
			$this->addFlash( 'error', 'Video bereits an letzter Stelle.' );
		}

		return $this->redirectToRoute( 'editLecture', [ 'id' => $lectureVideo->getLecture()->getId() ] );

	}

	/**
	 * @Route("/lecturevideo/{id}/remove", name="removeLectureVideo")
	 * @Security("has_role('ROLE_LECTURER') and lectureVideo.getLecture().isOwner(user)")
	 */
	public function removeLectureVideoAction(Request $request, LectureVideo $lectureVideo)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->beginTransaction();
		$lecture = $lectureVideo->getLecture();

		if($lectureVideo->hasNextLectureVideo()){
			$nextLectureVideo = $lectureVideo->getNextLectureVideo();
			$previousLectureVideo = $lectureVideo->getPreviousLectureVideo();
			$lectureVideo->setPreviousLectureVideo(null);
			$em->persist( $lectureVideo );
			$em->flush();
			$nextLectureVideo->setPreviousLectureVideo($previousLectureVideo);
			$em->persist( $nextLectureVideo );
		}

		$em->remove( $lectureVideo );
		$em->flush();

		$em->commit();
		$this->addFlash( 'success', 'Video aus Vorlesung entfernt.' );

		return $this->redirectToRoute( 'editLecture', ['id' => $lecture->getId()] );

	}

	/**
	 * @Route("/lectures/{id}", name="showLecture")
	 * @Security("has_role('ROLE_USER') and lecture.isPublished() or lecture.isOwner(user)")
	 */
	public function showAction(Request $request, Lecture $lecture)
	{
		
		return $this->render('lecture/show-lecture.html.twig', [
			'lecture' => $lecture
		]);
		
	}

}
