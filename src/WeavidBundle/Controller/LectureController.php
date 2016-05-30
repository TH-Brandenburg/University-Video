<?php

namespace WeavidBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\Lecture;
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

		$em = $this->getDoctrine()->getEntityManager();
		$qb = $em->createQueryBuilder();

		// Query for all of the users playlists
		$myLectures = $qb
						->select('l')
						->from('WeavidBundle:Lecture', 'l')
						->where('l.owner = :owner')
						->setParameter('owner', $this->get('security.token_storage')->getToken()->getUser())
						->getQuery()->getResult();

		// Query for all other playlists
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

			return $this->redirectToRoute( 'showLecture', ['id' => $lecture->getId()] );
		}

		return $this->render('lecture/add-lecture.html.twig', [
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/lectures/{id}", name="showLecture")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showLectureAction(Request $request, Lecture $lecture)
	{
		
		return $this->render('lecture/show-lecture.html.twig', [
			'lecture' => $lecture
		]);
		
	}

	/**
	 * @Route("/lectures/{id}/edit", name="editLecture")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function editAction(Request $request, Lecture $lecture)
	{

		$em = $this->getDoctrine()->getEntityManager();

		$form = $this->createForm( LectureVideoType::class, $lecture );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$video = $form->get('videos')->getData();
			$lecture->addVideo( $video );
			$em->persist( $lecture );
			$em->flush();
		}

		return $this->render('lecture/edit-lecture.html.twig', [
			'lecture' => $lecture,
			'form' => $form->createView()
		]);
	}

}
