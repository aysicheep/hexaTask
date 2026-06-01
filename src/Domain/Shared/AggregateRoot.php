<?php

declare(strict_types=1);

namespace App\Domain\Shared;

/**
 * Base class for aggregate roots in the domain model.
 *
 * Manages the collection of domain events raised during state changes,
 * which are released and dispatched after the aggregate is persisted.
 */
abstract class AggregateRoot
{
    /** @var DomainEvent[] */
    private array  $domainEvents = [];

    /**
     * Records a domain event to be dispatched after persistence.
     */
    protected function record(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }

    /**
     * Returns all recorded events and clears the internal list.
     *
     * @return DomainEvent[]
     */
    public function releaseEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }
}
