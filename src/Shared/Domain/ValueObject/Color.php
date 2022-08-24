<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class Color extends StringValueObject
{
    public const COLORS_KEYWORDS = [
        'aliceblue',
        'antiquewhite',
        'aqua',
        'aquamarine',
        'azure',
        'beige',
        'bisque',
        'black',
        'blanchedalmond',
        'blue',
        'blueviolet',
        'brown',
        'burlywood',
        'cadetblue',
        'chartreuse',
        'chocolate',
        'coral',
        'cornflowerblue',
        'cornsilk',
        'crimson',
        'cyan',
        'darkblue',
        'darkcyan',
        'darkgoldenrod',
        'darkgray',
        'darkgrey',
        'darkgreen',
        'darkkhaki',
        'darkmagenta',
        'darkolivegreen',
        'darkorange',
        'darkorchid',
        'darkred',
        'darksalmon',
        'darkseagreen',
        'darkslateblue',
        'darkslategray',
        'darkslategrey',
        'darkturquoise',
        'darkviolet',
        'deeppink',
        'deepskyblue',
        'dimgray',
        'dimgrey',
        'dodgerblue',
        'firebrick',
        'floralwhite',
        'forestgreen',
        'fuchsia',
        'gainsboro',
        'ghostwhite',
        'gold',
        'goldenrod',
        'gray',
        'grey',
        'green',
        'greenyellow',
        'honeydew',
        'hotpink',
        'indianred',
        'indigo',
        'ivory',
        'khaki',
        'lavender',
        'lavenderblush',
        'lawngreen',
        'lemonchiffon',
        'lightblue',
        'lightcoral',
        'lightcyan',
        'lightgoldenrodyellow',
        'lightgray',
        'lightgrey',
        'lightgreen',
        'lightpink',
        'lightsalmon',
        'lightseagreen',
        'lightskyblue',
        'lightslategray',
        'lightslategrey',
        'lightsteelblue',
        'lightyellow',
        'lime',
        'limegreen',
        'linen',
        'magenta',
        'maroon',
        'mediumaquamarine',
        'mediumblue',
        'mediumorchid',
        'mediumpurple',
        'mediumseagreen',
        'mediumslateblue',
        'mediumspringgreen',
        'mediumturquoise',
        'mediumvioletred',
        'midnightblue',
        'mintcream',
        'mistyrose',
        'moccasin',
        'navajowhite',
        'navy',
        'oldlace',
        'olive',
        'olivedrab',
        'orange',
        'orangered',
        'orchid',
        'palegoldenrod',
        'palegreen',
        'paleturquoise',
        'palevioletred',
        'papayawhip',
        'peachpuff',
        'peru',
        'pink',
        'plum',
        'powderblue',
        'purple',
        'rebeccapurple',
        'red',
        'rosybrown',
        'royalblue',
        'saddlebrown',
        'salmon',
        'sandybrown',
        'seagreen',
        'seashell',
        'sienna',
        'silver',
        'skyblue',
        'slateblue',
        'slategray',
        'slategrey',
        'snow',
        'springgreen',
        'steelblue',
        'tan',
        'teal',
        'thistle',
        'tomato',
        'turquoise',
        'violet',
        'wheat',
        'white',
        'whitesmoke',
        'yellow',
        'yellowgreen'
    ];

    public function __construct(protected string $value)
    {
        parent::__construct($value);

        $this->ensureIsColor($value);
    }

    private function ensureIsColor(string $value): void
    {
        if (
            $this->isColorAsKeyword($value)
            || $this->isColorAsHex($value)
            || $this->isColorAsRgb($value)
            || $this->isColorAsRgba($value)
        ) {
            return;
        }

        throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
    }

    private function isColorAsHex(string $value): bool
    {
        return $this->isColorAsLongHex($value) || $this->isColorAsShortHex($value);
    }

    private function isColorAsRgb(string $value): bool
    {
        preg_match(
            '/^(rgb)\(([01]?\d\d?|2[0-4]\d|25[0-5])(\W+)([01]?\d\d?|2[0-4]\d|25[0-5])\W+(([01]?\d\d?|2[0-4]\d|25[0-5])\))$/i',
            $value,
            $matches,
        );

        return count($matches) > 0;
    }

    private function isColorAsRgba(string $value): bool
    {
        preg_match(
            '/^(rgba)\(([01]?\d\d?|2[0-4]\d|25[0-5])\W+([01]?\d\d?|2[0-4]\d|25[0-5])\W+([01]?\d\d?|2[0-4]\d|25[0-5])\)?\W+([01](\.\d+)?)\)$/i',
            $value,
            $matches,
        );

        return count($matches) > 0;
    }

    private function isColorAsShortHex(string $value): bool
    {
        preg_match('/^#(\d|a|b|c|d|e|f){3}$/i', $value, $matches);

        return count($matches) > 0;
    }

    private function isColorAsLongHex(string $value): bool
    {
        preg_match('/^#(\d|a|b|c|d|e|f){6}$/i', $value, $matches);

        return count($matches) > 0;
    }

    private function isColorAsKeyword(string $value): bool
    {
        return in_array($value, self::COLORS_KEYWORDS);
    }
}
