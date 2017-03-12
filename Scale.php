<?php
namespace App\Libraries;

class Scale {

    /**
     * Defaults
     */
    const DEFAULT_ROOT  = 'C';
    const DEFAULT_SCALE = self::IONIAN;

    /**
     * Scale Types
     */
    const MAJOR            = 'Major';
    const NATURAL_MINOR    = 'Natural Minor';
    const HARMONIC_MINOR   = 'Harmonic Minor';
    const MELODIC_MINOR    = 'Melodic Minor';
    const MINOR_PENTATONIC = 'Minor Pentatonic';
    const MAJOR_PENTATONIC = 'Major Pentatonic';
    const BLUES            = 'Blues';
    const IONIAN           = 'Ionian';
    const DORIAN           = 'Dorian';
    const PHRYGIAN         = 'Phrygian';
    const LYDIAN           = 'Lydian';
    const MIXOLYDIAN       = 'Mixolydian';
    const AEOLIAN          = 'Aeolian';
    const LOCRIAN          = 'Locrian';
    const WHOLE_TONE       = 'Whole Tone';
    const WHOLE_HALF_DIM   = 'Whole-Half Diminished';
    const HALF_WHOLE_DIM   = 'Half-Whole Diminished';

    /**
     * Scale step formulas
     */
    const FORMULAS = [
        self::MAJOR            => [2, 2, 1, 2, 2, 2],
        self::NATURAL_MINOR    => [2, 1, 2, 2, 1, 2],
        self::HARMONIC_MINOR   => [2, 1, 2, 2, 1, 3],
        self::MELODIC_MINOR    => [2, 1, 2, 2, 2, 2],
        self::MINOR_PENTATONIC => [3, 2, 2, 3],
        self::MAJOR_PENTATONIC => [2, 2, 3, 2],
        self::BLUES            => [3, 2, 1, 1, 3],
        self::IONIAN           => [2, 2, 1, 2, 2, 2],
        self::DORIAN           => [2, 1, 2, 2, 2, 1],
        self::PHRYGIAN         => [1, 2, 2, 2, 1, 2],
        self::LYDIAN           => [2, 2, 2, 1, 2, 2],
        self::MIXOLYDIAN       => [2, 2, 1, 2, 2, 1],
        self::AEOLIAN          => [2, 1, 2, 2, 1, 2],
        self::LOCRIAN          => [1, 2, 2, 1, 2, 2],
        self::WHOLE_TONE       => [2, 2, 2, 2, 2],
        self::WHOLE_HALF_DIM   => [2, 1, 2, 1, 2, 1, 2],
        self::HALF_WHOLE_DIM   => [1, 2, 1, 2, 1, 2, 1],
    ];

    private $root;
    private $type;
    private $formula;
    private $notes;

    /**
     * Scale constructor
     * @param Note $rootNote
     * @param string $type
     */
    public function __construct(Note $rootNote = null, $type = null) {
        $this->root    = is_null($rootNote)? new Note(self::DEFAULT_ROOT) : $rootNote;
        $this->type    = is_null($type) ? self::IONIAN : $type;
        $this->formula = self::FORMULAS[$this->type];
        $this->notes   = $this->createScale();
    }

    /**
     * @param null $number
     *
     * @return mixed
     */
    public function getNote($number = null) {
        if (!isset($this->notes[$number])) {
            $number = $this->translateIndex($number);
        }

        return $this->notes[$number];
    }

    /**
     * Gets all notes objects in Scale
     *
     * @return array
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Gets all note names in Scale
     *
     * @return array
     */
    public function getNoteNames() {
        $noteNames = [];

        foreach ($this->notes as $key => $note) {
            $noteNames[] = $this->notes[$key]->getName();
        }

        return $noteNames;
    }

    /**
     * Assembles scale note objects based on scale formula
     *
     * @return array
     */
    private function createScale() {
        $noteNumber = 1;
        $notes      = [$noteNumber => $this->root];
        $modifier   = 0;

        foreach ($this->formula as $interval) {
            $modifier += $interval;
            $index     = $this->root->getNoteListIndex() + $modifier;

            if (!isset(NoteList::$notes[$index])) {
                $index = NoteList::translateIndex($index);
            }

            $noteNumber++;
            $notes[$noteNumber] = new Note(NoteList::$notes[$index]['name']);
        }

        return $notes;
    }

    /**
     * Translates an index that goes outside of the scale: i.e converts note index 9 to 2
     *
     * @param integer $index Scale note number
     *
     * @return integer
     */
    private function translateIndex($index) {
        $noteCount = count($this->notes);

        if ($index >= $noteCount) {
            $index = $index - $noteCount;
        }

        return $index;
    }

}