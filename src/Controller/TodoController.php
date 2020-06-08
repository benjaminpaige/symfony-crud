<?php
    namespace App\Controller;

    use App\Entity\Todo;
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
            $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
            return $this->render('todos/index.html.twig', array('todos' => $todos));
        }

        /**
         * @Route("/todo/save")
         */
        // public function save() {
        //     $entityManager = $this->getDoctrine()->getManager();

        //     $todo = new Todo();
        //     $todo->setTitle('Todo two');
        //     $todo->setDescription('Todo description for the second todo whats up yo');

        //     $entityManager->persist($todo);

        //     $entityManager->flush();

        //     return new Response('Saved an article with the id of '.$todo->getId());
        // }
    }