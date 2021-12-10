<?php

namespace App\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class MakeComponent extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:component';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a twig component';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription(self::getCommandDescription())
            ->addArgument('name', InputArgument::REQUIRED, 'The name of your twig component (ie <fg=yellow>NotificationComponent</>)')
            ->addOption('live', null, InputOption::VALUE_NONE, 'Whether to create a live twig component (requires <fg=yellow>symfony/ux-live-component</>)')
        ;

        $inputConfig->setArgumentAsNonInteractive('name');
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $name = $input->getArgument('name');
        $live = $input->getOption('live');

        if ($live && !\class_exists(AsLiveComponent::class)) {
            throw new \RuntimeException('You must install symfony/ux-live-component to create a live component (composer require symfony/ux-live-component)');
        }

        $factory = $generator->createClassNameDetails(
            $name,
            'Twig\\Components',
            'Component'
        );

        $shortName = Str::asSnakeCase(Str::removeSuffix($factory->getShortName(), 'Component'));

        $generator->generateClass(
            $factory->getFullName(),
            \sprintf("%s/../Resources/skeleton/%s", __DIR__, $live ? 'LiveComponent.tpl.php' : 'Component.tpl.php'),
            [
                'live' => $live,
                'short_name' => $shortName,
            ]
        );
        $generator->generateTemplate(
            "components/{$shortName}.html.twig",
            \sprintf("%s/../Resources/skeleton/templates/%s", __DIR__, $live ? 'live_component.tpl.php' : 'component.tpl.php')
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        if ($input->getArgument('name')) {
            return;
        }

        $question = new Question($command->getDefinition()->getArgument('name')->getDescription());
        $question->setValidator([Validator::class, 'notBlank']);

        $name = $io->askQuestion($question);
        $live = $io->confirm('Make this a live component?', \class_exists(AsLiveComponent::class));

        $input->setArgument('name', $name);
        $input->setOption('live', $live);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }
}
