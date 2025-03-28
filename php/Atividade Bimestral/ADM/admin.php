<?php
class Admin
{
    private $user;
    private $isAdmin = false;

    public function __construct($user)
    {
        $this->user = $user;
        $this->isAdmin = ($this->user === 'admin');
    }

    public function getUser()
    {
        return $this->user;
    }
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function verificarAdm()
    {
        if (!$this->isAdmin()) {
            header("Location: ..\index.php");
            exit();
        }

    }
}
?>