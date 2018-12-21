<?php declare(strict_types=1);

namespace Contact\Events;

use GeneralForm\IEvent;
use GeneralForm\ITemplatePath;
use Nette\Mail\Message;


/**
 * Interface IEmailEvent
 *
 * @author  geniv
 * @package Contact\Events
 */
interface IEmailEvent extends IEvent, ITemplatePath
{

    /**
     * Get message.
     *
     * @return Message
     */
    public function getMessage(): Message;
}
