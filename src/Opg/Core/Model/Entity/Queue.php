<?php

namespace Opg\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;

/**
 * Queue
 *
 * @ORM\Table(name="queue_business_rules", indexes={@ORM\Index(name="queue_business_rules_idx", columns={"id", "status"})})
 * @ORM\Entity
 */
class Queue implements HasIdInterface
{
    use HasId;

    /**
     * @var string
     *
     * @ORM\Column(name="queue", type="string", length=64, nullable=false)
     */
    protected $queue;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", nullable=false)
     */
    protected $data;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", length=1, nullable=false)
     */
    protected $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduled", type="datetime", nullable=false)
     */
    protected $scheduled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="executed", type="datetime", nullable=true)
     */
    protected $executed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finished", type="datetime", nullable=true)
     */
    protected $finished;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    protected $message;

    /**
     * @var string
     *
     * @ORM\Column(name="trace", type="text", nullable=true)
     */
    protected $trace;

    /**
     * Set queue
     *
     * @param string $queue
     *
     * @return Queue
     */
    public function setQueue( $queue )
    {
        $this->queue = (string) $queue;

        return $this;
    }

    /**
     * Get queue
     *
     * @return string
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Queue
     */
    public function setData( $data )
    {
        $this->data = (string) $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return Queue
     */
    public function setStatus( $status )
    {
        $this->status = (int) $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Queue
     */
    public function setCreated( DateTime $created )
    {
        $this->created = clone $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return  $this->created;
    }

    /**
     * Set scheduled
     *
     * @param \DateTime $scheduled
     *
     * @return Queue
     */
    public function setScheduled( DateTime $scheduled )
    {
        $this->scheduled = clone $scheduled;

        return $this;
    }

    /**
     * Get scheduled
     *
     * @return \DateTime
     */
    public function getScheduled()
    {
        return  $this->scheduled;
    }

    /**
     * Set executed
     *
     * @param \DateTime $executed
     *
     * @return Queue
     */
    public function setExecuted( DateTime $executed = null )
    {
        $this->executed = $executed ? clone $executed : null;

        return $this;
    }

    /**
     * Get executed
     *
     * @return \DateTime
     */
    public function getExecuted()
    {
        return $this->executed;
    }

    /**
     * Set finished
     *
     * @param \DateTime $finished
     *
     * @return Queue
     */
    public function setFinished( DateTime $finished = null )
    {
        $this->finished = $finished ? clone $finished : null;

        return $this;
    }

    /**
     * Get finished
     *
     * @return \DateTime
     */
    public function getFinished()
    {
        return  $this->finished;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Queue
     */
    public function setMessage( $message )
    {
        $this->message = (string) $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set trace
     *
     * @param string $trace
     *
     * @return Queue
     */
    public function setTrace( $trace )
    {
        $this->trace = (string) $trace;

        return $this;
    }

    /**
     * Get trace
     *
     * @return string
     */
    public function getTrace()
    {
        return $this->trace;
    }
}
