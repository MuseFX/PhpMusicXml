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
$measure = $scorePart->getPart()->createMeasure();
$measure->transpose(-9); // We have added an Eb alto saxophone, so we transpose the measure to Eb (the following measures will keep this property)

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
    $time->setBeats(4)->setBeatType(4)->useSymbols(); // 4 (beats) / 4 (beat type) - using symbols: adding common time for 4/4 and cut time for 2/2
  });

// Adding some notes and rests
$measure->addNote('B', 4, Beat::TYPE_QUARTER)
$measure->addRest(Beat::TYPE_EIGHT);
$measure->addNote('A#', 4, Beat::TYPE_EIGHTH)
$measure->addNote('B', 4, Beat::TYPE_QUARTER)
$measure->addRest(Beat::TYPE_EIGHT);
$measure->addNote('A#', 4, Beat::TYPE_EIGHTH)

// Next measure..
$measure = $scorePart->getPart()->createMeasure();
```
