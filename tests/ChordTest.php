<?php

namespace Tests\Unit;

use App\Libraries\Chord;
use App\Libraries\Note;
use Tests\TestCase;

class ChordTest extends TestCase {

    /**
     * Tests that a chord object is created properly given a root and chord type
     */
    public function testCreateChord() {
        $c           = new Note('C');
        $cMajorChord = new Chord($c, Chord::MAJOR);

        $this->assertEquals(new Note('C'), $cMajorChord->getRoot());
        $this->assertEquals(Chord::MAJOR, $cMajorChord->getType());
        $this->assertEquals(Chord::FORMULAS[Chord::MAJOR], $cMajorChord->getFormula());
        $this->assertEquals([
            new Note('C'),
            new Note('E'),
            new Note('G'),
        ], $cMajorChord->getNotes());
    }

    /**
     * Tests that a list of correct note names can be retrieved from chord object
     */
    public function testGetNoteNames() {
        $c              = new Note('C');
        $cMajSevenChord = new Chord($c, Chord::MAJOR_SEVEN);
        $noteNames      = $cMajSevenChord->getNoteNames();

        $this->assertEquals(['C', 'E', 'G', 'B'], $noteNames);
    }

    /**
     * Tests that a chord with a 'b' modifier in formula is calculated correctly
     */
    public function testCreateChordWithFlat() {
        $c           = new Note('C');
        $cMinorChord = new Chord($c, Chord::MINOR);
        $noteNames = $cMinorChord->getNoteNames();

        $this->assertEquals(['C', 'D#/Eb', 'G'], $noteNames);
    }

    /**
     * Tests that when a formula has an index larger than major scale length, the octave is shifted and
     * the chord is calculated correctly
     */
    public function textCreateChordWithIndexOutsideOfScale() {
        $c         = new Note('C');
        $c13Chord  = new Chord($c, Chord::DOMINANT_THIRTEENTH);
        $noteNames = $c13Chord->getNoteNames();

        $this->assertEquals(['C', 'E', 'G', 'Bb', 'D', 'F', 'A'], $noteNames);
    }

}