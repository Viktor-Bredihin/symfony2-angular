<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

/**
 * Post controller.
 *
 * @Route(defaults={"_format": "json"})
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/posts", options={"expose"=true})
     * @Method("GET")
     */
    public function getCollectionAction()
    {
        $params = $this->getRequest()->query->all();
        return $this->get('doctrine')->getManager()->getRepository('AppBundle:Post')->get($params);
    }

    /**
     * Get post entity
     *
     * @ParamConverter("post", class="AppBundle:Post")
     * @Route("/posts/{id}", options={"expose"=true})
     * @Method("GET")
     * @param Post $post
     */
    public function getAction(Post $post)
    {
        return array('post' => $post);
    }

    /**
     * Edit Post entity
     *
     * @ParamConverter("post", class="AppBundle:Post")
     * @Route("/posts/{id}", options={"expose"=true})
     * @Method("POST")
     * @param Post $post
     */
    public function editAction(Post $post)
    {
        return $this->processForm($post);
    }

    /**
     * Delete Post entity
     *
     * @ParamConverter("post", class="AppBundle:Post")
     * @Route("/posts/{id}", options={"expose"=true})
     * @Method("DELETE")
     * @param Post $post
     */
    public function deleteAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
    }

    /**
     * Create Post entity.
     *
     * @Route("/posts", options={"expose"=true})
     * @Method("POST")
     */
    public function createAction()
    {
        return $this->processForm(new Post());
    }

    /**
     * Process form
     *
     * @param  Post   $post [description]
     */
    private function processForm(Post $post)
    {
        $form = $this->createForm(new PostType(), $post);
        // handle form submit
        $form->handleRequest($this->getRequest());
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            
            return $post;
        }

        return View::create($form, 400);
    }
}
