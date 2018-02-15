<?php declare(strict_types=1);

namespace Contact\Bridges\Nette;

use Contact\ContactForm;
use Contact\Events\EmailEvent;
use Contact\FormContainer;
use GeneralForm\GeneralForm;
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
        'autowired'     => true,
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

        $formContainer = GeneralForm::getFormContainerDefinition($this);
        $events = GeneralForm::getEventContainerDefinition($this);

        // define form
        $builder->addDefinition($this->prefix('default'))
            ->setFactory(ContactForm::class, [$formContainer, $events])
            ->setAutowired($config['autowired']);
    }
}
