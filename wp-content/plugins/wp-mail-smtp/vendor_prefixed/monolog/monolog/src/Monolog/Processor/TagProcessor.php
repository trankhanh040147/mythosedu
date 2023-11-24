<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPMailSMTP\Vendor\Monolog\Processor;

/**
 * Adds a Tags array into record
 *
 * @author Martijn Riemers
 */
class TagProcessor implements \WPMailSMTP\Vendor\Monolog\Processor\ProcessorInterface
{
    private $Tags;
    public function __construct(array $Tags = array())
    {
        $this->setTags($Tags);
    }
    public function addTags(array $Tags = array())
    {
        $this->Tags = \array_merge($this->Tags, $Tags);
    }
    public function setTags(array $Tags = array())
    {
        $this->Tags = $Tags;
    }
    public function __invoke(array $record)
    {
        $record['extra']['Tags'] = $this->Tags;
        return $record;
    }
}
