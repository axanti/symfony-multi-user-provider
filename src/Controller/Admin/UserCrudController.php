<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    // We remove the possibility of creating/deleting a data directly in User, this would break the joins
    public function configureActions(Actions $actions): Actions
    {   
        return $actions
        ->disable(Action::NEW, Action::DELETE);
    }
 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->onlyOnIndex(),
            EmailField::new('email'),
            Field::new('password', 'Change password')
            ->onlyOnForms()
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'invalid_message' => 'Les 2 mots de passe ne correspondent pas.',
                'first_options' => ['label' => 'New password:'],
                'second_options' => ['label' => 'Repeat password:'],
                'first_name' => 'first_password',
                'second_name' => 'second_password',
            ]),
            BooleanField::new('isVerified')
            ->onlyOnIndex()
        ];
    }
}
