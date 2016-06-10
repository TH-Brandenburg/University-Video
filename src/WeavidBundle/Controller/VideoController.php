<?php

namespace WeavidBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\Comment;
use WeavidBundle\Entity\Video;
use WeavidBundle\Form\CommentType;
use WeavidBundle\Form\VideoType;

class VideoController extends Controller
{
    /**
     * @Route("/videos", name="videoIndex")
     */
    public function indexAction(Request $request)
    {

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        // Get all videos released
        $qb->select('v')->from('WeavidBundle:Video', 'v')
            ->where('v.released = 1');
        if($this->isGranted('ROLE_USER')){
            // Or owned if user
            $qb->orWhere('v.owner = :user')
                ->setParameter('user', $this->getUser());
        } else {
            // And public if not logged in
            $qb->andWhere('v.public = 1');
        }

        // Result into variable
        $videos = $qb->getQuery()->getResult();

        // Render template
        return $this->render('video/video-index.html.twig', [
            'videos' => $videos
        ]);
    }

    /**
     * @Route("/videos/add", name="videoAdd")
     * @Security("has_role('ROLE_LECTURER')")
     */
    public function createAction(Request $request)
    {

        $video = new Video();

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $video->setOwner($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
            $this->addFlash('success', 'Video hinzugefügt.');
            return $this->redirectToRoute('videoIndex');
        }

        return $this->render('video/add-video.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/videos/{id}/edit", name="videoEdit")
     * @Security("video.isOwner(user)")
     */
    public function updateAction(Request $request, Video $video)
    {

        $form = $this->createForm( VideoType::class, $video );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $video );
            $em->flush();
            $this->addFlash('success', 'Änderungen übernommen.');
        }

        return $this->render('video/edit-video.html.twig', [
            'video' => $video,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/videos/{id}", name="videoPlayer")
     * @Security("video.isPublic() or (video.isReleased() and has_role('ROLE_USER'))")
     */
    public function playerAction(Request $request, Video $video)
    {

        // Get Vimeo Service
        $vimeo = $this->get('app.vimeo');

        // Get Vimeo ID from URL
        $primaryVideoRequestURL = '/videos'.parse_url($video->getPrimaryVideoUrl(), PHP_URL_PATH);
        $secondaryVideoRequestURL = '/videos'.parse_url($video->getSecondaryVideoUrl(), PHP_URL_PATH);

        // Make requests to Vimeo API
        $primaryVideo = $vimeo->request($primaryVideoRequestURL, null, 'GET');
        $secondaryVideo = $vimeo->request($secondaryVideoRequestURL, null, 'GET');

        // Reorder response array
        $files = $primaryVideo['body']['files'];
        $primaryVideo['body']['files'] = [];
        foreach($files as $file){
            $quality = $file['quality'];
            $primaryVideo['body']['files'][$quality] = $file;
        }
        $files = $secondaryVideo['body']['files'];
        $secondaryVideo['body']['files'] = [];
        foreach($files as $file){
            $quality = $file['quality'];
            $secondaryVideo['body']['files'][$quality] = $file;
        }
        unset($files);

        // Comments form
        $comment = new Comment();
        $comment->setVideo($video);
        $form = $this->createForm( CommentType::class, $comment, [
            'action' => $this->generateUrl( 'newComment', [ 'id' => $video->getId() ] )
        ]);

        // Return videoplayer page
        return $this->render('video/videoplayer.html.twig', [
            'video' => $video,
            'primaryVideo' => $primaryVideo,
            'secondaryVideo' => $secondaryVideo,
            'commentForm' => $form->createView()
        ]);
    }

}
