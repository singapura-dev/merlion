<?php

namespace Merlion;

use LogicException;
use Merlion\Components\Layouts\Admin;

class AdminManager
{
    protected array $admins = [];

    protected string $currentAdminId = '';
    protected string $defaultAdminId = '';

    public function getAdmins(): array
    {
        return $this->admins;
    }

    public function setCurrentAdmin(Admin|string $id): void
    {
        if (is_object($id)) {
            $id = $id->getId();
        }
        if (empty($this->admins[$id])) {
            throw new LogicException("Admin with id $id not found");
        }
        $this->currentAdminId = $id;
    }

    public function registerAdmin(Admin $admin): Admin
    {
        $id = $admin->getId();

        if (!empty($this->admins[$id])) {
            throw new LogicException("Admin with id $id already exists");
        }
        $this->admins[$id] = $admin;
        $admin->boot();

        if (empty($this->defaultAdminId)) {
            $this->defaultAdminId = $id;
        }

        if ($admin->isDefault()) {
            $this->defaultAdminId = $id;
        }
        return $admin;
    }

    public function getAdmin(?string $id = null): Admin
    {
        if (empty($id)) {
            return $this->getCurrentOrDefaultAdmin();
        }

        if (empty($this->admins[$id])) {
            throw new LogicException("Admin with id $id not found");
        }

        return $this->admins[$id];
    }

    public function getCurrentOrDefaultAdmin(): Admin
    {
        $id = $this->currentAdminId ?: $this->defaultAdminId;
        if (empty($this->admins[$id])) {
            throw new LogicException("Admin with id $id not found");
        }
        return $this->admins[$id];
    }
}
