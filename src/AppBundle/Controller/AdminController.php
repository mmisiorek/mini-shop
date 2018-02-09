<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\Type\ProductType;
use AppBundle\Location\LocationContext;
use AppBundle\Creator\SwiftMessageCreator;
use AppBundle\Creator\SwiftMessageCreatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/new-product", name="admin_new_product")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newProductAction(Request $request)
    {
        $locationContext = $this->container->get(LocationContext::class);

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, [
            'locationContext' => $locationContext
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            /* @var $messageCreator SwiftMessageCreatorInterface */
            $messageCreator = $this->get(SwiftMessageCreator::class);
            /* @var $mailer \Swift_Mailer */
            $mailer = $this->get('mailer');

            $mailer->send($messageCreator->createProductAddedMail($product, 'fake@example.com'));

            return $this->redirectToRoute("homepage");
        }

        return $this->render('/Admin/new_product.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
