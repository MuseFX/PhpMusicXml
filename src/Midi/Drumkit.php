<?php

namespace MuseFx\PhpMusicXml\Midi;

class Drumkit
{
    public const ACOUSTIC_BASS_DRUM = 36;
    public const BASS_DRUM1 = 37;
    public const SIDE_STICK = 38;
    public const ACOUSTIC_SNARE = 39;
    public const ELECTRIC_SNARE = 41;
    public const LOW_FLOOR_TOM = 42;
    public const CLOSED_HI_HAT = 43;
    public const HIGH_FLOOR_TOM = 44;
    public const PEDAL_HI_HAT = 45;
    public const LOW_TOM = 46;
    public const OPEN_HI_HAT = 47;
    public const LOW_MID_TOM = 48;
    public const HI_MID_TOM = 49;
    public const CRASH_CYMBAL1 = 50;
    public const HIGH_TOM = 51;
    public const RIDE_CYMBAL1 = 52;
    public const CHINESE_CYMBAL = 53;
    public const RIDE_BELL = 54;
    public const TAMBOURINE = 55;
    public const SPLASH_CYMBAL = 56;
    public const COWBELL = 57;
    public const CRASH_CYMBAL2 = 58;
    public const RIDE_CYMBAL2 = 60;

    /**
     * @return array
     */
    public static function getInstruments(): array
    {
        return [
            self::ACOUSTIC_BASS_DRUM => (object) [
                'midiId' => 36,
                'name' => 'Acoustic Bass Drum',
                'id' => 'ACOUSTIC-BASS-DRUM',
                'constantName' => 'ACOUSTIC_BASS_DRUM',
                'displayStep' => 'E',
                'displayOctave' => 4,
            ],
            self::BASS_DRUM1 => (object) [
                'midiId' => 37,
                'name' => 'Bass Drum 1',
                'id' => 'BASS-DRUM1',
                'constantName' => 'BASS_DRUM1',
                'displayStep' => 'F',
                'displayOctave' => 4,
            ],
            self::SIDE_STICK => (object) [
                'midiId' => 38,
                'name' => 'Side Stick',
                'id' => 'SIDE-STICK',
                'constantName' => 'SIDE_STICK',
                'displayStep' => 'C',
                'displayOctave' => 5,
                'notehead' => 'slashed',
            ],
            self::ACOUSTIC_SNARE => (object) [
                'midiId' => 39,
                'name' => 'Acoustic Snare',
                'id' => 'ACOUSTIC-SNARE',
                'constantName' => 'ACOUSTIC_SNARE',
                'displayStep' => 'C',
                'displayOctave' => 5,
            ],
            self::ELECTRIC_SNARE => (object) [
                'midiId' => 41,
                'name' => 'Electric Snare',
                'id' => 'ELECTRIC-SNARE',
                'constantName' => 'ELECTRIC_SNARE',
                'displayStep' => 'C',
                'displayOctave' => 5,
            ],
            self::LOW_FLOOR_TOM => (object) [
                'midiId' => 42,
                'name' => 'Low Floor Tom',
                'id' => 'LOW-FLOOR-TOM',
                'constantName' => 'LOW_FLOOR_TOM',
                'displayStep' => 'G',
                'displayOctave' => 4,
            ],
            self::CLOSED_HI_HAT => (object) [
                'midiId' => 43,
                'name' => 'Closed Hi-Hat',
                'id' => 'CLOSED-HI-HAT',
                'constantName' => 'CLOSED_HI_HAT',
                'displayStep' => 'G',
                'displayOctave' => 5,
                'notehead' => 'x',
            ],
            self::HIGH_FLOOR_TOM => (object) [
                'midiId' => 44,
                'name' => 'High Floor Tom',
                'id' => 'HIGH-FLOOR-TOM',
                'constantName' => 'HIGH_FLOOR_TOM',
                'displayStep' => 'A',
                'displayOctave' => 4,
            ],
            self::PEDAL_HI_HAT => (object) [
                'midiId' => 45,
                'name' => 'Pedal Hi-Hat',
                'id' => 'PEDAL-HI-HAT',
                'constantName' => 'PEDAL_HI_HAT',
                'displayStep' => 'D',
                'displayOctave' => 4,
                'notehead' => 'x',
            ],
            self::LOW_TOM => (object) [
                'midiId' => 46,
                'name' => 'Low Tom',
                'id' => 'LOW-TOM',
                'constantName' => 'LOW_TOM',
                'displayStep' => 'B',
                'displayOctave' => 4,
            ],
            self::OPEN_HI_HAT => (object) [
                'midiId' => 47,
                'name' => 'Open Hi-Hat',
                'id' => 'OPEN-HI-HAT',
                'constantName' => 'OPEN_HI_HAT',
                'displayStep' => 'G',
                'displayOctave' => 5,
                'notehead' => 'x',
            ],
            self::LOW_MID_TOM => (object) [
                'midiId' => 48,
                'name' => 'Low-Mid Tom',
                'id' => 'LOW-MID-TOM',
                'constantName' => 'LOW_MID_TOM',
                'displayStep' => 'D',
                'displayOctave' => 5,
            ],
            self::HI_MID_TOM => (object) [
                'midiId' => 49,
                'name' => 'Hi-Mid Tom',
                'id' => 'HI-MID-TOM',
                'constantName' => 'HI_MID_TOM',
                'displayStep' => 'E',
                'displayOctave' => 5,
            ],
            self::CRASH_CYMBAL1 => (object) [
                'midiId' => 50,
                'name' => 'Crash Cymbal 1',
                'id' => 'CRASH-CYMBAL1',
                'constantName' => 'CRASH_CYMBAL1',
                'displayStep' => 'A',
                'displayOctave' => 5,
                'notehead' => 'x',
            ],
            self::HIGH_TOM => (object) [
                'midiId' => 51,
                'name' => 'High Tom',
                'id' => 'HIGH-TOM',
                'constantName' => 'HIGH_TOM',
                'displayStep' => 'F',
                'displayOctave' => 5,
            ],
            self::RIDE_CYMBAL1 => (object) [
                'midiId' => 52,
                'name' => 'Ride Cymbal 1',
                'id' => 'RIDE-CYMBAL1',
                'constantName' => 'RIDE_CYMBAL1',
                'displayStep' => 'F',
                'displayOctave' => 5,
                'notehead' => 'x',
            ],
            self::CHINESE_CYMBAL => (object) [
                'midiId' => 53,
                'name' => 'Chinese Cymbal',
                'id' => 'CHINESE-CYMBAL',
                'constantName' => 'CHINESE_CYMBAL',
                'displayStep' => 'C',
                'displayOctave' => 6,
                'notehead' => 'x',
            ],
            self::RIDE_BELL => (object) [
                'midiId' => 54,
                'name' => 'Ride Bell',
                'id' => 'RIDE-BELL',
                'constantName' => 'RIDE_BELL',
                'displayStep' => 'F',
                'displayOctave' => 5,
                'notehead' => 'diamond',
            ],
            self::TAMBOURINE => (object) [
                'midiId' => 55,
                'name' => 'Tambourine',
                'id' => 'TAMBOURINE',
                'constantName' => 'TAMBOURINE',
                'displayStep' => 'E',
                'displayOctave' => 5,
                'notehead' => 'diamond',
            ],
            self::SPLASH_CYMBAL => (object) [
                'midiId' => 56,
                'name' => 'Splash Cymbal',
                'id' => 'SPLASH-CYMBAL',
                'constantName' => 'SPLASH_CYMBAL',
                'displayStep' => 'D',
                'displayOctave' => 6,
                'notehead' => 'x',
            ],
            self::COWBELL => (object) [
                'midiId' => 57,
                'name' => 'Cowbell',
                'id' => 'COWBELL',
                'constantName' => 'COWBELL',
                'displayStep' => 'E',
                'displayOctave' => 5,
                'notehead' => 'inverted triangle',
            ],
            self::CRASH_CYMBAL2 => (object) [
                'midiId' => 58,
                'name' => 'Crash Cymbal 2',
                'id' => 'CRASH-CYMBAL2',
                'constantName' => 'CRASH_CYMBAL2',
                'displayStep' => 'B',
                'displayOctave' => 5,
                'notehead' => 'x',
            ],
            self::RIDE_CYMBAL2 => (object) [
                'midiId' => 60,
                'name' => 'Ride Cymbal 2',
                'id' => 'RIDE-CYMBAL2',
                'constantName' => 'RIDE_CYMBAL2',
                'displayStep' => 'D',
                'displayOctave' => 5,
                'notehead' => 'x',
            ],
        ];
    }

    /**
     * @param mixed $instrumentId
     *
     * @return object
     */
    public static function getInstrument($instrumentId): object
    {
        $instrument = self::getInstruments()[$instrumentId] ?? null;
        if (empty($instrument)) {
            throw new InstrumentNotFoundException('Music instrument `' . $instrumentId . '` not found.');
        }

        return $instrument;
    }
}
