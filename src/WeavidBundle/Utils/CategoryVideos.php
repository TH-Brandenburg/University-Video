<?php
namespace WeavidBundle\Utils;

use WeavidBundle\Entity\Category;
use WeavidBundle\Entity\Video;

class CategoryVideos {

	/**
	 * Recursively fetch videos of category and all sub categories.
	 *
	 * @param Category $category
	 *
	 * @return array|Video
	 */
	public static function fetchAllVideosInCategory(Category $category)
	{
		// Create array with videos of category
		$videos = $category->getVideo()->toArray();

		// Run through every sub category and merge return value with this categories videos
		foreach($category->getChildren() as $subCategory){
			$videos = array_merge($videos, self::fetchAllVideosInCategory( $subCategory ));
		}

		// Remove redundant videos
		$videos = array_unique( $videos );

		return $videos;
	}

}