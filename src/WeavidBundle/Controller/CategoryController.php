<?php

namespace WeavidBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\Category;
use WeavidBundle\Form\CategoryType;
use WeavidBundle\Utils\CategoryVideos;

class CategoryController extends Controller
{
	/**
	 * @Route("/categories", name="categoryIndex")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function indexAction(Request $request)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();
		
		// Get root categories
		$rootCategories = $qb->select('rc')
								->from( 'WeavidBundle:Category', 'rc' )
								->where( 'rc.parent is NULL' )
								->getQuery()
								->getResult();

		// Create new instance of category
		$category = new Category();
		// Create category form and handle possible request
		$form = $this->createForm( CategoryType::class, $category );
		$form->handleRequest($request);

		// If the form was successfully submitted, is valid and the user is granted admin, persist category
		if($form->isSubmitted() && $form->isValid() && $this->isGranted( 'ROLE_ADMIN' )){
			$em->persist( $category );
			$em->flush();
			// add flash message if successful
			$this->addFlash( 'success', 'Kategorie hinzugefügt.' );
			return $this->redirectToRoute( 'categoryIndex' );
		}

		// Render category index with category form
		return $this->render('category/category-index.html.twig', [
			'form' => $form->createView(),
			'rootCategories' => $rootCategories
		]);
	}

	/**
	 * @Route("/categories/{id}/edit", name="categoryEdit")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function editAction(Request $request, Category $category)
	{

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		// Get root categories
		$rootCategories = $qb->select('rc')
		                     ->from( 'WeavidBundle:Category', 'rc' )
		                     ->where( 'rc.parent is NULL' )
		                     ->getQuery()
		                     ->getResult();

		// Create category form and handle possible request
		$form = $this->createForm( CategoryType::class, $category );
		$form->handleRequest($request);

		// If the form was successfully submitted, is valid and the user is granted admin, persist category
		if($form->isSubmitted() && $form->isValid() && $this->isGranted( 'ROLE_ADMIN' )){
			$em->persist( $category );
			$em->flush();
			// add flash message if successful
			$this->addFlash( 'success', 'Änderungen übernommen.' );
			return $this->redirectToRoute( 'categoryIndex' );
		}

		// Render category index with category form
		return $this->render('category/category-index.html.twig', [
			'form' => $form->createView(),
			'rootCategories' => $rootCategories
		]);
	}

	/**
	 * @Route("/categories/{id}/delete", name="categoryDelete")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function deleteAction(Request $request, Category $category)
	{

		if(!$category->hasChildren()){
			// you are only able to remove a category, if there's no child entry
			/** @var EntityManager $em */
			$em = $this->getDoctrine()->getManager();
			$em->remove( $category );
			$em->flush();
			// add flash message if successful
			$this->addFlash( 'success', 'Kategorie entfernt.' );
		} else {
			// add flash message if unsuccessful
			$this->addFlash('error', 'Bitte entfernen Sie zuerst alle Kindelemente.');
		}

		// redirect to category index
		return $this->redirectToRoute( 'categoryIndex' );

	}

	/**
	 * @Route("/categories/{id}", name="categoryShow")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showAction(Request $request, Category $category)
	{

		// Call fetch video Utility method
		$videos = CategoryVideos::fetchAllVideosInCategory( $category );

		return $this->render('category/category-videos.html.twig', [
			'category' => $category,
			'videos' => $videos
		]);

	}

}
