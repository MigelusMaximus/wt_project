<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Event;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventRepository;


#[Route('/member')]
final class MemberController extends AbstractController
{
    #[Route(name: 'app_member_index', methods: ['GET'])]
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $memberRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_member_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('app_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('member/new.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_member_show', methods: ['GET'])]
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_member_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Member $member, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('member/edit.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_member_delete', methods: ['POST'])]
    public function delete(Request $request, Member $member, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_member_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/member/{id}/join-event/{eventId}', name: 'app_member_join_event')]
    public function joinEvent(
        int $id,
        int $eventId,
        MemberRepository $memberRepo,
        EventRepository $eventRepo,
        EntityManagerInterface $em
    ): Response {
        $member = $memberRepo->find($id);
        $event = $eventRepo->find($eventId);
    
        if (!$member || !$event) {
            throw $this->createNotFoundException('Member or Event not found');
        }
    
        if (!$member->getEvents()->contains($event)) {
            $member->addEvent($event);
            $em->flush();
            $this->addFlash('success', 'Member successfully joined the event.');
        } else {
            $this->addFlash('warning', 'Member is already registered in this event.');
        }
    
        return $this->redirectToRoute('app_member_index');
    }
    #[Route('/{id}/competitions', name: 'app_member_competitions')]
    public function competitions(
        int $id,
        MemberRepository $memberRepo,
        EventRepository $eventRepo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $member = $memberRepo->find($id);
        if (!$member) {
            throw $this->createNotFoundException('Member not found');
        }

        $availableEvents = $eventRepo->findAll();

        if ($request->isMethod('POST')) {
            $eventId = $request->request->get('event_id');
            $event = $eventRepo->find($eventId);

            if ($event && !$member->getEvents()->contains($event)) {
                $member->addEvent($event);
                $em->flush();
                $this->addFlash('success', 'Member registered for event.');
                return $this->redirectToRoute('app_member_competitions', ['id' => $member->getId()]);
            }
        }

        return $this->render('member/competitions.html.twig', [
            'member' => $member,
            'availableEvents' => $availableEvents,
        ]);
    
}



}
