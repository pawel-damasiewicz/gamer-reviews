<?php

namespace App\Component;


interface VerifiableUserInterface
{
    public function getId(): ?int;
    public function getEmail(): ?string;
    public function setIsVerified(bool $isVerified): self;
}