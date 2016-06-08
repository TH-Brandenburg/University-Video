<?php

namespace WeavidBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\Category;
use WeavidBundle\Form\CategoryType;

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

		$category = new Category();
		$form = $this->createForm( CategoryType::class, $category );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$em->persist( $category );
			$em->flush();
			return $this->redirectToRoute( 'categoryIndex' );
		}

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

		$form = $this->createForm( CategoryType::class, $category );
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$em->persist( $category );
			$em->flush();
			return $this->redirectToRoute( 'categoryIndex' );
		}

		return $this->render('category/category-index.html.twig', [
			'form' => $form->createView(),
			'rootCategories' => $rootCategories
		]);
	}

	/**
	 * @Route("/categories/{id}", name="categoryShow")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showAction(Request $request, Category $category)
	{

		$videos = [];
		$videos = array_merge($videos, $category->getVideo()->toArray());
		foreach($category->getChildren() as $firstLevelCategory)
		{
			$videos = array_merge($videos, $firstLevelCategory->getVideo()->toArray());
			foreach($firstLevelCategory->getChildren() as $secondLevelCategory)
			{
				$videos = array_merge($videos, $secondLevelCategory->getVideo()->toArray());
			}
		}
		$videos = array_unique( $videos );
		
		return $this->render('video/video-index.html.twig', [
			'videos' => $videos
		]);

	}

}
