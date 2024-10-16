<?php

namespace MuseFx\PhpMusicXml\Midi;

use MuseFx\PhpMusicXml\Exceptions\InstrumentNotFoundException;

final class Instruments
{
    public const ACOUSTIC_GRAND_PIANO = 1;
    public const BRIGHT_ACOUSTIC_PIANO = 2;
    public const ELECTRIC_GRAND_PIANO = 3;
    public const HONKY_TONK_PIANO = 4;
    public const RHODES_PIANO = 5;
    public const CHORUSED_PIANO = 6;
    public const HARPSICHORD = 7;
    public const CLAVINET = 8;
    public const CELESTA = 9;
    public const GLOCKENSPIEL = 10;
    public const MUSIC_BOX = 11;
    public const VIBRAPHONE = 12;
    public const MARIMBA = 13;
    public const XYLOPHONE = 14;
    public const TUBULAR_BELLS = 15;
    public const DULCIMER = 16;
    public const HAMMOND_ORGAN = 17;
    public const PERCUSSIVE_ORGAN = 18;
    public const ROCK_ORGAN = 19;
    public const CHURCH_ORGAN = 20;
    public const REED_ORGAN = 21;
    public const ACCORDION = 22;
    public const HARMONICA = 23;
    public const TANGO_ACCORDION = 24;
    public const ACOUSTIC_NYLON_GUITAR = 25;
    public const ACOUSTIC_STEEL_GUITAR = 26;
    public const ELECTRIC_JAZZ_GUITAR = 27;
    public const ELECTRIC_CLEAN_GUITAR = 28;
    public const ELECTRIC_MUTED_GUITAR = 29;
    public const OVERDRIVEN_GUITAR = 30;
    public const DISTORTION_GUITAR = 31;
    public const GUITAR_HARMONICS = 32;
    public const ACOUSTIC_BASS = 33;
    public const FINGERED_ELECTRIC_BASS = 34;
    public const PLUCKED_ELECTRIC_BASS = 35;
    public const FRETLESS_BASS = 36;
    public const SLAP_BASS1 = 37;
    public const SLAP_BASS2 = 38;
    public const SYNTH_BASS1 = 39;
    public const SYNTH_BASS2 = 40;
    public const VIOLIN = 41;
    public const VIOLA = 42;
    public const CELLO = 43;
    public const CONTRABASS = 44;
    public const TREMOLO_STRINGS = 45;
    public const PIZZICATO_STRINGS = 46;
    public const ORCHESTRAL_HARP = 47;
    public const TIMPANI = 48;
    public const STRING_ENSEMBLE1 = 49;
    public const STRING_ENSEMBLE2 = 50;
    public const SYNTH_STRINGS1 = 51;
    public const SYNTH_STRINGS2 = 52;
    public const CHOIR_AAH = 53;
    public const CHOIR_OOH = 54;
    public const SYNTH_VOICE = 55;
    public const ORCHESTRAL_HIT = 56;
    public const TRUMPET = 57;
    public const TROMBONE = 58;
    public const TUBA = 59;
    public const MUTED_TRUMPET = 60;
    public const FRENCH_HORN = 61;
    public const BRASS_SECTION = 62;
    public const SYNTH_BRASS1 = 63;
    public const SYNTH_BRASS2 = 64;
    public const SOPRANO_SAX = 65;
    public const ALTO_SAX = 66;
    public const TENOR_SAX = 67;
    public const BARITONE_SAX = 68;
    public const OBOE = 69;
    public const ENGLISH_HORN = 70;
    public const BASSOON = 71;
    public const CLARINET = 72;
    public const PICCOLO = 73;
    public const FLUTE = 74;
    public const RECORDER = 75;
    public const PAN_FLUTE = 76;
    public const BOTTLE_BLOW = 77;
    public const SHAKUHACHI = 78;
    public const WHISTLE = 79;
    public const OCARINA = 80;
    public const SQUARE_WAVE_LEAD = 81;
    public const SAWTOOTH_WAVE_LEAD = 82;
    public const CALLIOPE_LEAD = 83;
    public const CHIFF_LEAD = 84;
    public const CHARANG_LEAD = 85;
    public const VOICE_LEAD = 86;
    public const FIFTHS_LEAD = 87;
    public const BASS_LEAD = 88;
    public const NEW_AGE_PAD = 89;
    public const WARM_PAD = 90;
    public const POLYSYNTH_PAD = 91;
    public const CHOIR_PAD = 92;
    public const BOWED_PAD = 93;
    public const METALLIC_PAD = 94;
    public const HALO_PAD = 95;
    public const SWEEP_PAD = 96;
    public const RAIN_EFFECT = 97;
    public const SOUNDTRACK_EFFECT = 98;
    public const CRYSTAL_EFFECT = 99;
    public const ATMOSPHERE_EFFECT = 100;
    public const BRIGHTNESS_EFFECT = 101;
    public const GOBLINS_EFFECT = 102;
    public const ECHOES_EFFECT = 103;
    public const SCI_FI_EFFECT = 104;
    public const SITAR = 105;
    public const BANJO = 106;
    public const SHAMISEN = 107;
    public const KOTO = 108;
    public const KALIMBA = 109;
    public const BAGPIPE = 110;
    public const FIDDLE = 111;
    public const SHANAI = 112;
    public const TINKLE_BELL = 113;
    public const AGOGO = 114;
    public const STEEL_DRUMS = 115;
    public const WOODBLOCK = 116;
    public const TAIKO_DRUM = 117;
    public const MELODIC_TOM = 118;
    public const SYNTH_DRUM = 119;
    public const REVERSE_CYMBAL = 120;
    public const GUITAR_FRET_NOISE = 121;
    public const BREATH_NOISE = 122;
    public const SEASHORE = 123;
    public const BIRD_TWEET = 124;
    public const TELEPHONE_RING = 125;
    public const HELICOPTER = 126;
    public const APPLAUSE = 127;
    public const GUN_SHOT = 128;

