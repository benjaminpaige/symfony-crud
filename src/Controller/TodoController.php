<?php
    namespace App\Controller;

    use App\Entity\Todo;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class TodoController extends Controller{
        /**
         * @Route("/", name="todo_list")
         * @Method({"GET"})
         */
        public function index() {
            $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
            return $this->render('todos/index.html.twig', array('todos' => $todos));
        }

        /**
         * @Route("/todo/delete/{id}", name="todo_delete")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id) {
            $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

            $entityManager =  $this->getDoctrine()->getManager();
                $entityManager->remove($todo);
                $entityManager->flush();

            $response = new Response();
            $response->send();
         }
         
        /**
         * @Route("/todo/new", name="new_todo")
         * @Method({"GET", "POST"})
         */
        public function new(Request $request) {
            $todo = new Todo();
            $formControlClassAttr = array('attr' => array('class' => 'form-control'));
            
            $form = $this->createFormBuilder($todo)
                 ->add('title', TextType::class, $formControlClassAttr)
                 ->add('description', TextareaType::class, $formControlClassAttr)
                 ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
                 ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $todo = $form->getData();

                $entityManager =  $this->getDoctrine()->getManager();
                $entityManager->persist($todo);
                $entityManager->flush();

                return $this->redirectToRoute('todo_list');
            }
                
            return $this->render('todos/new.html.twig', array('form' => $form->createView()));
         }

        /**
         * @Route("/todo/edit/{id}", name="edit_todo")
         * @Method({"GET", "POST"})
         */
        public function edit(Request $request, $id) {
            $todo = new Todo();
            $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
            $formControlClassAttr = array('attr' => array('class' => 'form-control'));
            
            $form = $this->createFormBuilder($todo)
                 ->add('title', TextType::class, $formControlClassAttr)
                 ->add('description', TextareaType::class, $formControlClassAttr)
                 ->add('save', SubmitType::class, array('label' => 'Save', 'attr' => array('class' => 'btn btn-primary mt-3')))
                 ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {

                $entityManager =  $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('todo_list');
            }
                
            return $this->render('todos/edit.html.twig', array('form' => $form->createView()));
         }

        /**
         * @Route("/todo/{id}", name="todo_show")
         * @Method({"GET"})
         */
        public function show($id) {
            $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
            return $this->render('todos/show.html.twig', array('todo' => $todo));
         }
    }
