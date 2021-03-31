<?php

namespace App\Controller\Admin;


use App\Entity\Blog;
use App\repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanel extends AbstractController
{
    /**
     * @Route  ("/admin" , name="admin")
     *
     *
     * @return Response
     */
    public function admin()
    {
        /** @var BlogRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
        return $this->render('admin/dashboard.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }
}
