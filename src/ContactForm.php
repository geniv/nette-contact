<?php declare(strict_types=1);

namespace Contact;

use GeneralForm\EventContainer;
use GeneralForm\IEventContainer;
use GeneralForm\IFormContainer;
use GeneralForm\ITemplatePath;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Nette\Application\UI\Control;


/**
 * Class ContactForm
 *
 * @author  geniv
 * @package Contact
 */
class ContactForm extends Control implements ITemplatePath
{
    /** @var IFormContainer */
    private $formContainer;
    /** @var IEventContainer */
    private $eventContainer;
    /** @var ITranslator */
    private $translator;
    /** @var string */
    private $templatePath;
    /** @var callback */
    public $onSuccess, $onException;


    /**
     * ContactForm constructor.
     *
     * @param array            $events
     * @param ITranslator|null $translator
     * @param IFormContainer   $formContainer
     */
    public function __construct(IFormContainer $formContainer, array $events, ITranslator $translator = null)
    {
        parent::__construct();

        $this->formContainer = $formContainer;
        $this->eventContainer = EventContainer::factory($this, $events);
        $this->translator = $translator;

        $this->templatePath = __DIR__ . '/ContactForm.latte';   // set path
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }


    /**
     * Create component form.
     *
     * @param string $name
     * @return Form
     */
    protected function createComponentForm(string $name): Form
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $this->formContainer->getForm($form);

        $form->onSuccess[] = $this->eventContainer;
        return $form;
    }


    /**
     * Render default.
     */
    public function render()
    {
        $template = $this->getTemplate();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
