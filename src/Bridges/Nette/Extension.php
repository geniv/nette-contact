<?php declare(strict_types=1);

namespace Contact\Bridges\Nette;

use Contact\ContactForm;
use Contact\Events\EmailEvent;
use Contact\FormContainer;
use Nette\DI\CompilerExtension;


/**
 * Class Extension
 *
 * @author  geniv
 * @package Contact\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array default values */
    private $defaults = [
        'autowired'     => null,
        'formContainer' => FormContainer::class,
        'events'        => [],
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        // define form container
        $formContainer = $builder->addDefinition($this->prefix('form'))
            ->setFactory($config['formContainer']);

        // define events container
        $events = [];
        foreach ($config['events'] as $event) {
            $events[] = $builder->addDefinition($this->prefix(md5($event)))->setFactory($event);
        }

        // define form
        $builder->addDefinition($this->prefix('default'))
            ->setFactory(ContactForm::class, [$formContainer, $events]);

        // if define autowired then set value
        if (isset($config['autowired'])) {
            $builder->getDefinition($this->prefix('default'))
                ->setAutowired($config['autowired']);

            $builder->getDefinition($this->prefix('form'))
                ->setAutowired($config['autowired']);
        }
    }
}
