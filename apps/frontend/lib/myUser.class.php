<?php

class myUser extends ttUser
{
  protected $currentProject = null;

  protected $currentInputsUser = null;

  public function signIn($user, $remember = false, $con = null)
  {
    parent::signIn($user, $remember, $con);

    if ($this->getGuardUser()->getCurrentProjectId())
    {
      $this->switchProject($this->getGuardUser()->getCurrentProject());
    }
  }

  public function getCurrentProjectId()
  {
    return $this->getGuardUser()->getCurrentProjectId();
  }

  public function hasCurrentProject()
  {
    return $this->getCurrentProjectId();
  }

  public function getCurrentProject()
  {
    if (null === $this->currentProject && $this->getCurrentProjectId())
    {
      $this->currentProject = ProjectTable::getInstance()->find($this->getCurrentProjectId());
    }

    if (! $this->currentProject)
    {
      throw new sfException('Could not retrieve current project');
    }

    return $this->currentProject;
  }

  public function setCurrentProject(Project $project)
  {
    $this->currentProject = $project;
    $this->getGuardUser()->setCurrentProjectId($project->getId())->save();
    $this->clearCredentials();
    $credential = $project->getUserCredential($this->getGuardUser());

    if ($credential)
    {
      $this->addCredential($credential);
    }
  }

  public function switchProject(Project $project)
  {
    if ($this->getGuardUser()->hasProject($project))
    {
      $this->setCurrentProject($project);
      $this->resetCurrentInputsUser();

      return true;
    }

    $this->getGuardUser()->setCurrentProjectId(null)->save();

    return false;
  }

  public function getCurrentInputsUserId()
  {
    return $this->getAttribute('current_inputs_user_id', false);
  }

  public function setCurrentInputsUserId($userId)
  {
    return $this->setAttribute('current_inputs_user_id', $userId);
  }

  public function getCurrentInputsUser()
  {
    if (null === $this->currentInputsUser && $this->getCurrentInputsUserId())
    {
      $this->currentInputsUser = sfGuardUserTable::getInstance()->find($this->getCurrentInputsUserId());
    }

    if (! $this->currentInputsUser)
    {
      throw new sfException('Could not retrieve current inputs user');
    }

    return $this->currentInputsUser;
  }

  public function setCurrentInputsUser(sfGuardUser $user)
  {
    if ($this->getGuardUser()->getId() == $user->getId())
    {
      $this->resetCurrentInputsUser();
    }
    else
    {
      $this->setCurrentInputsUserId($user->getId());
      $this->currentInputsUser = $user;
    }

    return $this;
  }

  public function hasCurrentInputsUser()
  {
    return $this->getCurrentInputsUserId();
  }

  public function hasAssignment(Assignment $assignment)
  {
    if ($this->getCurrentInputsUserId())
    {
      return $assignment->getUserId() === $this->getCurrentInputsUserId();
    }

    return $this->getGuardUser()->hasAssignment($assignment);
  }

  protected function resetCurrentInputsUser()
  {
    $this->setCurrentInputsUserId(false);
    $this->currentInputsUser = null;
  }
}
