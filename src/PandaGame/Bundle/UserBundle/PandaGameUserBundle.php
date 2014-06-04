<?php

namespace PandaGame\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PandaGameUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
