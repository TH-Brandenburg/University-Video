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
	 * @Route("/playlists", name="indexPlaylist")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function indexAction(Request $request)
	{

		$em = $this->getDoctrine()->getEntityManager();
		$qb = $em->createQueryBuilder();

		// Query for all of the users playlists
		$myPlaylists = $qb
						->select('p')
						->from('WeavidBundle:Playlist', 'p')
						->where('p.owner = :owner')
						->setParameter('owner', $this->get('security.token_storage')->getToken()->getUser())
						->getQuery()->getResult();

		// Query for all other playlists
		$otherPlaylists = $qb
						->where('p.owner != :owner')
						->andWhere('p.private = 0')
						->getQuery()->getResult();

		// Return template with playlists
		return $this->render('playlist/playlist-index.html.twig', [
			'myPlaylists' => $myPlaylists,
			'otherPlaylists' => $otherPlaylists
		]);

	}


	/**
	 * @Route("/playlists/new", name="newPlaylist")
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
	 * @Route("/playlists/{id}", name="showPlaylist")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPlaylistAction(Request $request, Playlist $playlist)
	{
		
		return $this->render('playlist/show-playlist.html.twig', [
			'playlist' => $playlist
		]);
		
	}

	/**
	 * @Route("/playlists/{id}/edit", name="editPlaylist")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function editAction(Request $request, Playlist $playlist)
	{

		$em = $this->getDoctrine()->getEntityManager();

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

}
