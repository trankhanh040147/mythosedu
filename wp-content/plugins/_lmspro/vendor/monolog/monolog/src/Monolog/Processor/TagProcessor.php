<?php declare(strict_types=1);

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Processor;

/**
 * Adds a Tags array into record
 *
 * @author Martijn Riemers
 */
class TagProcessor implements ProcessorInterface
{
    /** @var string[] */
    private $Tags;

    /**
     * @param string[] $Tags
     */
    public function __construct(array $Tags = [])
    {
        $this->setTags($Tags);
    }

    /**
     * @param string[] $Tags
     */
    public function addTags(array $Tags = []): self
    {
        $this->Tags = array_merge($this->Tags, $Tags);

        return $this;
    }

    /**
     * @param string[] $Tags
     */
    public function setTags(array $Tags = []): self
    {
        $this->Tags = $Tags;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(array $record): array
    {
        $record['extra']['Tags'] = $this->Tags;

        return $record;
    }
}
