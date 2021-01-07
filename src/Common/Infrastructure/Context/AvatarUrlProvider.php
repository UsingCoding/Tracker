<?php

namespace App\Common\Infrastructure\Context;

class AvatarUrlProvider
{
    private string $assetsRootUrl;
    private string $defaultAvatarUrl;

    public function __construct(string $assetsRootUrl, string $defaultAvatarUrl)
    {
        $this->assetsRootUrl = $assetsRootUrl;
        $this->defaultAvatarUrl = $defaultAvatarUrl;
    }

    public function getUrl(?string $userAvatarUrl): string
    {
        if ($userAvatarUrl === null)
        {
            return $this->defaultAvatarUrl;
        }

        return $this->assetsRootUrl . '/' . $userAvatarUrl;
    }
}