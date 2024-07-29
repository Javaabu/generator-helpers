---
title: String Caser
sidebar_position: 2
---

The `StringCaser` class provides static methods to convert a given name to different cases.

```php
StringCaser::pluralCamel('form_field'); // returns "formFields"
```

## Available Methods

For all the methods, assume the input parameter is `'form_field'`

- **`camel`**: returns `'formInputField'`
- **`kebab`**: returns `'form-input-field'`
- **`snake`**: returns `'form_input_field'`
- **`studly`**: returns `'FormInputField'`
- **`title`**: returns `'Form Input Field'`
- **`lower`**: returns `'form input field'`
- **`pluralCamel`**: returns `'formInputFields'`
- **`pluralKebab`**: returns `'form-input-fields'`
- **`pluralSnake`**: returns `'form_input_fields'`
- **`pluralStudly`**: returns `'FormInputFields'`
- **`pluralTitle`**: returns `'Form Input Fields'`
- **`pluralLower`**: returns `'form input fields'`
- **`singularCamel`**: returns `'formInputField'`
- **`singularKebab`**: returns `'form-input-field'`
- **`singularSnake`**: returns `'form_input_field'`
- **`singularStudly`**: returns `'FormInputField'`
- **`singularTitle`**: returns `'Form Input Field'`
- **`singularLower`**: returns `'form input field'`
