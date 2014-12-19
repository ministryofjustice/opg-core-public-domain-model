<?php

namespace Opg\Core\Model\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use Opg\Core\Model\Entity\Document\Decorators\AssetLog;
use Opg\Core\Model\Entity\Document\Decorators\HasAssetLog;
use Opg\Core\Model\Entity\Document\Decorators\SystemType;
use Opg\Core\Model\Entity\Document\Decorators\HasSystemType;

/**
 * @ORM\Entity
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Document
 */
class ActionLog extends Document implements HasAssetLog, HasSystemType
{
    use AssetLog;
    use SystemType;

    /**
     * @Type("string")
     * @Accessor(getter="getDirection")
     * @ReadOnly
     */
    protected $direction = self::DOCUMENT_INTERNAL_CORRESPONDENCE;
}
