<?php

namespace App\Service;

use App\Entity\ApplicationSettings;
use App\Repository\ApplicationSettingsRepository;

class ApplicationSettingsService {

    /**
     * @var ApplicationSettingsRepository
     */
    private $repository;

    /**
     * @var ApplicationSettings
     */
    private $applicationSettings;

    /**
     * ApplicationSettingsService constructor.
     * @param ApplicationSettingsRepository $repository
     */
    public function __construct(ApplicationSettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the current application settings
     * @return ApplicationSettings|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getApplicationSettings ()
    {
        if ($this->applicationSettings === null) {
            $this->applicationSettings = $this->repository->findSettings ();
        }

        return $this->applicationSettings;
    }
}