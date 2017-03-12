<?php
namespace App\Libraries;

use Mockery\Matcher\Not;

class Chord {

    const DEFAULT_ROOT = 'C';

    /**
     * Supported chord types
     */
    const MAJOR = 'maj';
    const MINOR = 'm';
    const SIX   = 6;
    const SIX_NINE = '6/9';
    const MAJOR_SEVEN = 'maj7';
    const MAJOR_NINE = 'maj9';
    const MINOR_SIX = 'm6';
    const MINOR_SEVEN = 'm7';
    const MINOR_NINE = 'm9';
    const DOMINANT_SEVENTH = '7';
    const DOMINANT_NINTH = '9';
    const DOMINANT_THIRTEENTH = '13';
    const DIMINISHED = 'dim';

    /**
     * Chord formulas
     */
    const FORMULAS = [
        self::MAJOR               => [1, 3, 5],
        self::MINOR               => [1, 'b3', 5],
        self::SIX                 => [1, 3, 5, 6],
        self::SIX_NINE            => [1, 3, 5, 6, 9],
        self::MAJOR_SEVEN         => [1, 3, 5, 7],
        self::MAJOR_NINE          => [1, 3, 5, 7, 9],
        self::MINOR_SIX           => [1, 'b3', 5, 6],
        self::MINOR_SEVEN         => [1, 'b3', 5, 'b7'],
        self::MINOR_NINE          => [1, 'b3', 5, 'b7', 9],
        self::DOMINANT_SEVENTH    => [1 , 3, 5, 'b7'],
        self::DOMINANT_NINTH      => [1 , 3, 5, 'b7', 9],
        self::DOMINANT_THIRTEENTH => [1 , 3, 5, 'b7', 9, 11, 13],
        self::DIMINISHED          => [1 , 'b3', 'b5'],
    ];

    private $root;
    private $type;
    private $formula;
    private $notes;

    /**
     * Chord constructor
     *
     * @param Note   $rootNote Root note object for chord
     * @param string $type     Chord type
     */
    public function __construct(Note $rootNote = null, $type = null) {
        $this->root    = is_null($rootNote)? new Note(self::DEFAULT_ROOT) : $rootNote;
        $this->type    = is_null($type) ? self::MAJOR : $type;
        $this->formula = self::FORMULAS[$this->type];
        $this->notes   = $this->createChord();
    }

    /**
     * Gets names of notes in chord
     */
    public function getNoteNames() {
        $noteNames = [];

        foreach ($this->notes as $key => $note) {
            $noteNames[] = $this->notes[$key]->getName();
        }

        return $noteNames;
    }

    /**
     * Assembles notes for chord based on formula
     */
    private function createChord() {
        $notes      = [];
        $majorScale = new Scale($this->root, Scale::MAJOR);

        foreach ($this->formula as $noteIndex) {
            if (is_int($noteIndex)) {
                $notes[] = $majorScale->getNote($noteIndex);
                continue;
            }

            $notes[] = $this->getModifiedNote($noteIndex, $majorScale, $notes);
        }

        unset($majorScale);

        return $notes;
    }

    /**
     * @param $step
     * @return int
     */
    private function calculateNoteModifier($step) {
        $modifier = 0;

        if (strpos($step, Note::FLAT) !== false) {
            $modifier = -1;
        }

        if (strpos($step, Note::SHARP) !== false) {
            $modifier = 1;
        }

        return $modifier;
    }

    /**
     * @param $noteIndex
     * @param Scale $majorScale
     * @param $notes
     * @return array
     */
    private function getModifiedNote($noteIndex, Scale $majorScale, $notes) {
        $modifier = $this->calculateNoteModifier($noteIndex);

        preg_match_all('!\d+!', $noteIndex, $matches);
        $noteIndexNumber = (int)$matches[0][0];
        $note = $majorScale->getNote($noteIndexNumber);

        return $note->modify($modifier);
    }

}