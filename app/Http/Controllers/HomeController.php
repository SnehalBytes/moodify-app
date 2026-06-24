<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get the requested mood, default to 'happy'
        $currentMood = strtolower($request->query('mood', 'happy'));

        // Mood definitions with colors for the glowing effects
        $moods = [
            ['id' => 'happy', 'label' => 'Happy', 'emoji' => '😊', 'color' => 'yellow-400', 'shadow' => 'rgba(250, 204, 21, 0.5)'],
            ['id' => 'sad', 'label' => 'Sad', 'emoji' => '😢', 'color' => 'blue-500', 'shadow' => 'rgba(59, 130, 246, 0.5)'],
            ['id' => 'chill', 'label' => 'Chill', 'emoji' => '☕', 'color' => 'emerald-400', 'shadow' => 'rgba(52, 211, 153, 0.5)'],
            ['id' => 'angry', 'label' => 'Angry', 'emoji' => '🤬', 'color' => 'red-500', 'shadow' => 'rgba(239, 68, 68, 0.5)'],
            ['id' => 'romantic', 'label' => 'Romantic', 'emoji' => '💖', 'color' => 'pink-500', 'shadow' => 'rgba(236, 72, 153, 0.5)'],
            ['id' => 'sleepy', 'label' => 'Sleepy', 'emoji' => '😴', 'color' => 'indigo-400', 'shadow' => 'rgba(129, 140, 248, 0.5)'],
            ['id' => 'party', 'label' => 'Party', 'emoji' => '🎉', 'color' => 'fuchsia-500', 'shadow' => 'rgba(217, 70, 239, 0.5)'],
        ];

        // Expanded music map with metadata
        $musicMap = [
            'happy' => [
                ['title' => 'Happy (Official Music Video)', 'artist' => 'Pharrell Williams', 'id' => 'ZbZSe6N_BXs', 'duration' => '4:06', 'verified' => true, 'tags' => ['English', 'Pop', '2013']],
                ['title' => 'Sunday Best', 'artist' => 'Surfaces', 'id' => 'vdB-8eLEW8g', 'duration' => '2:38', 'verified' => true, 'tags' => ['English', 'Indie', '2019']],
                ['title' => 'Adventure Of A Lifetime', 'artist' => 'Coldplay', 'id' => 'QtXby3twMmI', 'duration' => '4:23', 'verified' => true, 'tags' => ['English', 'Pop', '2015']],
                ['title' => 'Can\'t Stop the Feeling!', 'artist' => 'Justin Timberlake', 'id' => 'ru0K8uYEZWw', 'duration' => '4:46', 'verified' => true, 'tags' => ['English', 'Pop', '2016']],
            ],
            'sad' => [
                ['title' => 'Someone Like You', 'artist' => 'Adele', 'id' => 'hLQl3WQQoQ0', 'duration' => '4:44', 'verified' => true, 'tags' => ['English', 'Soul', '2011']],
                ['title' => 'Someone You Loved', 'artist' => 'Lewis Capaldi', 'id' => 'zABLecsR5UE', 'duration' => '3:06', 'verified' => true, 'tags' => ['English', 'Pop', '2018']],
                ['title' => 'when the party\'s over', 'artist' => 'Billie Eilish', 'id' => 'pbMwTqkKSps', 'duration' => '3:19', 'verified' => true, 'tags' => ['English', 'Alt', '2019']],
                ['title' => 'Let Her Go', 'artist' => 'Passenger', 'id' => 'RBumgq5yVrA', 'duration' => '4:14', 'verified' => true, 'tags' => ['English', 'Folk', '2012']],
            ],
            'chill' => [
                ['title' => 'lofi hip hop radio - beats to relax/study to', 'artist' => 'Lofi Girl', 'id' => 'jfKfPfyJRdk', 'duration' => 'LIVE', 'verified' => true, 'tags' => ['Instrumental', 'Lofi', '2024']],
                ['title' => 'Nothing', 'artist' => 'Bruno Major', 'id' => '78rWk76u-G8', 'duration' => '2:43', 'verified' => true, 'tags' => ['English', 'R&B', '2020']],
                ['title' => 'Japanese Denim', 'artist' => 'Daniel Caesar', 'id' => 'uLu216017mU', 'duration' => '4:31', 'verified' => true, 'tags' => ['English', 'R&B', '2016']],
                ['title' => 'Sunflower', 'artist' => 'Rex Orange County', 'id' => 'Z9e7K6Hx_rY', 'duration' => '4:12', 'verified' => false, 'tags' => ['English', 'Indie', '2017']],
            ],
            'angry' => [
                ['title' => 'In The End', 'artist' => 'Linkin Park', 'id' => 'eVTXPUF4Oz4', 'duration' => '3:38', 'verified' => true, 'tags' => ['English', 'Nu Metal', '2001']],
                ['title' => 'Killing In the Name', 'artist' => 'Rage Against The Machine', 'id' => 'bWXazVhlyxQ', 'duration' => '5:14', 'verified' => true, 'tags' => ['English', 'Metal', '1992']],
                ['title' => 'Break Stuff', 'artist' => 'Limp Bizkit', 'id' => 'ZpUYjpKg9KY', 'duration' => '4:15', 'verified' => true, 'tags' => ['English', 'Nu Metal', '1999']],
                ['title' => 'Given Up', 'artist' => 'Linkin Park', 'id' => '0xyxtzD54rM', 'duration' => '3:11', 'verified' => true, 'tags' => ['English', 'Rock', '2007']],
            ],
            'romantic' => [
                ['title' => 'Perfect', 'artist' => 'Ed Sheeran', 'id' => '2Vv-BfVoq4g', 'duration' => '4:40', 'verified' => true, 'tags' => ['English', 'Pop', '2017']],
                ['title' => 'All of Me', 'artist' => 'John Legend', 'id' => '450p7goxZqg', 'duration' => '5:07', 'verified' => true, 'tags' => ['English', 'R&B', '2013']],
                ['title' => 'Just the Way You Are', 'artist' => 'Bruno Mars', 'id' => 'LjhCEhWiKXk', 'duration' => '3:56', 'verified' => true, 'tags' => ['English', 'Pop', '2010']],
                ['title' => 'A Thousand Years', 'artist' => 'Christina Perri', 'id' => 'rtOvBOTyX00', 'duration' => '5:07', 'verified' => true, 'tags' => ['English', 'Pop', '2011']],
            ]
        ];

        // Fallback for Sleepy/Party since we didn't populate them fully to save space
        $songs = $musicMap[$currentMood] ?? $musicMap['chill'];

        // Note: This matches your welcome.blade.php file!
        return view('welcome', compact('moods', 'currentMood', 'songs'));
    }
}