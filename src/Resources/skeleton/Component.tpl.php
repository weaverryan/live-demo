<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Symfony\UX\TwigComponent\ComponentInterface;

final class <?= $class_name ?> implements ComponentInterface
{
    public static function getComponentName(): string
    {
        return '<?= $short_name; ?>';
    }
}
