<?php

use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Elements\Key;
use MuseFx\PhpMusicXml\Elements\ScorePartwise;
use MuseFx\PhpMusicXml\Helpers\Chord;
use MuseFx\PhpMusicXml\Helpers\Stafe;
use MuseFx\PhpMusicXml\Helpers\Tuplet;
use MuseFx\PhpMusicXml\Midi\Drumkit;
use MuseFx\PhpMusicXml\Midi\Instrument;
use MuseFx\PhpMusicXml\Midi\Instruments;
use MuseFx\PhpMusicXml\MusicXml;

include __DIR__ . '/../vendor/autoload.php';

$musicXML = new MusicXml;
$score = $musicXML->createScore();

esAltSax($score);
piano($score);
drumKit($score);


header('Content-Type: text/xml; carset=utf-8');
echo $musicXML->getContent(MusicXml::OUTPUT_FORMATTED | MusicXml::STRICT_MEASURES);


function esAltSax(ScorePartwise $score)
{
    $scorePart = $score->createScorePart('P-ALTSAX');
    $scorePart->setName('Eb Alto Sax.')->setPrintName();
    $instrument = new Instrument(Instruments::ALTO_SAX);
    $scorePart->setInstrument($instrument);

    $measure = $scorePart->getPart()->createMeasure();
    $measure->transpose(-9);
    $measure->addNote('C', 4, Beat::TYPE_QUARTER)->startSlur();
    $measure->addNote('D', 4, Beat::TYPE_QUARTER);
    $measure->addNote('E', 4, Beat::TYPE_QUARTER);
    $measure->addNote('F', 4, Beat::TYPE_QUARTER);

    $measure = $scorePart->getPart()->createMeasure();
    $measure->addNote('G', 4, Beat::TYPE_QUARTER)->stopSlur();
    $measure->addNote('A', 4, Beat::TYPE_QUARTER)->addArticulation('staccato');
    $measure->addNote('B', 4, Beat::TYPE_QUARTER)->addArticulation('staccato');
    $measure->addNote('C', 5, Beat::TYPE_QUARTER)->addArticulation('staccato');

    $measure = $scorePart->getPart()->createMeasure()->key(function (Key $key) {
        $key->setFifths(1);
    });
    $measure->addNote('G', 4, Beat::TYPE_QUARTER);
    $measure->addNote('A', 4, Beat::TYPE_QUARTER);
    $measure->addNote('B', 4, Beat::TYPE_QUARTER);
    $measure->addNote('C', 5, Beat::TYPE_QUARTER);

    $measure = $scorePart->getPart()->createMeasure();
    $measure->addNote('D', 5, Beat::TYPE_QUARTER);
    $measure->addNote('E', 5, Beat::TYPE_QUARTER);
    $measure->addNote('F#', 5, Beat::TYPE_QUARTER);
    $measure->addNote('G', 5, Beat::TYPE_QUARTER);
}

