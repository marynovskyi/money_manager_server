<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Account;
use AppBundle\Entity\Organization;
use AppBundle\Form\CreateOrganizationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/organization")
 */
class OrganizationController extends Controller
{
    /**
     * @Route("/add", name="organization_create")
     */
    public function createOrganizationAction(Request $request)
    {
        $organization = new Organization();
        $form = $this->createForm(CreateOrganizationType::class, $organization);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $organization->setCreator($this->getUser());
            $organization->addMember($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($organization);
            $em->flush();

            return $this->redirectToRoute('profile_me');
        }

        return $this->render('organization/add_organization.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{id}", name="organization_details", requirements={"id": "\d+"})
     */
    public function organizationDetailsAction(Request $request, $id)
    {
        $organization = $this->getDoctrine()->getManager()->getRepository(Organization::class)->find($id);
        return $this->render('organization/organization_details.html.twig', [
            'organization' => $organization
        ]);
    }

    /**
     * @Route("/accounts/all1", name="accounts_all1")
     */
    public function all1AccountAction(Request $request)
    {
        $accounts = $this->getDoctrine()->getManager()->getRepository(Account::class)->loadAllAccounts();

        return $this->render('account/all_accounts.html.twig', [
            'accounts' => $accounts
        ]);
    }

    /**
     * @Route("/accounts/{id}", name="accounts_details")
     */
    public function accountDetailsAction($id)
    {
        $account = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Account::class)
            ->loadDetailsAccount($this->getUser()->getId(), $id);

        return $this->render('account/account_details.html.twig', array(
            'account' => $account
        ));
    }

    /**
     * @Route("/qwerty123", name="qwerty123")
     */
    public function qwerty123Action()
    {
        return $this->json(['key' => 'hello']);
    }
}