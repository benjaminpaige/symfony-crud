<?php
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class TodoController extends Controller{
        /**
         * @Route("/")
         * @Method({"GET"})
         */
        public function index() {
            $todos = [];
            return $this->render('todos/index.html.twig', array('todos' => $todos));
        }
    }