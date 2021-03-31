<?php


namespace App\Controller\Admin;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{


    /**
     * @Route  ("/login",  name ="login", methods={"GET", "POST"})
     * @return Response
     */
    public function login(Request $request)
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            $userEmail = $request->request->get('email');
            /** @var User $user */
            $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email' => $userEmail]);
            if ($user === null) {
                throw new BadRequestException("Böyle bir kullanıcı yok");
            }
            $userPassword = md5($request->request->get('password'));
            if ($user->getPassword() !== $userPassword) {
                throw new BadRequestException("Parola hatalı");

            }
            $request->getSession()->set('user', $user);
            return $this->redirectToRoute("admin");;

        }
        return $this->render('admin/login.twig', []);


    }

    /**
     * @Route  ("/register",  name ="register", methods={"GET", "POST"})
     * @return Response
     */
    public function register(Request $request)
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            $user = new User();
            $user->setName($request->request->get('name'));
            $user->setLastname($request->request->get('lastname'));
            $user->setEmail($request->request->get('email'));
            $user->setPassword(md5($request->request->get('password')));
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("login");
        }
        return $this->render('admin/register.twig');
    }
}





