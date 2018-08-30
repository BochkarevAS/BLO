<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="client_comment_new", methods="GET|POST")
     */
    public function new()
    {

    }

}