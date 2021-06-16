<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\PostHydrate;
use Symfony\UX\LiveComponent\LiveComponentInterface;

/**
 * An input field with a custom hydrator.
 *
 * Uses the <code>hydrateWith</code> & <code>dehydrateWith</code> options
 * to handle a custom <code>Prefixer</code> class that is a <code>LiveProp</code>.
 *
 * Try typing "invalid" into the text box to see a security
 * check that changes the value - via the <code>PreHydrate</code> hook -
 * before the component is re-rendered.
 *
 * This also has a button where you can trigger a re-render manually.
 */
final class ComplexInputComponent implements LiveComponentInterface
{
    /**
     * @LiveProp(writable=true)
     */
    public string $value = '';

    /**
     * @LiveProp(hydrateWith="hydratePrefixer()", dehydrateWith="dehydratePrefixer")
     */
    public Prefixer $prefixer;

    /**
     * @LiveProp
     */
    public \DateTime $firstRenderedAt;

    public function mount(string $prefix): void
    {
        $this->prefixer = new Prefixer($prefix);
        $this->firstRenderedAt = new \DateTime();
    }

    /**
     * Used as a sanity/security check.
     *
     * If you type "invalid" into the input, we change that to "valid".
     *
     * A more realistic example would be if you had a modifiable
     * property, but for security reasons, the user should only be
     * allowed to change to a subset of values (and you want to even
     * prevent the component from rendering with an invalid value).
     *
     * @PostHydrate()
     */
    public function postHydrate(): void
    {
        if ('invalid' === $this->value) {
            $this->value = 'valid';
        }
    }

    /**
     * Used in the template!
     */
    public function prefixedValue(): string
    {
        return ($this->prefixer)($this->value);
    }

    public function hydratePrefixer(string $prefix): Prefixer
    {
        return new Prefixer($prefix);
    }

    public function dehydratePrefixer(): string
    {
        return $this->prefixer->prefix();
    }

    public static function getComponentName(): string
    {
        return 'complex_input';
    }
}
