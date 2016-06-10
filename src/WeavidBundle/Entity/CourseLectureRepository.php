<?php
namespace WeavidBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class CourseLectureRepository extends EntityRepository
{

	public function findByCourseOrderedBySequence(Course $course)
	{

		$courseLecture = $this->createQueryBuilder('qb')
		                     ->select('cl')
		                     ->from('WeavidBundle:CourseLecture', 'cl')
		                     ->where('cl.course = :course')
		                     ->andWhere( 'cl.previousLecture is NULL')
		                     ->setParameter( 'course', $course )
		                     ->getQuery()->getOneOrNullResult();

		if($courseLecture === null){
			return null;
		}

		$courseLectures = new ArrayCollection();
		do {
			$courseLectures->add($courseLecture);
			$courseLecture = $courseLecture->getNextLecture();
		} while($courseLecture !== null);

		return $courseLectures;

	}

}