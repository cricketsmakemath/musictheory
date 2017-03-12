<?php
namespace App\Libraries;

class Note {

    const FLAT  = 'b';
    const SHARP = '#';

    private $name;
    private $noteListIndex;
    private $octaveZeroFreq;

    /**
     * Note constructor
     *
     * @param $noteName
     */
    public function __construct($noteName) {
        $this->name           = $noteName;
        $this->noteListIndex  = NoteList::getIndex($this->name);
        $this->octaveZeroFreq = NoteList::$notes[$this->noteListIndex]['octaveZeroFreq'];
    }

    /**
     * Gets note name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets NoteList index of note
     *
     * @return integer
     */
    public function getNoteListIndex() {
        return $this->noteListIndex;
    }

    /**
     * Gets the note's octave zero frequency
     *
     * @return float
     */
    public function getOctaveZeroFreq() {
        return $this->octaveZeroFreq;
    }

    /**
     * Modifies note: Moves it up or down in note list based on modifier
     *
     * @param int $modifier Modifier
     * 
     * @return $this
     */
    public function modify($modifier) {
        $index = $this->noteListIndex + $modifier;


        if (!isset(NoteList::$notes[$index])) {
            $index = NoteList::translateIndex($index);
        }

        $this->noteListIndex  = $index;
        $this->name           = NoteList::$notes[$index]['name'];
        $this->octaveZeroFreq = NoteList::$notes[$index]['octaveZeroFreq'];

        return $this;
    }

    /**
     * Gets frequency for note in a specified octave
     * 
     * @param integer $octave Octave number
     *
     * @return float
     */
    public function getFrequencyForOctave($octave) {
        $baseFrequency     = $this->getOctaveZeroFreq();
        $halfStepsFromNote = $octave * 12;
        $frequency         = $baseFrequency * pow(pow(2, 1/12), $halfStepsFromNote);
        
        return $frequency;
    }
    
}