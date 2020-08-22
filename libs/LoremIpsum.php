<?php

class LoremIpsum {

  const WORDS = [
    "nisi",
    "dolor",
    "ut",
    "nunc",
    "ultrices",
    "fusce",
    "donec",
    "ex",
    "ornare",
    "aenean",
    "malesuada",
    "elementum",
    "curabitur",
    "nostra",
    "nisl",
    "nulla",
    "finibus",
    "class",
    "congue",
    "in",
    "odio",
    "efficitur",
    "inceptos",
    "lacus",
    "aliquam",
    "hac",
    "fringilla",
    "pulvinar",
    "consectetur",
    "felis",
    "lorem",
    "primis",
    "porttitor",
    "taciti",
    "tortor",
    "dui",
    "urna",
    "convallis",
    "etiam",
    "erat",
    "potenti",
    "cubilia",
    "ante",
    "phasellus",
    "magna",
    "euismod",
    "in",
    "morbi",
    "at",
    "velit",
    "hendrerit",
    "tristique",
    "porta",
    "integer",
    "tempor",
    "libero",
    "vitae",
    "aliquam",
    "posuere",
    "proin",
    "nulla",
    "augue",
    "venenatis",
    "est",
    "rhoncus",
    "eget",
    "dis",
    "sed",
    "sapien",
    "mattis",
    "luctus",
    "enim",
    "himenaeos",
    "vivamus",
    "mollis",
    "neque",
    "maximus",
    "nibh",
    "vulputate",
    "elit",
    "nullam",
    "senectus",
    "mauris",
    "turpis",
    "vehicula",
    "tincidunt",
    "semper",
    "justo",
    "accumsan",
    "gravida",
    "vestibulum",
    "condimentum",
    "feugiat",
    "pellentesque",
    "penatibus",
    "quam",
    "pellentesque",
    "dapibus",
    "id",
    "mauris",
    "sem",
    "mi",
    "maecenas",
    "vestibulum",
    "eros",
    "laoreet",
    "platea",
    "cursus",
    "facilisi",
    "natoque",
    "magnis",
    "faucibus",
    "bibendum",
    "egestas",
    "ad",
    "imperdiet",
    "habitasse",
    "adipiscing",
    "eu",
    "sollicitudin",
    "et",
    "sodales",
    "dictum",
    "morbi",
    "blandit",
    "vel",
    "varius",
    "montes",
    "arcu",
    "fames",
    "praesent",
    "fermentum",
    "nec",
    "habitant",
    "lectus",
    "suscipit",
    "massa",
    "nunc",
    "lobortis",
    "per",
    "viverra",
    "litora",
    "dignissim",
    "lorem",
    "netus",
    "commodo",
    "ligula",
    "sed",
    "metus",
    "amet",
    "purus",
    "pretium",
    "consequat",
    "molestie",
    "non",
    "ultricies",
    "suspendisse",
    "parturient",
    "quisque",
    "conubia",
    "sagittis",
    "ullamcorper",
    "quis",
    "auctor",
    "nascetur",
    "eleifend",
    "interdum",
    "diam",
    "tellus",
    "lacinia",
    "pharetra",
    "dictumst",
    "risus",
    "scelerisque",
    "orci",
    "ut",
    "tempus",
    "nam",
    "aptent",
    "rutrum",
    "volutpat",
    "sit",
    "ac",
    "orci",
    "interdum",
    "mus",
    "curae",
    "placerat",
    "cras",
    "aliquet",
    "leo",
    "duis",
    "ipsum",
    "a",
    "ridiculus",
    "torquent",
    "sociosqu",
    "iaculis",
    "facilisis",
  ];

  const MAX_TEXT_LENGTH = 1000000000;

  private function __construct() {

  }



  public static function random_text($min_number_letters) {
    if ($min_number_letters > self::MAX_TEXT_LENGTH)
      throw new Exception(sprintf('Length must be, at most, %d.', self::MAX_TEXT_LENGTH));
    
    $text = '';
    $first_word = true;
    $words_before_newline = self::generate_number_words_before_newline();
    $words_before_point = self::generate_number_words_before_point();
    while (strlen($text) < $min_number_letters) {
      $new_text = self::WORDS[array_rand(self::WORDS)];
      
      if ($first_word) {
        $new_text = ucfirst($new_text);
        $first_word = false;
      }
      else {
        $new_text = ' '.$new_text;
      }

      if (--$words_before_newline <= 0) {
        $new_text .= '.\n';
        $words_before_newline = self::generate_number_words_before_newline();
        $words_before_point = self::generate_number_words_before_point();
        $first_word = true;
      }
      else if (--$words_before_point <= 0) {
        $new_text .= '. ';
        $words_before_point = self::generate_number_words_before_point();
        $first_word = true;
      }

      $text .= $new_text;
    }

    $last_char = $text[strlen($text)-1];
    switch ($last_char) {
      case '.': case '\n':
        break;
      default:
        $text .= '.';
        break;
    }

    return $text;
  }

  private static function generate_number_words_before_point() {
    return rand(3, 20);
  }

  private static function generate_number_words_before_newline() {
    return rand(20, 100);
  }
}