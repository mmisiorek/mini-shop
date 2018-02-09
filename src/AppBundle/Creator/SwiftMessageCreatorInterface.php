<?php

namespace AppBundle\Creator;

use AppBundle\Entity\Product;

interface SwiftMessageCreatorInterface
{
    /**
     * @param Product $product
     * @param string $receiverEmail
     * @return \Swift_Message
     */
    public function createProductAddedMail(Product $product, string $receiverEmail): \Swift_Message;
}