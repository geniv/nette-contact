<?php declare(strict_types=1);

namespace Contact;

use GeneralForm\EventContainer;
use GeneralForm\IEventContainer;
use GeneralForm\IFormContainer;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Nette\Application\UI\Control;


/**
 * Class ContactForm
 *
 * @author  geniv
 * @package Contact
 */
class ContactForm extends Control
{
    /** @var string template path */
    private $templatePath;
    /** @var ITranslator class */
    private $translator;
    /** @var callback method */
    public $onSuccess, $onException;
    /** @var IFormContainer */
    private $formContainer;
    /** @var IEventContainer */
    private $eventContainer;


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

        $this->eventContainer = new EventContainer($this, $events);
        $this->translator = $translator;
        $this->formContainer = $formContainer;

        $this->templatePath = __DIR__ . '/ContactForm.latte';   // set path
    }


    /**
     * Set template path.
     *
     * @param string $path
     * @return ContactForm
     */
    public function setTemplatePath(string $path): self
    {
        $this->templatePath = $path;
        return $this;
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

        $form->onSuccess[] = function (Form $form, array $values) {
            try {
                $this->eventContainer->setValues($values);
                $this->eventContainer->notify();

                $this->onSuccess($values);
            } catch (ContactException $e) {
                $this->onException($e);
            }
        };
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