function piano(ScorePartwise $score)
{
    $scorePart = $score->createScorePart('P-KEYBOARDS');
    $scorePart->setName('Keyboards')->setPrintName();
    $instrument1 = new Instrument(Instruments::ELECTRIC_GRAND_PIANO);
    $instrument2 = new Instrument(Instruments::HAMMOND_ORGAN);
    $scorePart->setInstrument($instrument1, 'P-KEYBOARD-PIANO');
    $scorePart->setInstrument($instrument2, 'P-KEYBOARD-ORGAN');

    $measure = $scorePart->getPart()->createMeasure()
        ->key(function (Key $key) {
            $key->setFifths(-3);
        })
        ->addStafe(function (Stafe $stafe) {
            $stafe->getClef()->setBass();
        });
    $measure->addNote('Eb', 4)->withInstrument('P-KEYBOARD-PIANO');
    $measure->addChord(function (Chord $chord) {
        $chord->addRoot('Eb', 5);
        $chord->addNote('G', 5);
    });

    $measure->addNote('Bb', 4);
    $measure->addChord(function (Chord $chord) {
        $chord->addRoot('Eb', 5);
        $chord->addNote('G', 5);
    });

    $measure->addNote('Eb', 4)->toVoice(2);
    $measure->addNote('F', 4)->toVoice(2);
    $measure->addNote('G', 4)->toVoice(2);
    $measure->addNote('Ab', 4)->toVoice(2);

    // Stafe 2 (Bass)
    $measure->addNote('Eb', 2, Beat::TYPE_HALF)->toStafe(2);
    $measure->addNote('Bb', 2, Beat::TYPE_HALF)->toStafe(2);

    $measure = $scorePart->getPart()->createMeasure();
    $measure->addNote('Eb', 4);
    $measure->addChord(function (Chord $chord) {
        $chord->addRoot('Eb', 5);
        $chord->addNote('G', 5);
    });
    $measure->addNote('Bb', 4);
    $measure->addTuplet(3, 2, function (Tuplet $tuplet) {
        $tuplet->addChord(function (Chord $chord) {
            $chord->addRoot('Eb', 5, Beat::TYPE_EIGHTH)->startBeam();
            $chord->addNote('G', 5, Beat::TYPE_EIGHTH)->startBeam();
        });
        $tuplet->addChord(function (Chord $chord) {
            $chord->addRoot('D', 5, Beat::TYPE_EIGHTH)->continueBeam();
            $chord->addNote('Gb', 5, Beat::TYPE_EIGHTH)->continueBeam();
        });
        $tuplet->addChord(function (Chord $chord) {
            $chord->addRoot('Db', 5, Beat::TYPE_EIGHTH)->endBeam();
            $chord->addNote('F', 5, Beat::TYPE_EIGHTH)->endBeam();
        });
    });

    $measure->addNote('Eb', 4)->toVoice(2);
    $measure->addNote('F', 4)->toVoice(2);
    $measure->addNote('G', 4)->toVoice(2);
    $measure->addNote('Ab', 4)->toVoice(2);

    // Stafe 2 (Bass)
    $measure->addNote('Eb', 2, Beat::TYPE_HALF)->toStafe(2);
    $measure->addNote('Bb', 2, Beat::TYPE_HALF)->toStafe(2);

    $measure = $scorePart->getPart()->createMeasure();
    $measure->key(function (Key $key) {
        $key->setFifths(-2);
    });

    $measure->addNote('Bb', 4)->withInstrument('P-KEYBOARD-ORGAN');
    $measure->addChord(function (Chord $chord) {
        $chord->addRoot('Bb', 5);
        $chord->addNote('G', 5);
    });

    $measure->addNote('F', 4);
    $measure->addChord(function (Chord $chord) {
        $chord->addRoot('Bb', 5);
        $chord->addNote('G', 5);
    });

    // Stafe 2 (Bass)
    $measure->addNote('Bb', 2, Beat::TYPE_HALF)->toStafe(2);
    $measure->addNote('F', 2, Beat::TYPE_HALF)->toStafe(2);

    $measure = $scorePart->getPart()->createMeasure();

    $measure->addNote('Bb', 4);
    $measure->addChord(function (Chord $chord) {
        $chord->addRoot('Bb', 5);
        $chord->addNote('G', 5);
    });

    $measure->addNote('F', 4);
    $measure->addChord(function (Chord $chord) {
        $chord->addRoot('Bb', 5);
        $chord->addNote('G', 5);
    });

    // Stafe 2 (Bass)
    $measure->addNote('Bb', 2, Beat::TYPE_HALF)->toStafe(2);
    $measure->addNote('F', 2, Beat::TYPE_HALF)->toStafe(2);
}

function drumKit(ScorePartwise $score)
{
    $scorePart = $score->createScorePart('P-DRUMKIT');
    $scorePart->setName('Drums')->setPrintName();
    $scorePart->setDrumkit('P-DRUMKIT-');

    $measure = $scorePart->getPart()->createMeasure();

    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);

    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::ACOUSTIC_SNARE, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);


    $measure = $scorePart->getPart()->createMeasure();

    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);

    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::ACOUSTIC_SNARE, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);

    $measure = $scorePart->getPart()->createMeasure();

    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);

    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::ACOUSTIC_SNARE, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);


    $measure = $scorePart->getPart()->createMeasure();

    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);
    $measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER);

    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::ACOUSTIC_SNARE, Beat::TYPE_QUARTER)->toVoice(2);
    $measure->addDrumBeat(Drumkit::BASS_DRUM1, Beat::TYPE_QUARTER)->toVoice(2);
}
