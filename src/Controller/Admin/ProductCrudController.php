<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('illustration')
                ->setBasePath('uploads/products/') // For reading the file inside public/ directory
                ->setUploadDir('public/uploads/products/') // Full realtive path for saving the file
                ->setUploadedFileNamePattern('[randomhash].[extension]') // For encrypting the file's name
                ->setRequired(false), // false because when editing, the field seems to be empty ! (Easyadmin issue)
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            AssociationField::new('category'),
        ];
    }

}
