<?php namespace spec\Portico\Task\Ticket;

use Illuminate\Database\Connection;
use PhpSpec\ObjectBehavior;
use Portico\Core\PhpSpec\Relatable;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Command\CreateTicketCommand;
use Portico\Task\Ticket\Enum\Status;
use Portico\Task\Ticket\Enum\Type;
use Portico\Task\Ticket\Ticket;
use Portico\Task\Ticket\TicketFactory;
use Portico\Task\User\User;
use Prophecy\Argument;

/**
 * @property Ticket makeFromCommand
 */
class TicketFactorySpec extends ObjectBehavior
{
    use Relatable;

    function it_is_initializable()
    {
        $this->shouldHaveType(TicketFactory::class);
    }

    function it_should_generate_ticket_from_a_command(Connection $conn)
    {
        $this->relate($conn);

        $project = new Project;
        $project->id = 12;

        $reporter = new User;
        $reporter->id = 54;

        $assignee = new User;
        $assignee->id = 4;

        $dueDate = new \DateTime;

        $expectedTicket = new Ticket();
        $expectedTicket->setProject($project);
        $expectedTicket->setReporter($reporter);
        $expectedTicket->setAssignee($assignee);
        $expectedTicket->description = 'A tickets description';
        $expectedTicket->name = 'Sample Ticket';
        $expectedTicket->type = Type::FEATURE;
        $expectedTicket->status = Status::WAITING;
        $expectedTicket->due_at = $dueDate;

        $command = new CreateTicketCommand(
            $expectedTicket->name,
            $expectedTicket->description,
            $expectedTicket->type,
            $expectedTicket->reporter,
            $expectedTicket->project,
            $expectedTicket->assignee,
            $dueDate
        );

        $command->setAssignee($expectedTicket->assignee);

        $this->makeFromCommand($command)->name->shouldBe($expectedTicket->name);
        $this->makeFromCommand($command)->description->shouldBe($expectedTicket->description);
        $this->makeFromCommand($command)->type->shouldBe($expectedTicket->type);
        $this->makeFromCommand($command)->status->shouldBe($expectedTicket->status);
        $this->makeFromCommand($command)->due_at->shouldBeLike($expectedTicket->due_at);
        $this->makeFromCommand($command)->project->shouldBeLike($expectedTicket->project);
        $this->makeFromCommand($command)->assignee->shouldBeLike($expectedTicket->assignee);
        $this->makeFromCommand($command)->reporter->shouldBeLike($expectedTicket->reporter);
    }
}