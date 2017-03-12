A set of PHP classes used for music theory generation. Currently supports Chords and Scales.

To create a note just pass the note name to a new Note object. For flat/sharp notes, either note is accepted.
```php
$c = new Note('C');
```

To create a scale, pass a Note object (the root note) and the scale type to a new Scale object
```php
$cMajorScale = new Scale($c, Scale::MAJOR)
``

To create a chord, pass a Note object (the root note) and the chord type to a new Chord object
```php
$cMajSevenChord = new Chord($c, Chord::MAJOR_SEVEN);
```