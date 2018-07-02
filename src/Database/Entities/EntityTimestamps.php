<?php

namespace ByRobots\WriteDown\Database\Entities;

trait EntityTimestamps
{
    /** @Column(name="created_at", type="datetime") */
    protected $created_at;

    /** @Column(name="updated_at", type="datetime") */
    protected $updated_at;

    /** @PrePersist */
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime('now');
    }

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime('now');
    }
}
