<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MercuryBundle\Form\ReleaseType;
use MercuryBundle\Entity\Release;
use MercuryBundle\Entity\UserViewRelease;

/**
 * Controller Release.
 */
class ReleaseController extends Controller
{
    /**
     * @Route("/gestion", name="gestion_release")
     *
     * @param Request $request
     *
     * @return View/Exception
     */
    public function indexaction(request $request)
    {
        $releases = $this->getDoctrine()->getRepository('MercuryBundle:Release')->findBy(array(), array('id' => 'DESC'));
        $release = new Release();
        $form = $this->createForm(ReleaseType::class, $release, array('action' => $this->generateUrl('gestion_release')));
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $release->setAdmin($this->getUser());
                $release->setDate(new \DateTime(date('Y-m-d')));
                $release->setPublished(false);
                $em->persist($release);
                $em->flush();
                $arrayJson = array(
                    'id' => $release->getId(),
                    'title' => $release->getTitle(),
                    'description' => $release->getDescription(),
                    'version' => $release->getVersion(),
                    'date' => $release->getDate()->format('d/m/Y'),
                );

                return new JsonResponse($arrayJson);
            }
        }

        return $this->render('MercuryBundle:Release:gestion.html.twig', array('releases' => $releases, 'form' => $form->createView()));
    }

    /**
     * @Route("/sidebar-release", name="sidebar_release")
     *
     * @param Request $request
     *
     * @return View
     */
    public function sidebarReleaseAction(Request $request)
    {
        $arrayReleases = $this->getDoctrine()->getRepository('MercuryBundle:Release')
        ->findBy(array('published' => true), array('date' => 'DESC'));
        $cptReleaseNotsee = 0;
        $user = $this->getUser();

        foreach ($arrayReleases as $release) {
            $verifExist = $this->getDoctrine()->getRepository('MercuryBundle:UserViewRelease')->verifExistTracker($user, $release);
            if (0 == count($verifExist)) {
                ++$cptReleaseNotsee;
            }
        }

        return $this->render('MercuryBundle:Release:sidebar_release.html.twig', array('releases' => $arrayReleases, 'cpt_release_notsee' => $cptReleaseNotsee));
    }

    /**
     * @Route("/overview/{id}", name="overview_release", defaults={"id" = null})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return View
     */
    public function overviewAction(Request $request, $id)
    {
        $releases = $this->getDoctrine()->getRepository('MercuryBundle:Release')->findBy(array('published' => true), array('date' => 'DESC'));

        $arrayReleases = array();
        foreach ($releases as $release) {
            $arrayReleases[$release->getDate()->format('M Y')][] = $release;
        }

        return $this->render('MercuryBundle:Release:overview.html.twig', array('array_releases' => $arrayReleases, 'id' => $id));
    }

    /**
     * @Route("/save", name="release_save")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function saveAction(Request $request)
    {
        $id = $request->request->get('id');
        $markdown = $request->request->get('markdown');
        $release = $this->getDoctrine()->getRepository('MercuryBundle:Release')->find($id);
        $release->setMarkdown($markdown);
        $em = $this->getDoctrine()->getManager();
        $em->persist($release);
        $em->flush();

        return new JsonResponse(array('toastr' => "Release {$release->getTitle()} saved", 'markdown' => $markdown));
    }

    /**
     * @Route("/share", name="release_share")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function shareAction(Request $request)
    {
        $id = $request->request->get('id');
        $release = $this->getDoctrine()->getRepository('MercuryBundle:Release')->find($id);
        $release->setPublished(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($release);
        $em->flush();

        return new Response("Release {$release->getTitle()} published");
    }

    /**
     * @Route("/remove", name="release_remove")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function removeAction(Request $request)
    {
        $id = $request->request->get('id');
        $release = $this->getDoctrine()->getRepository('MercuryBundle:Release')->find($id);
        $title = $release->getTitle();
        $em = $this->getDoctrine()->getManager();
        $em->remove($release);
        $em->flush();

        return new Response("Release {$title} removed");
    }

    /**
     * @Route("/user-view-release", name="user_view_release")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userViewReleaseAction(Request $request)
    {
        $id = $request->request->get('id');
        $release = $this->getDoctrine()->getRepository('MercuryBundle:Release')->find($id);
        $user = $this->getUser();
        $verifExist = $this->getDoctrine()->getRepository('MercuryBundle:UserViewRelease')->verifExistTracker($user, $release);

        if (0 == count($verifExist)) {
            $UserViewRelease = new UserViewRelease();
            $UserViewRelease->setUtilisateur($user)->setRelease($release);
            $em = $this->getDoctrine()->getManager();
            $em->persist($UserViewRelease);
            $em->flush();
        }

        return new Response('ok');
    }

    /**
     * @Route("/actualize-releases", name="actualize_releases")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function actualizeReleaseAction(Request $request)
    {
        $releases = $this->getDoctrine()->getRepository('MercuryBundle:Release')->findBy(array('published' => true), array('date' => 'DESC'));
        $arrayJson = array();
        $user = $this->getUser();
        $cpt = 0;
        foreach ($releases as $release) {
            $verifExist = $this->getDoctrine()->getRepository('MercuryBundle:UserViewRelease')->verifExistTracker($user, $release);
            if (0 == count($verifExist)) {
                $arrayJson['releases'][] = array('id' => $release->getId(), 'title' => $release->getTitle(), 'description' => $release->getDescription(), 'date' => $release->getDate()->format('Y-m-d'));
                ++$cpt;
            }
        }
        $arrayJson['length'] = $cpt;

        return new JsonResponse($arrayJson);
    }
}
