<?php


namespace Opg\Core\Model\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use JMS\Serializer\Annotation\Type;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Payment
 * @package Opg\Core\Model\Entity\Payment
 *
 * @ORM\Entity(repositoryClass="Application\Model\Repository\PaymentRepository")
 * @ORM\Table(name = "payments")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "payment_cheque" = "Opg\Core\Model\Entity\Payment\Cheque",
 * })
 */
abstract class PaymentType
{

    /**
     * @ORM\Column(
     *      type = "integer",
     *      options = {"unsigned": true}
     * )
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Id
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $paymentReference;

    public function __construct()
    {
    }
}
