# Laravel UI Faces

Laravel-ui-faces is a simple package for wrapping [UI Faces API](https://uifaces.co/). 
It provides a fluent API for building request to UI Faces REST service and parse response.

## 1. Installation
For installing the package run the command

`composer require robertogallea/laravel-ui-faces`

## 2. Setup

The packages need a valid API key to be set in the `UI_FACES_API_KEY` variable inside your `.env` file.
Optionally, you can change the default API URL by setting the `UI_FACES_API_URL` variable

It registers the UIFacesServiceProvider using laravel autodiscovery, in addition, if you want to use UIFaces Facade, 
you need to register the following alias inside `app.php`

```
'aliases' => [
...
    'UIFaces' => robertogallea\UIFaces\Facades\UIFaces::class
]
```

## 3. Usage

UI Faces can be used in several ways:

- Using Facade:
```
import UIFaces;
...
UIFaces::limit(10)
    ->from_age(18)
    ->to_age(22)
    ->getFaces();
```

- Using IoC:
```
public function show(UIFaces $uifaces)
{
    $faces = $uifaces
        ->limit(10)
        ->from_age(18)
        ->to_age(22)
        ->getFaces();    
}
```

- Using Laravel Service Container:
```
import robertogallea\UIFaces\UIFaces;

...

    $faces = app(UIFaces::class)
        ->limit(10)
        ->from_age(18)
        ->to_age(22)
        ->getFaces();
```

UIFaces supports the following parameters:
- limit
- offset
- random
- from_age
- to_age

and the following parameter arrays;

- gender
- hairColor
- emotion

## 4. Issues, Questions and Pull Requests

You can report issues and ask questions in the [issues section](https://github.com/robertogallea/laravel-ui-faces/issues). Please start your issue with `ISSUE: ` and your question with `QUESTION: `

If you have a question, check the closed issues first.

To submit a Pull Request, please fork this repository, create a new branch and commit your new/updated code in there. Then open a Pull Request from your new branch. Refer to [this guide](https://help.github.com/articles/about-pull-requests/) for more info.
