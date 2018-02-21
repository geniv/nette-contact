<?php declare(strict_types=1);

namespace Contact\Events;

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;


/**
 * Class ClearFormEvent
 *
 * @author  geniv
 * @package Contact\Events
 */
class ClearFormEvent implements IEvent
{
    use SmartObject;


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        $eventContainer->getForm()->setValues([], true);
    }
}
