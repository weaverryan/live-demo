<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Symfony\UX\LiveComponent\LiveComponentInterface;

final class <?= $class_name ?> implements LiveComponentInterface
{
    public static function getComponentName(): string
    {
        return '<?= $short_name; ?>';
    }
}
