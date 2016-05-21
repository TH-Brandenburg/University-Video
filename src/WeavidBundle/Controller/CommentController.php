<?php

namespace WeavidBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WeavidBundle\Entity\Comment;
use WeavidBundle\Entity\Video;
use WeavidBundle\Form\CommentType;

class CommentController extends Controller
{
	/**
	 * @Route("/videos/{id}/comments/new", name="newComment")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function createAction(Request $request, Video $video)
	{

		$comment = new Comment();
		$postform = $this->createForm( CommentType::class, $comment );
		$postform->handleRequest($request);

		if($postform->isSubmitted() && $postform->isValid()){
			$comment->setVideo($video);
			$comment->setCreator($this->get('security.token_storage')->getToken()->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist( $comment );
			$em->flush();

			return (new Response())->setStatusCode( 200 );
		}

		return (new Response())->setStatusCode( 400 );

	}
}
