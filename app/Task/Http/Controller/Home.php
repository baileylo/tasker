<?php namespace Portico\Task\Http\Controller;

use Controller, View, Auth;
use Portico\Task\Ticket\TicketRepository;
use Portico\Task\UserStream\UserStreamRepository;

class Home extends Controller
{
    /** @var TicketRepository  */
    protected $ticketRepo;

    /** @var UserStreamRepository */
    private $userStreamRepo;

    public function __construct(TicketRepository $ticketRepo, UserStreamRepository $userStreamRepo)
    {
        $this->ticketRepo = $ticketRepo;
        $this->userStreamRepo = $userStreamRepo;
    }

    public function home()
    {
        $user = Auth::user();

        $newTickets = $this->ticketRepo->findNewTicketsForProjectsFollowedByUser($user->id, 5);
        $updatedTickets = $this->ticketRepo->findRecentlyUpdatedTicketsForProjectsFollowedByUser($user->id, 5);
        $streamItems = $this->userStreamRepo->paginatedList($user->id, 25);

        return View::make('home.index', compact('newTickets', 'updatedTickets', 'streamItems'));
    }

    public function logIn()
    {
        return View::make('home.login');
    }
} 