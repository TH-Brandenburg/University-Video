<?php

namespace WeavidBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\Playlist;
use WeavidBundle\Form\PlaylistType;
use WeavidBundle\Form\PlaylistVideoType;

class PlaylistController extends Controller
{
	/**
	 * @Route("/playlist/new", name="newPlaylist")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function createAction(Request $request)
	{

		$playlist = new Playlist();
		$form = $this->createForm( PlaylistType::class, $playlist );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$playlist->setOwner($this->get( 'security.token_storage' )->getToken()->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist( $playlist );
			$em->flush();

			return $this->redirectToRoute( 'editPlaylist', ['id' => $playlist->getId()] );
		}

		return $this->render('playlist/add-playlist.html.twig', [
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/playlist/{id}/edit", name="editPlaylist")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function editAction(Request $request, Playlist $playlist)
	{

		$em = $this->getDoctrine()->getEntityManager();

		/*$qb = $em->createQueryBuilder();
		$qb->select('v')
			->from('WeavidBundle:Video', 'v')
			->where('v.released = 1')
			->orWhere('v.owner = :owner')
			->setParameter('owner', $this->get( 'security.token_storage' )->getToken()->getUser());
		$videos = $qb->getQuery()->getResult();*/

		$form = $this->createForm( PlaylistVideoType::class, $playlist );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$video = $form->get('videos')->getData();
			$playlist->addVideo( $video );
			$em->persist( $playlist );
			$em->flush();
		}


		return $this->render('playlist/edit-playlist.html.twig', [
			'playlist' => $playlist,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/playlist/{id}/add", name="addToPlaylist")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function addToPlaylistAction(Request $request, Playlist $playlist){

	}
}