    /**
     * @return array
     */
    public static function getInstruments(): array
    {
        return [
            self::ACOUSTIC_GRAND_PIANO => 'Acoustic Grand Piano',
            self::BRIGHT_ACOUSTIC_PIANO => 'Bright Acoustic Piano',
            self::ELECTRIC_GRAND_PIANO => 'Electric Grand Piano',
            self::HONKY_TONK_PIANO => 'Honky-tonk Piano',
            self::RHODES_PIANO => 'Rhodes Piano',
            self::CHORUSED_PIANO => 'Chorused Piano',
            self::HARPSICHORD => 'Harpsichord',
            self::CLAVINET => 'Clavinet',
            self::CELESTA => 'Celesta',
            self::GLOCKENSPIEL => 'Glockenspiel',
            self::MUSIC_BOX => 'Music Box',
            self::VIBRAPHONE => 'Vibraphone',
            self::MARIMBA => 'Marimba',
            self::XYLOPHONE => 'Xylophone',
            self::TUBULAR_BELLS => 'Tubular Bells',
            self::DULCIMER => 'Dulcimer',
            self::HAMMOND_ORGAN => 'Hammond Organ',
            self::PERCUSSIVE_ORGAN => 'Percussive Organ',
            self::ROCK_ORGAN => 'Rock Organ',
            self::CHURCH_ORGAN => 'Church Organ',
            self::REED_ORGAN => 'Reed Organ',
            self::ACCORDION => 'Accordion',
            self::HARMONICA => 'Harmonica',
            self::TANGO_ACCORDION => 'Tango Accordion',
            self::ACOUSTIC_NYLON_GUITAR => 'Acoustic Nylon Guitar',
            self::ACOUSTIC_STEEL_GUITAR => 'Acoustic Steel Guitar',
            self::ELECTRIC_JAZZ_GUITAR => 'Electric Jazz Guitar',
            self::ELECTRIC_CLEAN_GUITAR => 'Electric Clean Guitar',
            self::ELECTRIC_MUTED_GUITAR => 'Electric Muted Guitar',
            self::OVERDRIVEN_GUITAR => 'Overdriven Guitar',
            self::DISTORTION_GUITAR => 'Distortion Guitar',
            self::GUITAR_HARMONICS => 'Guitar Harmonics',
            self::ACOUSTIC_BASS => 'Acoustic Bass',
            self::FINGERED_ELECTRIC_BASS => 'Fingered Electric Bass',
            self::PLUCKED_ELECTRIC_BASS => 'Plucked Electric Bass',
            self::FRETLESS_BASS => 'Fretless Bass',
            self::SLAP_BASS1 => 'Slap Bass 1',
            self::SLAP_BASS2 => 'Slap Bass 2',
            self::SYNTH_BASS1 => 'Synth Bass 1',
            self::SYNTH_BASS2 => 'Synth Bass 2',
            self::VIOLIN => 'Violin',
            self::VIOLA => 'Viola',
            self::CELLO => 'Cello',
            self::CONTRABASS => 'Contrabass',
            self::TREMOLO_STRINGS => 'Tremolo Strings',
            self::PIZZICATO_STRINGS => 'Pizzicato Strings',
            self::ORCHESTRAL_HARP => 'Orchestral Harp',
            self::TIMPANI => 'Timpani',
            self::STRING_ENSEMBLE1 => 'String Ensemble 1',
            self::STRING_ENSEMBLE2 => 'String Ensemble 2',
            self::SYNTH_STRINGS1 => 'Synth Strings 1',
            self::SYNTH_STRINGS2 => 'Synth Strings 2',
            self::CHOIR_AAH => 'Choir "Aah"',
            self::CHOIR_OOH => 'Choir "Ooh"',
            self::SYNTH_VOICE => 'Synth Voice',
            self::ORCHESTRAL_HIT => 'Orchestral Hit',
            self::TRUMPET => 'Trumpet',
            self::TROMBONE => 'Trombone',
            self::TUBA => 'Tuba',
            self::MUTED_TRUMPET => 'Muted Trumpet',
            self::FRENCH_HORN => 'French Horn',
            self::BRASS_SECTION => 'Brass Section',
            self::SYNTH_BRASS1 => 'Synth Brass 1',
            self::SYNTH_BRASS2 => 'Synth Brass 2',
            self::SOPRANO_SAX => 'Soprano Sax',
            self::ALTO_SAX => 'Alto Sax',
            self::TENOR_SAX => 'Tenor Sax',
            self::BARITONE_SAX => 'Baritone Sax',
            self::OBOE => 'Oboe',
            self::ENGLISH_HORN => 'English Horn',
            self::BASSOON => 'Bassoon',
            self::CLARINET => 'Clarinet',
            self::PICCOLO => 'Piccolo',
            self::FLUTE => 'Flute',
            self::RECORDER => 'Recorder',
            self::PAN_FLUTE => 'Pan Flute',
            self::BOTTLE_BLOW => 'Bottle Blow',
            self::SHAKUHACHI => 'Shakuhachi',
            self::WHISTLE => 'Whistle',
            self::OCARINA => 'Ocarina',
            self::SQUARE_WAVE_LEAD => 'Square Wave Lead',
            self::SAWTOOTH_WAVE_LEAD => 'Sawtooth Wave Lead',
            self::CALLIOPE_LEAD => 'Calliope Lead',
            self::CHIFF_LEAD => 'Chiff Lead',
            self::CHARANG_LEAD => 'Charang Lead',
            self::VOICE_LEAD => 'Voice Lead',
            self::FIFTHS_LEAD => 'Fifths Lead',
            self::BASS_LEAD => 'Bass Lead',
            self::NEW_AGE_PAD => 'New Age Pad',
            self::WARM_PAD => 'Warm Pad',
            self::POLYSYNTH_PAD => 'Polysynth Pad',
            self::CHOIR_PAD => 'Choir Pad',
            self::BOWED_PAD => 'Bowed Pad',
            self::METALLIC_PAD => 'Metallic Pad',
            self::HALO_PAD => 'Halo Pad',
            self::SWEEP_PAD => 'Sweep Pad',
            self::RAIN_EFFECT => 'Rain Effect',
            self::SOUNDTRACK_EFFECT => 'Soundtrack Effect',
            self::CRYSTAL_EFFECT => 'Crystal Effect',
            self::ATMOSPHERE_EFFECT => 'Atmosphere Effect',
            self::BRIGHTNESS_EFFECT => 'Brightness Effect',
            self::GOBLINS_EFFECT => 'Goblins Effect',
            self::ECHOES_EFFECT => 'Echoes Effect',
            self::SCI_FI_EFFECT => 'Sci-Fi Effect',
            self::SITAR => 'Sitar',
            self::BANJO => 'Banjo',
            self::SHAMISEN => 'Shamisen',
            self::KOTO => 'Koto',
            self::KALIMBA => 'Kalimba',
            self::BAGPIPE => 'Bagpipe',
            self::FIDDLE => 'Fiddle',
            self::SHANAI => 'Shanai',
            self::TINKLE_BELL => 'Tinkle Bell',
            self::AGOGO => 'Agogo',
            self::STEEL_DRUMS => 'Steel Drums',
            self::WOODBLOCK => 'Woodblock',
            self::TAIKO_DRUM => 'Taiko Drum',
            self::MELODIC_TOM => 'Melodic Tom',
            self::SYNTH_DRUM => 'Synth Drum',
            self::REVERSE_CYMBAL => 'Reverse Cymbal',
            self::GUITAR_FRET_NOISE => 'Guitar Fret Noise',
            self::BREATH_NOISE => 'Breath Noise',
            self::SEASHORE => 'Seashore',
            self::BIRD_TWEET => 'Bird Tweet',
            self::TELEPHONE_RING => 'Telephone Ring',
            self::HELICOPTER => 'Helicopter',
            self::APPLAUSE => 'Applause',
            self::GUN_SHOT => 'Gun Shot',
        ];
    }

    /**
     * @param mixed $id
     *
     * @return string
     */
    public static function getInstrumentLabel($id): string
    {
        $label = self::getInstruments()[$id] ?? null;
        if (empty($label)) {
            throw new InstrumentNotFoundException('Music instrument `' . $id . '` not found.');
        }

        return $label;
    }
}
