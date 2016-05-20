<?php

namespace WeavidBundle\Controller;

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
    public function videoIndexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository( 'WeavidBundle:Video' )->findAll();

        return $this->render('video/video-index.html.twig', [
            'videos' => $videos
        ]);
    }

    /**
     * @Route("/videos/add", name="videoAdd")
     * @Security("has_role('ROLE_LECTURER')")
     */
    public function videoAddAction(Request $request)
    {

        $video = new Video();

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $video->setOwner($this->get('security.token_storage')->getToken()->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
        }

        return $this->render('video/add-video.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/videos/{id}", name="videoPlayer")
     * @Security("video.isPublic() or (video.isReleased() and has_role('ROLE_USER'))")
     */
    public function videoPlayerAction(Request $request, Video $video)
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
