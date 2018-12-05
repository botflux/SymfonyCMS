<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * UniqueEntity("name")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="tags")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LearningSubject", mappedBy="tag")
     */
    private $learningSubjects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->learningSubjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addTag($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            $project->removeTag($this);
        }

        return $this;
    }

    /**
     * Returns the count of related projects
     * @return int
     */
    public function getProjectsCount () : int
    {
        return count($this->projects);
    }

    /**
     * @return Collection|LearningSubject[]
     */
    public function getLearningSubjects(): Collection
    {
        return $this->learningSubjects;
    }

    public function addLearningSubject(LearningSubject $learningSubject): self
    {
        if (!$this->learningSubjects->contains($learningSubject)) {
            $this->learningSubjects[] = $learningSubject;
            $learningSubject->setTag($this);
        }

        return $this;
    }

    public function removeLearningSubject(LearningSubject $learningSubject): self
    {
        if ($this->learningSubjects->contains($learningSubject)) {
            $this->learningSubjects->removeElement($learningSubject);
            // set the owning side to null (unless already changed)
            if ($learningSubject->getTag() === $this) {
                $learningSubject->setTag(null);
            }
        }

        return $this;
    }
}
