<p align="center"><img src="https://i.imgur.com/8OZBPX6.jpeg" alt="wordle buster logo" style="width: 150px;"></p>

## Wordle Buster

<p>Wordle Buster is a companion tool for the popular online word game Wordle. The goal of this repo is to help take some of the annoying legwork out of playing the game.  Instead of spending 15 minutes racking your mind for words, you can focus on which words are most likely to help you find the answer. Some of the app's features include...</p>

- Possible Answers Count
- List of Most Probable Answers Based on Word Popularity
- List of Best Answers Based on Letter Frequency
- Basic Mobile Optimization

## Word Library

<p>The Library that Wordle Buster uses comes from <a href="https://sourceforge.net/projects/mysqlenglishdictionary/files/">this SQL file</a> on SourceForge. The file was updated to extract all 5 letter words that did't contain special characters or spaces.</p>

<p>The Library pulled word popularity from DataMuse's <a href="https://www.datamuse.com/api/">public word search API</a>.</p>

<p>Letter frequency is generated by tallying the total number of times a letter occurs in a word and dividing that number by the total number of words in the library. The tally only counts once per occurance per word (ex. When counting the number of times the letter O occurs, Igloo would count as one, not two).</p> 

## Technical

<p>Wordle Buster is built using <a href="https://laravel.com/">Laravel 9</a> and <a href="https://vuejs.org/">Vue.js</a>. The database is mySQL. Locally it runs in Docker using laravel sail.</p>

## Contribution

<p>If you see an issue or have a feature request, please feel free to create an issue.</p>

<p>If you'd like to contribute, please create an issue first, thenm create a PR just to give everyone context for what the PR addresses.</p>

<p>If you're interested in the database itself, there is a copy of the words table under words.sql in the repo.</p>
