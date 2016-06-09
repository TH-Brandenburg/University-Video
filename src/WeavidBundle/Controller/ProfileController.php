<?php

namespace WeavidBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Form\UserType;

class ProfileController extends Controller
{
	/**
	 * @Route("/profile", name="profile")
	 */
	public function indexAction(Request $request)
	{

		$user = $this->getUser();

		$form = $this->createForm( UserType::class, $user );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist( $user );
			$em->flush();
			$this->addFlash( 'success', 'Änderungen übernommen.' );
		}
		
		return $this->render('profile/profile.html.twig', [
			'form' => $form->createView()
		]);
	}
}
