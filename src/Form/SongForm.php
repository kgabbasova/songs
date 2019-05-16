<?php


namespace App\Form;


use App\Entity\Song;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SongForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('singer')
            ->add('genre', ChoiceType::class, [
                    'choices' => [
                        'Pop' => 'Pop',
                        'Alternative' => 'Alternative',
                        'Classical' => 'Classical',
                        'Country' => 'Country',
                        'Dance' => 'Dance',
                        'Electronic' => 'Electronic',
                        'Hip-Hop/Rap' => 'Hip-Hop/Rap',
                        'Indie Pop' => 'Indie Pop',
                        'Instrumental' => 'Instrumental',
                        'Jazz' => 'Jazz',
                        'Latin' => 'Latin',
                        'Opera' => 'Opera',
                        'R&B/Soul' => 'R&B/Soul',
                        'Reggae' => 'Reggae',
                        'Rock' => 'Rock',
                        'Vocal' => 'Vocal',
                        'None' => 'None'
                    ]]
            )
            ->add('file', FileType::class,['label' => 'Upload song']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Song::class]);
    }
}