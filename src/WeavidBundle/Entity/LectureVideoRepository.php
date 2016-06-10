<?php
namespace WeavidBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class LectureVideoRepository extends EntityRepository
{

	public function findByLectureOrderedBySequence(Lecture $lecture)
	{

		$lectureVideo = $this->createQueryBuilder('qb')
			->select('lv')
			->from('WeavidBundle:LectureVideo', 'lv')
			->where('lv.lecture = :lecture')
			->andWhere( 'lv.previousLectureVideo is NULL')
			->setParameter( 'lecture', $lecture )
			->getQuery()->getOneOrNullResult();

		if($lectureVideo === null){
			return null;
		}
		
		$lectureVideos = new ArrayCollection();
		do {
			$lectureVideos->add($lectureVideo);
			$lectureVideo = $lectureVideo->getNextLectureVideo();
		} while($lectureVideo !== null);

		return $lectureVideos;

	}

}