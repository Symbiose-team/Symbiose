<?php

namespace App\Controller\Reservation;
use http\Env\Request;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Field;
use App\Form\FieldType;
use Symfony\Component\Validator\Constraints\DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;


class FieldProviderController extends AbstractController
{
    /**
     * @Route("/field/provider", name="field_provider")
     */
    public function index(): Response
    {
        return $this->render('Reservation/field_provider/index.html.twig', [
            'controller_name' => 'FieldProviderController',
        ]);
    }

    /**
     * @Route("/provider",name="provider")
     */
    public function affiche()
    {
        $repo = $this->getDoctrine()->getRepository(Field::class);
        // look for multiple Product objects matching the supplier
        $fields = $repo->findall();
        return $this->render('Reservation/field_provider/affprovider.html.twig', ['terain' => $fields]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\Response
     * @Route ("/addprovider",name="addterain")
     */
    public function add(\Symfony\Component\HttpFoundation\Request $request)
    {
        $field = new Field();
        $form = $this->createForm(FieldType::class, $field);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($field);
            $em->flush();
            return $this->redirectToRoute('provider',[]);

        }
        return $this->render('Reservation/field_provider/addfield.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route ("delete/{id}",name="supprimerr")
     */
    public function supprimer($id)
    {
        $now = DateTime::DEFAULT_GROUP;
        $this->$now = new \DateTime('now');
        $repo = $this->getDoctrine()->getRepository(Field::class);
        $field = $repo->find($id);
        if ($field->getDateEnd() < $now ) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($field);
            $em->flush();
            return $this->redirectToRoute('provider',[]);
        }
        else return $this->render('Reservation/field_provider/error.html.twig');
    }

    /**
     * @Route ("/provider/update/{id}",name="updateprovider")
     */
    public function update(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $now = DateTime::DEFAULT_GROUP;
        $this->$now = new \DateTime('now');
        $repository = $this->getDoctrine()->getRepository(Field::class);
        $field = $repository->find($id);
        if ($field->getDateEnd() < $now or $field->getDateEnd() > $now ) {
            $form = $this->createForm(FieldType::class, $field);
            $form->add('Update', SubmitType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirectToRoute('provider');

            }
            return $this->render('Reservation/field_provider/update.html.twig', ['form' => $form->createView()]);
        }
        else return $this->render('Reservation/field_provider/error.html.twig');

    }

    /**
     * @Route("/contrat/{id}",name="contrat",methods={"Get","Post"})
     */
    public function Pdf($id):Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $repo = $this->getDoctrine()->getRepository(Field::class);
        $field = $repo->find($id);
        $html = $this->renderView('Reservation/Pdf/contrat.html.twig', ['testee' => $field]);
       // return  $this->render('Pdf/contrat.html.twig', ['test' => $field]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Contrat.pdf", [
            "Attachment" => false
        ]);
    }


}
