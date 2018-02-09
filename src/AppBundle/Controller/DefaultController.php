<?php

namespace AppBundle\Controller;

use AppBundle\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /* @var $productRepo \AppBundle\Repository\ProductRepository */
        $productRepo = $this->get(ProductRepository::class);

        $page = 1;
        if($request->query->has('page')) {
            $page = $request->query->get('page');
        }

        $pagination = $productRepo->getPaginatedProducts($page, 10);

        // replace this example code with whatever you need
        return $this->render('Default/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('/Default/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
}
