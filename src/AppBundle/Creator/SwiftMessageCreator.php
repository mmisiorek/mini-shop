<?php

namespace AppBundle\Creator;


use AppBundle\Entity\Product;

class SwiftMessageCreator implements SwiftMessageCreatorInterface
{
    /**
     * @var string
     */
    private $defaultSender;

    public function __construct($defaultSender)
    {
        $this->defaultSender = $defaultSender;
    }

    public function createProductAddedMail(Product $product, string $receiverEmail): \Swift_Message
    {
        return (new \Swift_Message(sprintf('A product %s has been added.', $product->getName())))
            ->setFrom($this->defaultSender)
            ->setTo($receiverEmail)
            ->setBody(
                sprintf('A product %s has been added with description:\n\n %s', $product->getName(), $product->getDescription()),
                'text/plain'
            );
    }
}