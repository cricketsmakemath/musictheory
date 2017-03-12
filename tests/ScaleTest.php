<?php
namespace Tests\Unit;

use App\Libraries\Note;
use App\Libraries\Scale;
use Tests\TestCase;

class ScaleTest extends TestCase {

    /**
     * Tests that a scale object is created correctly given a root Note object and scale type
     */
    public function testCreateScale() {
        $e         = new Note('E');
        $eMajScale = new Scale($e, Scale::MAJOR);

        $this->assertEquals(new Note('E'), $eMajScale->getRoot());
        $this->assertEquals(Scale::MAJOR, $eMajScale->getType());
        $this->assertEquals(Scale::FORMULAS[Scale::MAJOR], $eMajScale->getFormula());
        $this->assertEquals([
            1 => new Note('E'),
            2 => new Note('F#/Gb'),
            3 => new Note('G#/Ab'),
            4 => new Note('A'),
            5 => new Note('B'),
            6 => new Note('C#/Db'),
            7 => new Note('D#/Eb'),
        ], $eMajScale->getNotes());
    }

    /**
     * Tests that a correct list of note names is returned from a scale object
     */
    public function testGetNoteNames() {
        $e         = new Note('E');
        $eMinScale = new Scale($e, Scale::AEOLIAN);
        $noteNames = $eMinScale->getNoteNames();

        $this->assertEquals(['E', 'F#/Gb', 'G', 'A', 'B', 'C', 'D'], $noteNames);
    }

    /**
     * Tests that note can be fetched by its number in the scale
     */
    public function testGetNote() {
        $e            = new Note('E');
        $eDorianScale = new Scale($e, Scale::DORIAN);
        $note         = $eDorianScale->getNote(3);

        $this->assertEquals(new Note('G'), $note);
    }

}