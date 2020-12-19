<?php

namespace App\Common\App\View;

use Symfony\Component\HttpFoundation\Response;

interface RenderableViewInterface
{
    public function render(): Response;
}