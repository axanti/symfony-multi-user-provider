<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\LanguageField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureActions(Actions $actions): Actions
    {   
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
            ->disable(Action::DELETE);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            EmailField::new('email'),
            Field::new('password', 'Change password')
            ->onlyWhenCreating()
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'invalid_message' => 'Les 2 mots de passe ne correspondent pas.',
                'first_options' => ['label' => 'New password:'],
                'second_options' => ['label' => 'Repeat password:'],
                'first_name' => 'first_password',
                'second_name' => 'second_password',
            ]),
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('company')
            ->onlyOnForms(),
            TextField::new('address1')
            ->onlyOnForms(),
            TextField::new('address2')
            ->onlyOnForms(),
            TextField::new('postalCode')
            ->onlyOnForms(),
            TextField::new('state')
            ->onlyOnForms(),
            TextField::new('city')
            ->onlyOnForms(),
            CountryField::new('country')
            ->setFormTypeOptions(['preferred_choices' => ['CA']])
            ->onlyOnForms(),
            TextField::new('phoneNumber')
            ->onlyOnForms(),
            TextField::new('cellNumber')
            ->onlyOnForms(),
            TextField::new('faxNumber')
            ->onlyOnForms(),
            LanguageField::new('language')
            ->onlyOnForms()
            ->setFormTypeOptions(['preferred_choices' => ['fr']]),
            BooleanField::new('status'),
            BooleanField::new('isVerified'),
        ];
    }
}
