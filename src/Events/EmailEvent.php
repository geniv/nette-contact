<?php declare(strict_types=1);

namespace Contact\Events;

use GeneralForm\EventException;
use GeneralForm\IEventContainer;
use Nette\Application\UI\ITemplateFactory;
use Nette\Localization\ITranslator;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Mail\SendException;
use Nette\SmartObject;


/**
 * Class EmailEvent
 *
 * @author  geniv
 * @package Contact\Events
 */
class EmailEvent implements IEmailEvent
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
     * @param IMailer          $mailer
     * @param ITranslator|null $translator
     */
    public function __construct(ITemplateFactory $templateFactory, IMailer $mailer, ITranslator $translator = null)
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
     * @throws EventException
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

        try {
            $this->mailer->send($this->message);
        } catch (SendException $e) {
            throw new EventException($e->getMessage());
        }
    }
}
