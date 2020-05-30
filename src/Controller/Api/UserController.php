<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\User;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository; 
    }

    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
    /**
     * @Route("/users/add", name="user")
     */
    public function add(Request $request ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name= $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $role= $data['roles'];
        
        if(empty($email)||empty($password)){
            throw new NotFoundHttpException('pilas faltan algunos parametros o estan mas escribidos en el json');
        }

        $this->userRepository->saveUser($email, $password, $name, $role);

        return new JsonResponse(['status'=>'Excelente añadiste un nuevo usuarito!!!'], Response::HTTP_CREATED);
    }

    public function logg(){
        return new Response(sprintf('logged %s', $this->getUser()->getUserName()));
    }


    /**
     * @Route("/token", name="user")
     */
    public function isActiveToken(){
        
    }


}
