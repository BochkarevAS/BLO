<?php

namespace App\Controller\Client;

use App\Entity\Client\Company;
use App\Entity\Client\Price;
use App\Form\Client\PriceType;
use App\Service\Client\PriceService;
use App\Service\FileUploader;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/price")
 */
class PriceController extends AbstractController
{
    /**
     * @Route("/{id}", name="client_price_load")
     */
    public function load(Request $request, Company $company, FileUploader $fileUploader, PriceService $priceService, KernelInterface $kernel): Response
    {
        $price = new Price();
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $files = $price->getPath();
            $paths = [];

            foreach ($files as $file) {
                $fileName = $this->getParameter('prices_directory').'/'.$fileUploader->upload($file);
                $price->setPath($fileName);
                $price->setCompanyId($company->getId());
                $paths[] = $fileName;

                $em->persist($price);
            }

            $em->flush();

//            $priceService->load($paths);

            $application = new Application($kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput([
                'command' => 'import:parts'
            ]);

            $output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, true);
            $application->run($input, $output);


            return new Response();
//            $converter = new AnsiToHtmlConverter();
//            $content = $output->fetch();
//
//            return new Response($converter->convert($content));

//            return $this->redirectToRoute('client_price_load', ['id' => $company->getId()]);
        }

        return $this->render('client/price/load.html.twig', [
            'company' => $company,
            'form'    => $form->createView()
        ]);
    }

//    public function sendSpool($messages = 10, KernelInterface $kernel)
//    {
//        $application = new Application($kernel);
//        $application->setAutoExit(false);
//
//        $input = new ArrayInput([
//            'command' => 'import:parts'
//        ]);
//
//        $output = new BufferedOutput();
//        $application->run($input, $output);
//
//        $content = $output->fetch();
//
//        return new Response($content);
//    }
}