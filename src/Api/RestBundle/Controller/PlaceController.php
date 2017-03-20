<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/20/17
 * Time: 11:54 AM
 */

namespace Api\RestBundle\Controller;

use Api\RestBundle\Type\PlaceType;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle

use Api\RestBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaceController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\View()
     * @Rest\Get("/places")
     */
    public function allPlacesAction(Request $request)
    {

        /* @var $places Place[] */
        $places = $this->getDoctrine()
            ->getRepository('ApiRestBundle:Place')
            ->findAll();
        return $places;
    }

    /**
     * @param Request $request
     * @param $place_id
     * @return JsonResponse
     *
     * @Rest\View()
     * @Rest\Get("/places/{place_id}")
     */
    public function getPlaceAction(Request $request, $place_id)
    {
        /* @var $place Place */
        $place = $this->getDoctrine()
            ->getRepository('ApiRestBundle:Place')
            ->find($place_id);

        if(empty($place)) {
            return View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $place;
    }

    /**
     * @param Request $request
     * @return Place|\Symfony\Component\Form\Form
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/places")
     */
    public function postPlacesAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(new PlaceType(), $place);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();
            return $place;
        } else {
            return $form;
        }
    }

    /**
     * @param Request $request
     * @param Place $place
     * @return Place|\Symfony\Component\Form\Form|JsonResponse
     *
     * @Rest\View()
     * @Rest\Put("/places/{id}")
     */
    public function updatePlaceAction(Request $request, Place $place)
    {

        if (empty($place)) {
            return View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($place);
            $em->flush();
            return $place;
        } else {
            return $form;
        }
    }

    /**
     * @param Request $request
     * @param Place $place
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/places/{id}")
     */
    public function removePlaceAction(Request $request, Place $place)
    {
        $em = $this->getDoctrine()->getManager();
        if ($place) {
            $em->remove($place);
            $em->flush();
        }
    }
}