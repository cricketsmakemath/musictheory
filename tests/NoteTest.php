<?php
namespace Tests\Unit;

use App\Libraries\Note;
use Mockery\Matcher\Not;
use Tests\TestCase;

class NoteTest extends TestCase {

    /**
     * Tests that a Note object is created correctly given a note name
     */
    public function testCreateNote() {
        $a = new Note('A');

        $this->assertEquals('A', $a->getName());
        $this->assertEquals('27.5', $a->getOctaveZeroFreq());
    }

    /**
     * Tests that searching for note with a 'b' or '#' matches correctly based on 'accepts' array
     */
    public function testCreateNoteByAcceptsArray() {
        $bb = new Note('Bb');

        $this->assertEquals('A#/Bb', $bb->getName());
        $this->assertEquals('29.135', $bb->getOctaveZeroFreq());
    }

    /**
     * Tests that note is shifted up or down note list given a modifier number
     */
    public function testModify() {
        $g = new Note('G');
        $f = $g->modify(-2);

        $this->assertEquals('F', $f->getName());
    }

    /**
     * Tests that a note is flatted correctly
     */
    public function testFlat() {
        $f     = new Note('F');
        $fFlat = $f->flat();

        $this->assertEquals('E', $fFlat->getName());
    }

    /**
     * Tests that a note is sharped correctly
     */
    public function testSharp() {
        $e      = new Note('E');
        $eSharp = $e->sharp();

        $this->assertEquals('F', $eSharp->getName());
    }

    /**
     * Tests that frequency for a given octave is calculated correctly
     */
    public function testGetFrequencyForOctave() {
        $g        = new Note('G');
        $oct3Freq = round($g->getFrequencyForOctave(3), 3);

        $this->assertEquals(195.992, $oct3Freq);
    }

}