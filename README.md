YPD - **Y**pd **P**hp **D**ecorator
===
Ypd Php Decorator implements \"decorators/annotations and meta-programming\" in PHP, via doc comments.

## INSTALL
You can install the package with composer:
`composer require kyserbyte/ypd`

## USAGE
At the monent is implemented only the `@ypdJsonSerialize` decorator.
To _activate_ the decorator you have to implement the `JsonSerializable` interface in the class that you want to make _json serializable_ via the decorator. Then you have to add the `YPDJsonSerializer` trait to your class. This trait has an internal implementation of the method `jsonSerialize()` required by the `JsonSerializable` interface, so you need only to declare the `implements` statement in you class.
Now you are able to use the decorator inside a doc comment, in order to declare what properties you want to _expose_ to json. 
The decorator works for now only with the public properties of a class.

### jsonSerialize decorator
Inside a doc comment over your property, you need to declare the decorator with the syntax

```
/**
* @ypdJsonSerialize(name=XX,if=YY) 
*/
public $propName;
```
with the declaration you can pass 2 arguments to the decorator.

- **name**: specify a custom name for the property when exported to json
- **if**: a Function that resolve to boolean. You can use it to implement a conditional logic for export the property. The Function must be declared in the same class of the property or in a trait used by the class and must be public.

Take a look to [DemoJsonSerialize](demo/DemoJsonSerialize.php) class for more info about usage.