<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;


class DownloadController extends AbstractController
{


    private $elementsDir;

    public function __construct($elementsDir)
    {
        $this->elementsDir = $elementsDir;
    }


    /**
     * @Route("/c/download/{id}/{name}", name="download_element")
     * @Route("/c/download/{id}/{name}", name="download_controller")
     */
    public function index($id,$name): Response
    {

        if ($name == "default.png"){
            $response = new BinaryFileResponse($this->getParameter('elemetsDirectory').'/'.$name);
        }else{
            $response = new BinaryFileResponse($this->elementsDir.'/'.md5($id).'/'.$name);
        }
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $name,
            iconv('UTF-8', 'ASCII//TRANSLIT', $name)
        );

        return $response;
    }
}
