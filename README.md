# PhpMusicXml
A package for creating 🎵 MusicXML files with PHP 🐘.

## Installation
```bash
composer require musefx/php-music-xml
```

## Getting started

#### Creating a score and adding score parts
```php
use MuseFx\PhpMusicXml\MusicXml;
use MuseFx\PhpMusicXml\Midi\Instrument;
use MuseFx\PhpMusicXml\Midi\Instruments;

$musicXml = new MusicXml();
$score = $musicXml->createScore();

// Adding score properties
$score->setTitle('Test Song')->setSubtitle('By MusFX');
$score->addIdentification('Arr / Composed by MuseFX', 'composer');
$score->addIdentification('Words by MuseFX', 'lyricist');

// Creating a part
$scorePart = $score->createScorePart('P-ALTSAX'); // A custom ID
$scorePart->setName('Eb Alto Sax.')->setPrintName(true); // Setting part name and printing it to the score

// Setting instrument
$instrument = new Instrument(Instruments::ALTO_SAX);
$scorePart->setInstrument($instrument);
```

#### Measures, notes...
```php
use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Elements\Clef;
use MuseFx\PhpMusicXml\Elements\Key;
use MuseFx\PhpMusicXml\Elements\Time;

$measure = $scorePart->getPart()->createMeasure();

// We have added an Eb alto saxophone, so we transpose the measure to Eb (the following measures will keep this property)
$measure->transpose(-9);

// Setting clef, time signature and fifths (this will be also kept by the following measures until it's not changed)
// Defaults: clef: G (violin), time: 4/4, fifths: 0 (C / Am)
$measure
  ->clef(function (Clef $clef) {
    $clef->setViolin();
  })
  ->key(function (Key $key) {
    $key->setFifths(2); // adding 2 sharps (F#, C#)
    $key->setFifths(-2); // adding 2 flats (Bb, Eb)
  })
  ->time(function (Time $time) {
    // 4 (beats) / 4 (beat type) - using symbols: adding common time for 4/4 and cut time for 2/2
    $time->setBeats(4)->setBeatType(4)->useSymbols();
  });

// Adding some notes and rests
// addNote({note}, {octave}, {beatType})
$measure->addNote('B', 4, Beat::TYPE_QUARTER);
// addRest({beatType})
$measure->addRest(Beat::TYPE_EIGHT);
$measure->addNote('A#', 4, Beat::TYPE_EIGHTH);
$measure->addNote('B', 4, Beat::TYPE_QUARTER);
$measure->addRest(Beat::TYPE_EIGHT);
$measure->addNote('A#', 4, Beat::TYPE_EIGHTH);

// Next measure..
$measure = $scorePart->getPart()->createMeasure();
```

#### Get content
```php
use MuseFx\PhpMusicXml\MusicXml;

// Basic
$content = $musicXml->getContent();

// Validate measure lengths before getting the content
$content = $musicXml->getContent(MusicXml::STRICT_MEASURES);

// Format output
$content = $musicXml->getContent(MusicXml::STRICT_MEASURES | MusicXml::OUTPUT_FORMATTED);
```

### Advanced

#### Slur
```php
$measure->addNote('B', 4, Beat::TYPE_QUARTER)->startSlur();
/* ... */
$measure->addNote('C', 5, Beat::TYPE_QUARTER)->stopSlur();

// Through measure(s)
$measure->addNote('B', 4, Beat::TYPE_QUARTER)->startSlur();
/* ... */
$measure = $scorePart->getPart()->createMeasure();
/* ... */
$measure->addNote('C', 5, Beat::TYPE_QUARTER)->stopSlur();

// Nested slur
$measure->addNote('C', 5, Beat::TYPE_QUARTER)->startSlur(1);
$measure->addNote('D', 5, Beat::TYPE_QUARTER);
$measure->addNote('E', 5, Beat::TYPE_QUARTER)->stopSlur(2);
$measure->addNote('F', 5, Beat::TYPE_QUARTER);
$measure = $scorePart->getPart()->createMeasure();
$measure->addNote('G', 5, Beat::TYPE_QUARTER);
$measure->addNote('A', 5, Beat::TYPE_QUARTER)->stopSlur(2);
$measure->addNote('B', 5, Beat::TYPE_QUARTER)->stopSlur(1);
$measure->addNote('C', 5, Beat::TYPE_QUARTER)->letRing();
```

#### Accents
```php
$measure->addNote('C', 5, Beat::TYPE_QUARTER)->addArticulation('tenuto');
$measure->addNote('D', 5, Beat::TYPE_QUARTER)->addArticulation('staccato');
```

#### Tempo
```php
$measure->addDirection()->setTempo(120, Beat::TYPE_QUARTER);
/* ... */
$measure->addDirection()->setTempo(80, Beat::TYPE_HALF);
```

#### Dynamics
```php
$measure->addDirection()->setDynamics()->mp(); // Starting with mezzopiano
/* ... */
$measure->addDirection()->setDynamics()->fp(); // Adding a fortepiano
$measure->addDirection()->startCrescendo(); // Starting crescendo
/* ... */
$measure->addDirection()->stopCrescendo(); // End crescendo
$measure->addDirection()->setDynamics()->mf(); // Start mezzoforte
/* ... */
$measure->addDirection()->startDiminuendo(); // Add diminuendo
/* ... */
$measure->addDirection()->endDiminuendo(); // End diminuendo
$measure->addDirection()->setDynamics()->p(); // Ends with piano
/* ... */
```

