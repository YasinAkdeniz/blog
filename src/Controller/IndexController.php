<?php

namespace App\Controller;



use App\Entity\GeneralSetting;
use App\Entity\Blog;
use App\Entity\Messages;
use App\Entity\User;
use App\Repository\BlogRepository;
use App\Service\Filter\Event\ResolveEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class IndexController extends AbstractController
{

    /**
     * @Route("/", name="index")
     * @return Response
     */

    public function listAction(Request $request, EventDispatcherInterface $eventDispatcher)
    {

        $event = new ResolveEvent($request);
        $eventDispatcher->dispatch($event, 'filter.build');

        return $this->render('list.twig', [
            'url_items' => $event->getUrlItems(),
            'raw_url_items' => $event->getRawUrlItems(),
            'total_blog_count' => $event->getCount(),
            'blogs' => $event->getSlicedBlogs(),
            'settings' => $this->getSettings(),
        ]);

    }
    /**
     *@Route("/blog/{id}", name="blog", methods={"GET", "POST"})
     *@return Response
     */
    public function viewAction($id)
    {
        /** @var BlogRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
        $blog = $blogRepository->find($id);
        return $this->render('detail.twig', [
            'blog' => $blog,
            'settings' => $this->getSettings(),

        ]);
    }
        /** @Route("/contact", name="blog_contact", methods={"GET", "POST"})
         * @return Response
         */
    public function viewContactAction()
    {
        return $this->render('contact.twig',[
            'settings' =>$this->getSettings()
            ]);
    }


    public function resultAction()
    {
        /** @var BlogRepository $blogRepository */
        return $this->render('search.twig', [
            'resultSearch'=> $blogRepository->getSearchResults(),
        ]);
    }

    /**
     *@Route("/send-message", name="send_message", methods ={"GET","POST"})
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            $message = new Messages();

            $message->setName($request->request->get('name'));
            $message->setEmail($request->request->get('email'));
            $message->setTitle($request->request->get('title'));
            $message->setMessage($request->request->get('message'));



            $this->getDoctrine()->getManager()->persist($message);
            $this->getDoctrine()->getManager()->flush();
        }
            return $this->render('contact.twig', [
                'settings' => $this->getSettings(),
            ]);

    }




}



//        /**
//         * @Route("/", name="index")
//         * @return Response
//         */
//    public function viewAction($id)
//    {
//        /** @var BlogRepository $blogRepository */
//        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
//        $blog = $blogRepository->find($id);
//        $settings = $this->getDoctrine()->getManager()->getRepository(GeneralSetting::class)->findAll();
//
//        return $this->render('detail.twig', [
//            'blog' => $blog,
//            'settings' => $settings,
//            'recentBlogs' => $blogRepository->getLastFiveBlogEntries(),
//
//        ]);
//    }





