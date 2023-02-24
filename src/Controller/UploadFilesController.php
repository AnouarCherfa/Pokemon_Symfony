<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadFilesController extends AbstractController
{
    #[Route('/upload/files', name: 'app_upload_files')]
    public function index(Request $request): Response
    {

        dump($file = $request->files->get('file'));


        return $this->render('upload_files/index.html.twig', [
            'controller_name' => 'UploadFilesController',
        ]);
    }
}
