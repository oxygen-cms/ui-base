# Oxygen - UI Base

This repository contains view files and rendering code for Oxygen.

For more information visit the [Core](https://github.com/oxygen-cms/core) repository.

## What is the difference between `ui-base` and `ui-theme`?

`ui-base` contains code and view files (`.blade.php`) and basically sets the structure for the user interface (with HTML).

`ui-theme` adds CSS and JS (compiled from SCSS and CoffeeScript respectively) which gives the core view files a nice theme.

The distinction has been made so that one can either:

- switch 'theme', changing the look of Oxygen using only CSS and JavaScript
- change the UI altogether, overriding all the HTML, CSS and JavaScript