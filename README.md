# kirki-output

The CSS output module for Kirki.

TODO:

How the object will be instantiated:

```php
// Instantiate the object for our config.
$my_output = Kirki_Output::get_instance( 'my_config' );

// Add a field.
new Kirki_Output_Field( 'config_id', $field );

// Generate the CSS after all fields have been added.
$my_output->generate_css();

// Get the final CSS.
$css = $my_output->get_css();
```
