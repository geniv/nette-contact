<?php declare(strict_types=1);

namespace Contact\Events;

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;


/**
 * Class DibiEvent
 *
 * @author  geniv
 * @package Contact\Events
 */
class DibiEvent implements IEvent
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
        // TODO: Implement update() method.
        //Insert to dibi database... If will be...
    }
}
