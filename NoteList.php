<?php
namespace App\Libraries;

class NoteList {

    /**
     * @param $noteName
     * @return mixed
     * 
     * @throws \Exception
     */
    public static function getIndex($noteName) {
        foreach (self::$notes as $key => $note) {
            if ($note['name'] === $noteName) {
                return $key;
            }

            if (isset($note['accepts']) && in_array($noteName, $note['accepts'])) {
                return $key;
            }
        }

        throw new \Exception($noteName . ' is not a valid note name');
    }

    /**
     * @param $index
     * @return mixed
     */
    public static function translateIndex($index) {
        $totalNotes    = count(self::$notes);
        $modifiedIndex = $index - $totalNotes;

        if (isset(self::$notes[$modifiedIndex])) {
            return $modifiedIndex;
        }

        return self::translateIndex($modifiedIndex);
    }

    /**
     * @return array
     */
    public static function getAll() {
        return self::$notes;
    }

    /**
     * @return array
     */
    public static $notes = [
        [
            'name'          => 'A',
            'accepts'       => ['A'],
            'octaveZeroFreq' => 27.5,
        ],
        [
            'name'           => 'A#/Bb',
            'accepts'        => ['A#', 'Bb'],
            'octaveZeroFreq' => 29.135,
        ],
        [
            'name'           => 'B',
            'accepts'        => ['B'],
            'octaveZeroFreq' => 30.868,
        ],
        [
            'name'           => 'C',
            'accepts'        => ['C'],
            'octaveZeroFreq' => 16.351,
        ],
        [
            'name'           => 'C#/Db',
            'accepts'        => ['C#', 'Db'],
            'octaveZeroFreq' => 17.324,
        ],
        [
            'name'           => 'D',
            'accepts'        => ['D'],
            'octaveZeroFreq' => 18.354,
        ],
        [
            'name'           => 'D#/Eb',
            'accepts'        => ['D#', 'Eb'],
            'octaveZeroFreq' => 19.445,
        ],
        [
            'name'           => 'E',
            'accepts'        => ['E'],
            'octaveZeroFreq' => 20.601,
        ],
        [
            'name'           => 'F',
            'accepts'        => ['F'],
            'octaveZeroFreq' => 21.827,
        ],
        [
            'name'           => 'F#/Gb',
            'accepts'        => ['F#', 'Gb'],
            'octaveZeroFreq' => 23.124,
        ],
        [
            'name'           => 'G',
            'accepts'        => ['G'],
            'octaveZeroFreq' => 24.499,
        ],
        [
            'name'           => 'G#/Ab',
            'accepts'        => ['G#', 'Ab'],
            'octaveZeroFreq' => 25.956,
        ],
    ];

}