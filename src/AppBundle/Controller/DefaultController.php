<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('general');
        }
        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        
        return $this->render('default/homepage.html.twig', array(
            'csrf_token' => $csrfToken,
            ));
    }
}
