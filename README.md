A set of PHP classes used for music theory generation. Currently supports Chords and Scales.

To create a note just pass the note name to a new Note object. For flat/sharp notes, either note is accepted.
`$c = new Note('C');`

To create a scale, pass a Note object (the root note) and the scale type to a new Scale object
`$cMajorScale = new Scale($c, Scale::MAJOR)`

To create a chord, pass a Note object (the root note) and the chord type to a new Chord object
`$cMajSevenChord = new Chord($c, Chord::MAJOR_SEVEN);`