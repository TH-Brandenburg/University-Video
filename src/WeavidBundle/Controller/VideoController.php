<?php

namespace WeavidBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WeavidBundle\Entity\Video;
use WeavidBundle\Form\VideoType;

class VideoController extends Controller
{
    /**
     * @Route("/videos", name="videoIndex")
     */
    public function videoIndexAction(Request $request)
    {
        return $this->render('video/video-index.html.twig');
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
     * @Route("/videos/{id}", name="videoIndex")
     * @Security("video.isPublic() or (video.isReleased() and has_role('ROLE_USER'))")
     */
    public function videoPlayerAction(Request $request, Video $video)
    {



        return $this->render('video/video-index.html.twig');
    }

}
