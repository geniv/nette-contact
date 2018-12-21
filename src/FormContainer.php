<?php declare(strict_types=1);

namespace Contact;

use GeneralForm\IFormContainer;
use Nette\Application\UI\Form;
use Nette\SmartObject;


/**
 * Class FormContainer
 *
 * @author  geniv
 * @package Contact
 */
class FormContainer implements IFormContainer
{
    use SmartObject;


    /**
     * Get form.
     *
     * @param Form $form
     */
    public function getForm(Form $form)
    {
        $form->addText('subject', 'contact-form#subject')
            ->setRequired('contact-form#subject-required');
        $form->addText('email', 'contact-form#email')
            ->setRequired('contact-form#email-required')
            ->addRule(Form::EMAIL, 'contact-form#email-rule-email');
        //->setAttribute('autocomplete', 'off');
        $form->addText('name', 'contact-form#name')
            ->setRequired('contact-form#name-required');
        $form->addTextArea('message', 'contact-form#message')
            ->setRequired('contact-form#message-required');

        $form->addSubmit('submit', 'contact-form#submit');
        //$form->addProtection('Vypršel časový limit, odešlete formulář znovu');
    }
}
