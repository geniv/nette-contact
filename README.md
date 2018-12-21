Nette contact
=============

Installation
------------
```sh
$ composer require geniv/nette-contact
```
or
```json
"geniv/nette-contact": "^1.0"
```

require:
```json
"php": ">=7.0",
"nette/nette": ">=2.4",
"geniv/nette-general-form": ">=1.0"
```

Include in application
----------------------
neon configure:
```neon
# contact form
contactForm:
#   autowired: true
#   formContainer: Contact\FormContainer
    events:
        - Contact\Events\EmailEvent
#        - Contact\Events\DibiEvent(%tablePrefix%)
        - ClearFormEvent
        - AjaxFlashMessageEvent
```
in case AjaxFlashMessageEvent is dependency: `"geniv/nette-flash-message": ">=1.0"`

neon configure extension:
```neon
extensions:
    contactForm: Contact\Bridges\Nette\Extension
```

usage:
```php
protected function createComponentContactForm(ContactForm $contactForm, IEmailEvent $emailEvent): ContactForm
{
    $contactForm->setTemplatePath(__DIR__ . '/templates/Contact/contactForm.latte');
    $emailEvent->setTemplatePath(__DIR__ . '/templates/Contact/email.latte');
    $emailEvent->getMessage()
        ->addTo('example@gmail.com');

    $contactForm->onSuccess[] = function (array $values) {
        $this->flashMessage('odeslano', 'success');
//            $this['flashMessage']->redraw();
    };
    $contactForm->onException[] = function (EventException $e) {
        $this->flashMessage($e->getMessage(), 'danger');
    };
    return $contactForm;
}
```

usage:
```latte
{control contactForm}
```