#### Repeats & jumps
```php
// Repeat part
$measure1->repeatForward();
/* ... */
// Alternate endings
$measure4->endingNumber(1, 'start');
/* ... */
$measure5->endingNumber(1, 'continue');
/* ... */
$measure6->repeatBackward(1); // With endingnumber
$measure7->endingNumber(2, 'start');
/* ... */
$measure5->endingNumber(1, 'continue');
/* ... */
$measure5->endingNumber(1, 'stop');

// Jumps
$measureX->addDirection()->segno();
/* ... */
$measureY->addDirection()->words('To Coda'); // Go to the Coda (After segno)
/* ... */
$measureZ->addDirection()->words('D.S. al Coda'); // Back from Segno to Coda
/* ... */
$measureXYZ->addDirection()->coda(); // Coda
```

#### Multiple voices
```php
use MuseFx\PhpMusicXml\Elements\Beat;

$measure = $scorePart->getPart()->createMeasure();

$measure->addNote('C', 5, Beat::TYPE_QUARTER)->toVoice(1);
$measure->addNote('D', 5, Beat::TYPE_QUARTER)->toVoice(1);
$measure->addNote('E', 5, Beat::TYPE_QUARTER)->toVoice(1);
$measure->addNote('F', 5, Beat::TYPE_QUARTER)->toVoice(1);

$measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
$measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
$measure->addNote('C', 5, Beat::TYPE_QUARTER)->toVoice(2);
$measure->addNote('D', 5, Beat::TYPE_QUARTER)->toVoice(2);
```

#### Multiple staves
```php
use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Elements\Clef;

$measure = $scorePart->getPart()->createMeasure();
$measure->addStafe(function (Clef $clef) {
  $clef->setBass();
});

$measure->addNote('C', 4, Beat::TYPE_QUARTER)->toStafe(1);
$measure->addNote('D', 4, Beat::TYPE_QUARTER)->toStafe(1);
$measure->addNote('E', 4, Beat::TYPE_QUARTER)->toStafe(1);
$measure->addNote('F', 4, Beat::TYPE_QUARTER)->toStafe(1);

$measure->addNote('C', 1, Beat::TYPE_QUARTER)->toStafe(2);
$measure->addNote('D', 1, Beat::TYPE_QUARTER)->toStafe(2);
$measure->addNote('E', 1, Beat::TYPE_QUARTER)->toStafe(2);
$measure->addNote('F', 1, Beat::TYPE_QUARTER)->toStafe(2);
```

#### Chords
```php
use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Helpers\Chord;

$measure->addChord(function (Chord $chord) {
  $chord->addRoot('C', 4, Beat::TYPE_QUARTER);
  $chord->addNote('E', 4, Beat::TYPE_QUARTER);
  $chord->addNote('G', 4, Beat::TYPE_QUARTER);
});
```

#### Advanced rythm
```php
use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Helpers\Tuplet;

// Dotted note
$measure->addNote('C', 1, Beat::TYPE_QUARTER)->dot();

// Tuplets
// addTuplet($into, $from, $callback). A triplet is 2 into 3, so its addTuplet(3, 2, function () { ... })
$measure->addTuplet(3, 2, function (Tuplet $tuplet) {
  $tuplet->addNote('C', 4, Beat::TYPE_EIGTH);
  $tuplet->addNote('E', 4, Beat::TYPE_EIGTH);
  $tuplet->addNote('G', 4, Beat::TYPE_EIGTH);
});
```

#### Multiple instruments
```php
// Setting instruments
$instrument1 = new Instrument(Instruments::ELECTRIC_GRAND_PIANO);
$scorePart->setInstrument($instrument1, 'P1-PIANO-ELECTRIC');
$instrument2 = new Instrument(Instruments::HAMMOND_ORGAN);
$scorePart->setInstrument($instrument2, 'P1-HAMMOND-ORGAN');

// Start with electric piano
$measure->addNote('C', 4, Beat::TYPE_QUARTER)->withInstrument('P1-PIANO-ELECTRIC');
$measure->addNote('D', 4, Beat::TYPE_QUARTER);
$measure->addNote('E', 4, Beat::TYPE_QUARTER);
$measure->addNote('F', 4, Beat::TYPE_QUARTER);

$measure = $scorePart->getPart()->createMeasure();
$measure->addNote('G', 4, Beat::TYPE_QUARTER);
// Continue with Hammond organ
$measure->addNote('A', 4, Beat::TYPE_QUARTER)->withInstrument('P1-HAMMOND-ORGAN');
$measure->addNote('B', 4, Beat::TYPE_QUARTER);
$measure->addNote('C', 5, Beat::TYPE_QUARTER);
```

#### Drumkit
```php
MuseFx\PhpMusicXml\Elements\Beat;
MuseFx\PhpMusicXml\Midi\Drumkit;

// Prefix needed if you have multiple drumkits
$scorePart->setDrumkit('OPTIONAL-PREFIX-');

$measure = $scorePart->getPart()->createMeasure();
$measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER)->toVoice(1);
$measure->addDrumBeat(Drumkit::OPEN_HI_HAT, Beat::TYPE_QUARTER)->toVoice(1);
$measure->addDrumBeat(Drumkit::CLOSED_HI_HAT, Beat::TYPE_QUARTER)->toVoice(1);
$measure->addDrumBeat(Drumkit::OPEN_HI_HAT, Beat::TYPE_QUARTER)->toVoice(1);
$measure->addDrumBeat(Drumkit::ACOUSTIC_BASS_DRUM, Beat::TYPE_QUARTER)->toVoice(2);
$measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
$measure->addDrumBeat(Drumkit::ACOUSTIC_SNARE, Beat::TYPE_QUARTER)->toVoice(2);
$measure->addRest(Beat::TYPE_QUARTER)->toVoice(2);
```

## API reference
In progress...

## Donations
<a href="https://buymeacoffee.musefx.cloud-ip.biz/" target="_blank">Buy me a ☕</a>
