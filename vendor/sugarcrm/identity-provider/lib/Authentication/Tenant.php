<?php

namespace Sugarcrm\IdentityProvider\Authentication;

use Sugarcrm\IdentityProvider\Srn\Srn;

/**
 * Tenant entity
 */
class Tenant
{
    /**
     * Tenant status
     * @var integer
     */
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $logo;

    /**
     * @var int
     */
    protected $status;


    /**
     * Converts Srn object to a Tenant
     * @param Srn $srn
     *
     * @throws \RuntimeException
     * @return Tenant
     */
    public static function fromSrn(Srn $srn): self
    {
        return (new self())
            ->setId($srn->getTenantId())
            ->setRegion($srn->getRegion());
    }

    /**
     * Creates a new Tenant object populating required fields only
     * @param string $id
     * @param string $region
     * @return Tenant
     */
    public static function new(string $id, string $region)
    {
        return (new self())
            ->setId($id)
            ->setRegion($region)
            ->setDisplayName(null)
            ->setLogo(null)
            ->setStatus(null);
    }

    /**
     * Converts raw data array to a Tenant
     * @param array $data tenant as associative array
     *
     * @throws \RuntimeException
     * @return Tenant
     */
    public static function fromArray(array $data): self
    {
        [
            'id' => $id,
            'region' => $region,
            'display_name' => $displayName,
            'logo' => $logo,
            'status' => $status,
        ] = array_merge(
            // optional params
            array_fill_keys(['display_name', 'logo', 'status'], null),
            $data
        );

        return (new self())
            ->setId($id)
            ->setRegion($region)
            ->setDisplayName($displayName)
            ->setLogo($logo)
            ->setStatus($status);
    }

    /**
     * @param string $id
     * @return Tenant
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
    }

    /**
     * @param string $region
     * @return Tenant
     */
    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return (string)$this->region;
    }

    /**
     * @param null|string $displayName
     * @return Tenant
     */
    public function setDisplayName(?string $displayName): self
    {
        $this->displayName = $displayName ?? '';
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return (string)$this->displayName;
    }

    /**
     * @param null|string $logo
     * @return Tenant
     */
    public function setLogo(?string $logo): self
    {
        $this->logo = $logo ?? '';
        return $this;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return (string)$this->logo;
    }

    /**
     * @param int|null $status
     * @return Tenant
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status ?? self::STATUS_ACTIVE;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->status;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }
}
