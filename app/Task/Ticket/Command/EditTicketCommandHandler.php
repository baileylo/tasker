<?php namespace Portico\Task\Ticket\Command;

use Illuminate\Database\DatabaseManager;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Portico\Task\Ticket\Ticket;

class EditTicketCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /** @var DatabaseManager */
    private $db;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param EditTicketCommand $command
     * @return Ticket
     */
    public function handle($command)
    {
        $this->db->beginTransaction();

        $ticket = $command->getTicket();
        $updatedAttributes = $ticket->edit(
            $command->getName(),
            $command->getDescription(),
            $command->getDueDate(),
            $command->getStatus(),
            $command->getAssignee()
        );

        if (empty($updatedAttributes)) {
            // We're not firing any events since, nothing was modified.
            $ticket->releaseEvents();
            return true;
        }

        // Lets create the comment if it exists
        if ($command->getComment()) {
            $comment = $command->getComment();
            $comment->setTicket($ticket);
            $comment->setAuthor($command->getEditor());

            $comment->save();
        }


        $ticket->save();

        $this->db->commit();

        return $ticket;
    }

}