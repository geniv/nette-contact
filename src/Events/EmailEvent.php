<?php declare(strict_types=1);

namespace Contact\Events;

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use GeneralForm\ITemplatePath;
use Nette\Application\UI\ITemplateFactory;
use Nette\Localization\ITranslator;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\SmartObject;


/**
 * Class EmailEvent
 *
 * @author  geniv
 * @package Contact\Events
 */
class EmailEvent implements IEvent, ITemplatePath
{
    use SmartObject;

    /** @var ITemplateFactory */
    private $templateFactory;
    /** @var ITranslator */
    private $translator;
    /** @var IMailer */
    private $mailer;
    /** @var Message */
    private $message;
    /** @var string */
    private $templatePath;


    /**
     * EmailEvent constructor.
     *
     * @param ITemplateFactory $templateFactory
     * @param ITranslator|null $translator
     * @param IMailer          $mailer
     */
    public function __construct(ITemplateFactory $templateFactory, ITranslator $translator = null, IMailer $mailer)
    {
        $this->templateFactory = $templateFactory;
        $this->translator = $translator;
        $this->mailer = $mailer;

        $this->message = new Message;

        $this->templatePath = __DIR__ . '/EmailEvent.latte';   // set path
    }


    /**
     * Get message.
     *
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
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
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        // latte
        $template = $this->templateFactory->createTemplate()
            ->setTranslator($this->translator)
            ->setFile($this->templatePath);
        $template->values = $values;

        // message
        $this->message->setFrom($values['email'], $values['name'])
            ->setSubject($values['subject'])
            ->setHtmlBody($template);

        $this->mailer->send($this->message);
    }
}
