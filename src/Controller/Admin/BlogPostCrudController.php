<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('excerpt'),
            TextEditorField::new('content'),
            TextField::new('author'),
            ChoiceField::new('status')->setChoices([
                'Draft' => 'draft',
                'Reviewed' => 'reviewed',
                'Rejected' => 'rejected',
                'Published' => 'published',
                'Archived' => 'archived',
            ]),
        ];
    }

}
