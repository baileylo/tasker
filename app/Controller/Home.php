<?php namespace Task\Controller;

use Controller, View, Auth;

class Home extends Controller
{

    public function home()
    {
        $user = Auth::user();

        $ticketRepo = \App::make('Task\Model\Ticket\RepositoryInterface');
        $newTickets = $ticketRepo->findNewTicketsForProjectsFollowedByUser($user->id, 5);
        $updatedTickets = $ticketRepo->findRecentlyUpdatedTicketsForProjectsFollowedByUser($user->id, 5);

        return View::make('home.index', compact('newTickets', 'updatedTickets'));
    }

    public function logIn()
    {
        return View::make('home.login');
    }
} 