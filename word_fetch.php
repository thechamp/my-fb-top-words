<?php

    /* How to get access token from FB
       1. Hit URl : https://developers.facebook.com/tools/explorer/?method=GET&path=me%2Fstatuses&version=v2.2&
       2. click on "Get Access Token" button
       3. Add "user_status" permission in pop-up (IMPORTANT)
       4. Copy access_token from Graph Explorer and replace in the below variable"
       */

    // Our variables
    $access_token = 'paste_access_token_here';
    $top_words_count = 20;

    // These words will be discarded
    $boring_words = array("a", "able", "about", "across", "after", "all", "almost", "also", "am", "among", "an",
                          "and", "any", "are", "as", "at", "be", "because", "been", "but", "by", "can", "cannot",
                          "could", "dear", "did", "do", "does", "either", "else", "ever", "every", "for", "from",
                          "get", "got", "had", "has", "have", "he", "her", "hers", "him", "his", "how", "however",
                          "i", "if", "in", "into", "is", "it", "its", "just", "least", "let", "like", "likely", "may",
                          "me", "might", "most", "must", "my", "neither", "no", "nor", "not", "of", "off", "often",
                          "on", "only", "or", "other", "our", "own", "rather", "said", "say", "says", "she", "should",
                          "since", "so", "some", "than", "that", "the", "their", "them", "then", "there", "these",
                          "they", "this", "tis", "to", "too", "twas", "us", "wants", "was", "we", "were", "what",
                          "when", "where", "which", "while", "who", "whom", "why", "will", "with", "would", "yet", "you", "your");

    // The final array which stores all the "words => frequency" from user posts
    $user_words = array();

    // Do a CURL hit and fetch latest 100 posts of user
    $ch=curl_init("https://graph.facebook.com/me/statuses?access_token=$access_token" . "&limit=100");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $statuses = curl_exec($ch);
    $statuses_json = json_decode($statuses, true);

    if(array_key_exists("error", $statuses_json))
    {
        echo $statuses_json["error"]["message"] . ". Exiting...\n";
        exit();
    }

    $data = $statuses_json["data"];

    // Iterate over each post
    foreach($data as $index => $post)
    {
        // Change every word to lowercase
        $msg = strtolower($post["message"]);

        // Remove all special characters (everything other than alphabets, numbers and spaces) from post
        $raw_msg =  preg_replace('/[^A-Za-z0-9\s]/', '', $msg);

        // Split post into words
        $raw_words = preg_split('/[\s]+/', $raw_msg);

        // Iterate over each word and increase its frequency if it is not boring word
        foreach($raw_words as $i => $word) {

            // Discard words with length smaller than 4
            if(strlen($word) < 4)
                continue;

            $word = strtolower($word);

            if ( in_array($word, $boring_words) == FALSE ) {
                if ( array_key_exists($word, $user_words) == FALSE)
                    $user_words[$word] = 0;

                $user_words[$word] += 1;
            }
        }
    }

    // Sort the words based on frequency
    arsort($user_words);

    // Print top frequency words
    print_r( array_slice($user_words, 0, $top_words_count) );
?>
