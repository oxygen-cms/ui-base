Oxygen's **UI Base** package provides the HTML code for many core widgets/components within the Oxygen Core.
It contains numerous view files and implementations for the Renderers (`Oxygen\Core\Html\RendererInterface`) of the Oxygen Core.

## What's included
- View Files for Core Components
- Admin Layout File
- Oxygen Pagination Presenter

## What is the difference between `ui-base` and `ui-theme`?

`ui-base` contains code and view files (`.blade.php`) and basically sets the structure for the user interface (with HTML).

`ui-theme` adds CSS and JS (compiled from SCSS and CoffeeScript respectively) which gives the core view files a nice theme.

The distinction has been made so that one can either:

- switch 'theme', changing the look of Oxygen using only CSS and JavaScript
- change the UI altogether, overriding all the HTML, CSS and JavaScript