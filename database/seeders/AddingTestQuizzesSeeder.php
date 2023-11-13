<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class AddingTestQuizzesSeeder extends Seeder
{
    public function run()
    {
        if (Quiz::count() > 0) {
            return;
        }

        //        Quiz::factory()
        //            ->has(Question::factory()->count(5))
        //            ->count(10)->create();
        $quizzes = [
            [
                'title' => 'Laravel Basics',
                'questions' => [
                    ['question' => 'Laravel is a PHP framework for web applications?', 'solution' => true],
                    ['question' => 'Laravel uses the "Wings" template engine by default?', 'solution' => false],
                    ['question' => 'Eloquent ORM in Laravel is used for database handling?', 'solution' => true],
                    ['question' => 'Laravel is a frontend framework?', 'solution' => false],
                    ['question' => 'Laravel was released after 2015?', 'solution' => false],
                ],
            ],
            [
                'title' => 'Test-Driven Development (TDD)',
                'questions' => [
                    ['question' => 'In TDD, tests are written after code is implemented?', 'solution' => false],
                    ['question' => 'TDD encourages simple designs and inspires confidence?', 'solution' => true],
                    ['question' => 'TDD is primarily a debugging method?', 'solution' => false],
                    ['question' => 'Refactoring is not a part of the TDD cycle?', 'solution' => false],
                    ['question' => 'TDD can lead to more modularized, flexible, and extensible code?', 'solution' => true],
                ],
            ],
            [
                'title' => 'DevOps Fundamentals',
                'questions' => [
                    ['question' => 'DevOps is only about automation of deployment?', 'solution' => false],
                    ['question' => 'Continuous Integration means merging all developers’ working copies to a shared mainline several times a day?', 'solution' => true],
                    ['question' => 'DevOps practices do not involve monitoring and logging?', 'solution' => false],
                    ['question' => 'Infrastructure as Code is a key practice in DevOps?', 'solution' => true],
                    ['question' => 'DevOps eliminates the need for system administrators?', 'solution' => false],
                ],
            ],
            [
                'title' => 'Git and GitFlow',
                'questions' => [
                    ['question' => 'GitFlow is a branching model for Git?', 'solution' => true],
                    ['question' => 'In GitFlow, the main branch contains the official release history?', 'solution' => true],
                    ['question' => 'Git is a distributed version control system?', 'solution' => true],
                    ['question' => 'Pull requests are not a feature in Git?', 'solution' => false],
                    ['question' => 'Git was created by Linus Torvalds for Linux kernel development?', 'solution' => true],
                ],
            ],
            [
                'title' => 'Programming Concepts',
                'questions' => [
                    ['question' => 'Polymorphism is a concept in Object-Oriented Programming?', 'solution' => true],
                    ['question' => 'JavaScript is a statically typed language?', 'solution' => false],
                    ['question' => 'Recursion is a method where a function calls itself?', 'solution' => true],
                    ['question' => 'HTML is a programming language?', 'solution' => false],
                    ['question' => 'In MVC architecture, the View handles the business logic?', 'solution' => false],
                ],
            ],
            [
                'title' => 'Software Development',
                'questions' => [
                    ['question' => 'Agile methodology encourages adaptive planning and evolutionary development?', 'solution' => true],
                    ['question' => 'Waterfall is an iterative software development process?', 'solution' => false],
                    ['question' => 'Scrum is a framework used in the development of software?', 'solution' => true],
                    ['question' => 'Pair programming is a practice where two programmers share one workstation?', 'solution' => true],
                    ['question' => 'Big-O notation is used to classify algorithms according to how their run time or space requirements grow as the input size grows?', 'solution' => true],
                ],
            ],
            [
                'title' => 'Cloud Computing',
                'questions' => [
                    ['question' => 'AWS stands for Amazon Web Services?', 'solution' => true],
                    ['question' => 'Cloud computing eliminates the need for physical servers?', 'solution' => false],
                    ['question' => 'In cloud computing, IaaS stands for Infrastructure as a Service?', 'solution' => true],
                    ['question' => 'Serverless computing means no servers are involved in the computing process?', 'solution' => false],
                    ['question' => 'Multi-tenancy is a common attribute of cloud computing?', 'solution' => true],
                ],
            ],
            [
                'title' => 'Database Management',
                'questions' => [
                    ['question' => 'SQL stands for Structured Query Language?', 'solution' => true],
                    ['question' => 'MongoDB is a relational database management system?', 'solution' => false],
                    ['question' => 'Normalization is a process in database design to reduce data redundancy?', 'solution' => true],
                    ['question' => 'A primary key can contain null values?', 'solution' => false],
                    ['question' => 'ACID properties ensure reliable transaction processing in databases?', 'solution' => true],
                ],
            ],
            [
                'title' => 'Web Development',
                'questions' => [
                    ['question' => 'CSS stands for Cascading Style Sheets?', 'solution' => true],
                    ['question' => 'HTML5 is the latest version of Hypertext Markup Language?', 'solution' => true],
                    ['question' => 'Responsive web design is not important in modern web development?', 'solution' => false],
                    ['question' => 'AJAX stands for Asynchronous JavaScript and XML?', 'solution' => true],
                    ['question' => 'WebSockets allow for full-duplex communication?', 'solution' => true],
                ],
            ],
            [
                'title' => 'Cybersecurity Basics',
                'questions' => [
                    ['question' => 'Phishing is a type of cyber attack?', 'solution' => true],
                    ['question' => 'A VPN provides end-to-end encryption for data transmission?', 'solution' => true],
                    ['question' => 'HTTPS encrypts the data sent between the web browser and server?', 'solution' => true],
                    ['question' => 'Using public Wi-Fi to access sensitive data is generally safe?', 'solution' => false],
                    ['question' => 'Two-factor authentication makes accounts less secure?', 'solution' => false],
                ],
            ],
        ];
        foreach ($quizzes as $quiz) {
            $newQuiz = Quiz::create(['title' => $quiz['title']]);
            foreach ($quiz['questions'] as $question) {
                $newQuiz->questions()->create($question);
            }
        }
    }
}
