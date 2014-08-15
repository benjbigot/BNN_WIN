<?php
 
class checker {
    private $nwords = array();
    private function words($text) {
        return preg_split('/\s+/', $text);
    }
    public function train($words) {
        $this->nwords = array_flip($this->words($words));
    }
    private function edits1($word) {
        $word = strtolower($word);
        $alphabet = range('a', 'z');
         
        $splits = array();
        for ($i = 1; $i < strlen($word); $i++) {
            $splits[] = array(substr($word, 0, $i), substr($word, $i));
        }
        $deletes = array();
        foreach($splits as $split) {
            $deletes[] = $split[0] . substr($split[1], 1);
        }
        $transposes = array();
        foreach($splits as $split) {
            if (isset($split[1][1])) {
                $transposes[] = $split[0] . $split[1][1] . $split[1][0] . substr($split[1], 2);
            }
        }
        $replaces = array();
        foreach($alphabet as $letter) {
            foreach($splits as $split) {
                $replaces[] = $split[0] . $letter . substr($split[1], 1);
            }
        }
        $inserts = array();
        foreach($alphabet as $letter) {
            foreach($splits as $split) {
                $inserts[] = $split[0] . $letter . $split[1];
            }
        }
        return array_merge($deletes, $transposes, $replaces, $inserts);
    }
    private function edits2($word) {
        $edits2 = array();
        foreach($this->edits1($word) as $e1) {
            foreach($this->edits1($e1) as $e2) {
                if (isset($this->nwords[$e2])) {
                    $edits2[] = $e2;
                }
            }
        }
        return $edits2;
    }
    private function known($word) {
        $known = array();
        if (isset($this->nwords[$word])) {
            $known[] = $word;
        }
        return $known;
    }
    public function correct($word) {
        $candidates = array();
        if ($this->known($word)) {
            $candidates[] = $word;
        }
        foreach($this->edits1($word) as $possible) {
            if ($this->known($possible)) {
                $candidates[] = $possible;
            }
        }
        foreach($this->edits2($word) as $possible) {
            if ($this->known($possible)) {
                $candidates[] = $possible;
            }
        }
        $counts = array();
        foreach($candidates as $candidate) {
            if (!isset($counts[$candidate])) {
                $counts[$candidate] = 0;
            } else {
                $counts[$candidate]++;
            }
        }
        $most = 0;
        $word = '';
        foreach($counts as $candidate => $count) {
            if ($count > $most) {
                $most = $count;
                $word = $candidate;
            }
        }
        return $word;
    }
}