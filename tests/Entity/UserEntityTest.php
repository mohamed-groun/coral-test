<?php

namespace App\Tests\Entity;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEntityTest extends KernelTestCase
{
    private const  INVALID_EMAIL_VALUE = "grounmed@gmail";
    private const  VALID_EMAIL_VALUE = "grounmed@gmail.com";
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->validator = $kernel->getContainer()->get('validator');

    }

    public function testUserEntityisValid(): void
    {
        $user = new User();
        $user->setEmail(self::VALID_EMAIL_VALUE);

        $this->getValidationErrors($user, 0);
    }

    private function getValidationErrors(User $user,): ConstraintViolationList
    {
        $errors = $this->validator->validate($user);

        return $errors;
    }
}