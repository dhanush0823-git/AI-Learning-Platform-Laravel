<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Modules;
use App\Models\Question;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Database\Seeder;

class CseAdditionalCoursesSeeder extends Seeder
{
    use SeedsRichCourseContent;

    public function run(): void
    {
        $department = Departments::query()->where('code', 'CSE')->first();

        if (! $department) {
            return;
        }

        $courses = [
            [
                'title' => 'PHP Web Development Masterclass',
                'description' => 'Learn PHP from fundamentals to practical web development with forms, sessions, MySQL integration, Laravel concepts, and deployment-ready project structure.',
                'difficulty' => 'beginner',
                'icon' => '🐘',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=OK_JCtrrv-c',
                'module_topics' => [
                    1 => ['PHP Setup', 'Syntax', 'Variables', 'Operators', 'Control Flow'],
                    2 => ['Functions', 'Arrays', 'Forms', 'Validation', 'Superglobals'],
                    3 => ['Sessions', 'Cookies', 'File Handling', 'Error Handling', 'Security Basics'],
                    4 => ['MySQL', 'CRUD', 'Prepared Statements', 'Authentication', 'Project Structure'],
                    5 => ['Laravel Intro', 'Routing', 'Blade', 'MVC', 'Deployment'],
                ],
                'module_details' => [
                    1 => [
                        'title' => 'Module 1: PHP Foundations and Environment Setup',
                        'description' => 'Set up a local PHP environment and understand the syntax, variables, operators, and control flow used in server-side scripting.',
                        'lessons' => [
                            ['title' => 'Introduction to PHP and Server-Side Development', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## What You Will Learn\nPHP runs on the server and generates HTML for the browser.\n\n### In this lesson\n- What PHP is used for\n- Why PHP is still relevant\n- How PHP powers dynamic websites\n\n### Key idea\nPHP lets us mix logic with templates so the page can respond to user input and database data."],
                            ['title' => 'Installing XAMPP and Running Your First PHP File', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=eL6T_yrmk-k', 'content' => "## Setup Walkthrough\nCreate a file like `hello.php` inside your web root and test it in the browser.\n\n```php\n<?php\necho 'Hello, PHP!';\n```\n\n### Goal\nMake sure Apache and PHP are working correctly on your machine."],
                            ['title' => 'PHP Syntax, Tags, and Output Statements', 'type' => 'reading', 'duration' => 14, 'video_url' => null, 'content' => "## Syntax Basics\nPHP code starts with `<?php` and ends when the file ends or a closing tag is reached.\n\n### Output methods\n- `echo`\n- `print`\n\n### Best practice\nUse clear formatting and keep PHP blocks readable inside HTML templates."],
                            ['title' => 'Variables, Constants, and Data Types', 'type' => 'video', 'duration' => 16, 'video_url' => 'https://www.youtube.com/watch?v=7TF00hJI78Y', 'content' => "## Working with Data\nPHP supports strings, integers, floats, booleans, arrays, and more.\n\n```php\n\$name = 'Asha';\n\$score = 92;\ndefine('APP_NAME', 'PHP Course');\n```\n\n### Focus\nKnow when to use variables versus constants."],
                            ['title' => 'Operators and Expressions in PHP', 'type' => 'reading', 'duration' => 13, 'video_url' => null, 'content' => "## Operators\nYou will use arithmetic, assignment, comparison, and logical operators often.\n\n### Examples\n- `\$a + \$b`\n- `\$age >= 18`\n- `\$isLoggedIn && \$isVerified`\n\n### Tip\nAlways write expressions that are easy to understand at a glance."],
                            ['title' => 'Conditional Statements and Decision Making', 'type' => 'video', 'duration' => 17, 'video_url' => 'https://www.youtube.com/watch?v=9h4dLxFhYwM', 'content' => "## Control Flow\nPHP uses `if`, `elseif`, `else`, and `switch` to branch logic.\n\n```php\nif (\$marks >= 50) {\n    echo 'Pass';\n} else {\n    echo 'Try again';\n}\n```"],
                            ['title' => 'Loops and Repeating Tasks in PHP', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Looping\nLoops help repeat actions over lists or ranges.\n\n### Common loops\n- `for`\n- `while`\n- `foreach`\n\n### Real use case\nRendering multiple products or users from an array."],
                            ['title' => 'Module 1 Practice Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => null, 'content' => "## Quick Check\nReview the setup process, syntax rules, variables, operators, and control flow before moving to the next module."],
                        ],
                    ],
                    2 => [
                        'title' => 'Module 2: Functions, Arrays, and Forms',
                        'description' => 'Build reusable logic using functions, organize data in arrays, and process browser forms safely with PHP.',
                        'lessons' => [
                            ['title' => 'Creating and Calling Functions in PHP', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Functions\nFunctions help organize code into reusable units.\n\n```php\nfunction greet(\$name) {\n    return \"Hello, \" . \$name;\n}\n```"],
                            ['title' => 'Parameters, Return Values, and Scope', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=Vx4dQ3S3QSE', 'content' => "## Function Design\nUnderstand local scope, arguments, and return values.\n\n### Best practice\nWrite small functions with one clear responsibility."],
                            ['title' => 'Indexed Arrays and Associative Arrays', 'type' => 'reading', 'duration' => 16, 'video_url' => null, 'content' => "## Arrays\nArrays store multiple values in one variable.\n\n```php\n\$skills = ['PHP', 'MySQL', 'Laravel'];\n\$user = ['name' => 'Ravi', 'role' => 'Student'];\n```"],
                            ['title' => 'Looping Through Arrays with foreach', 'type' => 'video', 'duration' => 14, 'video_url' => 'https://www.youtube.com/watch?v=q7x8Y6r2YJk', 'content' => "## foreach in practice\n`foreach` is the most common way to render arrays in views and templates."],
                            ['title' => 'Understanding HTML Forms and Request Methods', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Forms\nPHP often receives data from forms using `GET` and `POST`.\n\n### Common examples\n- Login forms\n- Contact forms\n- Search inputs"],
                            ['title' => 'Processing Form Data with Superglobals', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=O4rFMe5XcSE', 'content' => "## Superglobals\nUse `\$_GET`, `\$_POST`, `\$_REQUEST`, and `\$_SERVER` carefully.\n\n### Rule\nValidate all incoming data before using it."],
                            ['title' => 'Form Validation and User Feedback', 'type' => 'reading', 'duration' => 16, 'video_url' => null, 'content' => "## Validation\nGood validation improves security and user experience.\n\n### Validate\n- Required fields\n- Email format\n- Minimum length\n- Allowed values"],
                            ['title' => 'Module 2 Practice Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => null, 'content' => "## Quick Check\nTest your understanding of functions, arrays, forms, and validation."],
                        ],
                    ],
                    3 => [
                        'title' => 'Module 3: State, Files, and Security Basics',
                        'description' => 'Learn how PHP maintains user state, works with files, handles errors, and protects applications from common mistakes.',
                        'lessons' => [
                            ['title' => 'Sessions and Maintaining User Login State', 'type' => 'reading', 'duration' => 16, 'video_url' => null, 'content' => "## Sessions\nSessions help store temporary user data on the server.\n\n```php\nsession_start();\n\$_SESSION['user_id'] = 5;\n```"],
                            ['title' => 'Cookies and Remembering Browser Data', 'type' => 'video', 'duration' => 14, 'video_url' => 'https://www.youtube.com/watch?v=4Wc7JgB1z8M', 'content' => "## Cookies\nCookies store small values in the browser.\n\n### Use cases\n- Theme preferences\n- Remember me options\n- Lightweight tracking"],
                            ['title' => 'Reading and Writing Files in PHP', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## File Handling\nPHP can create, read, append, and manage files on the server.\n\n### Functions\n- `file_get_contents()`\n- `file_put_contents()`\n- `fopen()`"],
                            ['title' => 'Uploading Files Safely', 'type' => 'video', 'duration' => 17, 'video_url' => 'https://www.youtube.com/watch?v=7msJqPDoH1o', 'content' => "## Uploads\nWhen handling uploads, validate size, extension, and destination path carefully."],
                            ['title' => 'Error Handling and Debugging Techniques', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Debugging\nUse readable error messages, logs, and step-by-step checks.\n\n### Helpful tools\n- `var_dump()`\n- `print_r()`\n- Server logs"],
                            ['title' => 'Common Security Risks in PHP Apps', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=WY2oB8bJX9M', 'content' => "## Security Basics\nUnderstand XSS, SQL injection, insecure uploads, and weak validation.\n\n### Rule\nNever trust user input."],
                            ['title' => 'Escaping Output and Sanitizing Input', 'type' => 'reading', 'duration' => 14, 'video_url' => null, 'content' => "## Safer Output\nEscape anything that goes into HTML and sanitize data when needed before saving or displaying it."],
                            ['title' => 'Module 3 Practice Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => null, 'content' => "## Quick Check\nReview sessions, cookies, files, debugging, and security fundamentals."],
                        ],
                    ],
                    4 => [
                        'title' => 'Module 4: PHP with MySQL and CRUD Applications',
                        'description' => 'Connect PHP to a database, build CRUD workflows, and understand authentication and project structure.',
                        'lessons' => [
                            ['title' => 'Introduction to MySQL and Database Design', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Databases\nA database stores structured application data like users, products, or posts.\n\n### Concepts\n- Tables\n- Rows\n- Columns\n- Primary keys"],
                            ['title' => 'Connecting PHP to MySQL with mysqli and PDO', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=3B-Cnezwm7k', 'content' => "## Database Connection\nLearn to create reliable DB connections and separate credentials from app logic."],
                            ['title' => 'Creating Records with Insert Forms', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Create\nStart building CRUD by accepting form data and inserting records into the database."],
                            ['title' => 'Reading and Listing Database Records', 'type' => 'video', 'duration' => 17, 'video_url' => 'https://www.youtube.com/watch?v=3isdcAEZoq0', 'content' => "## Read\nDisplay rows from the database in an HTML table or card layout."],
                            ['title' => 'Updating and Deleting Records', 'type' => 'reading', 'duration' => 16, 'video_url' => null, 'content' => "## Update and Delete\nImplement edit forms and delete actions carefully, with validation and confirmation."],
                            ['title' => 'Prepared Statements and SQL Injection Prevention', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=nLinqtCfhKY', 'content' => "## Prepared Statements\nUse placeholders instead of string concatenation when building database queries."],
                            ['title' => 'Simple Authentication System with PHP', 'type' => 'reading', 'duration' => 17, 'video_url' => null, 'content' => "## Authentication\nCreate login, logout, password hashing, and protected pages.\n\n### Core pieces\n- `password_hash()`\n- `password_verify()`\n- sessions"],
                            ['title' => 'Module 4 Practice Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => null, 'content' => "## Quick Check\nTest CRUD concepts, database connections, and secure query handling."],
                        ],
                    ],
                    5 => [
                        'title' => 'Module 5: Laravel Basics and Modern PHP Workflow',
                        'description' => 'Finish the course by understanding the Laravel ecosystem, MVC structure, Blade templates, routing, and deployment basics.',
                        'lessons' => [
                            ['title' => 'Why Frameworks Matter in PHP Development', 'type' => 'reading', 'duration' => 14, 'video_url' => null, 'content' => "## Framework Thinking\nFrameworks help organize code, speed development, and encourage maintainable patterns."],
                            ['title' => 'Laravel Installation and Project Structure', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE', 'content' => "## Laravel Setup\nExplore folders like `routes`, `resources`, `app`, and `database` to understand project flow."],
                            ['title' => 'Routing and Controllers in Laravel', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Routing\nRoutes map URLs to controllers or closures.\n\n### Example\n```php\nRoute::get('/courses', [CourseController::class, 'index']);\n```"],
                            ['title' => 'Blade Templates and Dynamic Views', 'type' => 'video', 'duration' => 16, 'video_url' => 'https://www.youtube.com/watch?v=9xwazD5SyVg', 'content' => "## Blade\nBlade keeps templates clean while still allowing dynamic content and layout reuse."],
                            ['title' => 'Models, Migrations, and MVC Basics', 'type' => 'reading', 'duration' => 16, 'video_url' => null, 'content' => "## MVC Pattern\nLaravel separates concerns into Models, Views, and Controllers for maintainability."],
                            ['title' => 'Building a Small PHP Course Project', 'type' => 'video', 'duration' => 20, 'video_url' => 'https://www.youtube.com/watch?v=Y2bR7m4qg0E', 'content' => "## Mini Project\nBring together routes, views, forms, and database logic into a simple learning app feature."],
                            ['title' => 'Deployment, Debugging, and Next Steps', 'type' => 'reading', 'duration' => 15, 'video_url' => null, 'content' => "## Wrapping Up\nUnderstand local vs production environments, debug workflows, and how to continue your PHP journey."],
                            ['title' => 'Final Module Assessment and Course Review', 'type' => 'quiz', 'duration' => 10, 'video_url' => null, 'content' => "## Final Review\nThis final checkpoint helps you revise PHP basics, CRUD, security, and Laravel concepts."],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Web Development Foundations',
                'description' => 'Learn beginner-friendly web development concepts including HTML, CSS, JavaScript basics, and simple full-stack workflows.',
                'difficulty' => 'beginner',
                'icon' => '🌐',
                'duration' => '5 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['Web Basics', 'HTML Structure', 'Tags', 'Page Layout', 'Semantic HTML'],
                    2 => ['CSS Basics', 'Selectors', 'Box Model', 'Flexbox', 'Responsive Design'],
                    3 => ['JavaScript Basics', 'Variables', 'Functions', 'Events', 'DOM'],
                    4 => ['Forms', 'Validation', 'Browser Storage', 'Navigation', 'Debugging'],
                    5 => ['Frontend Workflow', 'Deployment', 'Version Control', 'Testing Basics', 'Accessibility'],
                ],
            ],
            [
                'title' => 'C Programming Essentials',
                'description' => 'Build beginner-level programming confidence with C syntax, control flow, functions, arrays, and problem-solving basics.',
                'difficulty' => 'beginner',
                'icon' => '💻',
                'duration' => '5 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['C Syntax', 'Variables', 'Data Types', 'Operators', 'Input Output'],
                    2 => ['Conditionals', 'Loops', 'Nested Logic', 'Switch Statements', 'Pattern Problems'],
                    3 => ['Functions', 'Parameters', 'Recursion', 'Scope', 'Return Values'],
                    4 => ['Arrays', 'Strings', 'Pointers Basics', 'Memory Concepts', 'Searching'],
                    5 => ['Structures', 'Files', 'Debugging', 'Compilation', 'Mini Programs'],
                ],
            ],
            [
                'title' => 'Computer Fundamentals',
                'description' => 'Understand essential computing concepts including hardware, software, operating systems, networking, and digital workflow basics.',
                'difficulty' => 'beginner',
                'icon' => '🖥️',
                'duration' => '4 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['Computer Basics', 'Hardware', 'Software', 'Input Devices', 'Output Devices'],
                    2 => ['Operating Systems', 'Processes', 'Files', 'Memory', 'Storage'],
                    3 => ['Networking Basics', 'Internet', 'Protocols', 'Browsers', 'Security Basics'],
                    4 => ['Productivity Tools', 'Documents', 'Spreadsheets', 'Presentations', 'Collaboration'],
                    5 => ['Troubleshooting', 'Maintenance', 'Backups', 'Updates', 'Digital Safety'],
                ],
            ],
            [
                'title' => 'Problem Solving with Programming',
                'description' => 'Practice beginner-friendly problem solving using algorithms, flowcharts, structured logic, and introductory coding patterns.',
                'difficulty' => 'beginner',
                'icon' => '🧩',
                'duration' => '5 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['Problem Analysis', 'Algorithms', 'Flowcharts', 'Pseudocode', 'Logic Building'],
                    2 => ['Sequence', 'Selection', 'Iteration', 'Decision Making', 'Tracing'],
                    3 => ['Functions', 'Modularity', 'Input Handling', 'Output Design', 'Testing'],
                    4 => ['Arrays', 'Strings', 'Basic Patterns', 'Counters', 'Accumulators'],
                    5 => ['Debugging', 'Optimization Basics', 'Edge Cases', 'Practice Problems', 'Review'],
                ],
            ],
            [
                'title' => 'Database Management Systems',
                'description' => 'Build intermediate-level DBMS skills with relational modeling, SQL, normalization, indexing, and transaction concepts.',
                'difficulty' => 'intermediate',
                'icon' => '🗄️',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['DBMS Basics', 'Data Models', 'Schemas', 'Keys', 'ER Modeling'],
                    2 => ['SQL Queries', 'Filtering', 'Joins', 'Aggregates', 'Subqueries'],
                    3 => ['Normalization', 'Functional Dependency', '1NF', '2NF', '3NF'],
                    4 => ['Indexing', 'Query Optimization', 'Execution Plans', 'Storage', 'Performance'],
                    5 => ['Transactions', 'Concurrency', 'Isolation', 'Recovery', 'Security'],
                ],
            ],
            [
                'title' => 'Object-Oriented Programming with Java',
                'description' => 'Learn intermediate object-oriented programming concepts with Java including classes, inheritance, polymorphism, exceptions, and collections.',
                'difficulty' => 'intermediate',
                'icon' => '☕',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['Java Basics', 'Classes', 'Objects', 'Methods', 'Constructors'],
                    2 => ['Encapsulation', 'Inheritance', 'Polymorphism', 'Abstraction', 'Interfaces'],
                    3 => ['Exception Handling', 'Packages', 'Access Modifiers', 'Static Members', 'Strings'],
                    4 => ['Collections', 'Lists', 'Sets', 'Maps', 'Iterators'],
                    5 => ['File Handling', 'Streams', 'Debugging', 'Testing', 'Mini Projects'],
                ],
            ],
            [
                'title' => 'Operating Systems Concepts',
                'description' => 'Explore intermediate operating system concepts such as scheduling, memory management, synchronization, file systems, and system security.',
                'difficulty' => 'intermediate',
                'icon' => '⚙️',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['OS Overview', 'Processes', 'Threads', 'System Calls', 'Scheduling Basics'],
                    2 => ['CPU Scheduling', 'Algorithms', 'Context Switching', 'Performance', 'Multitasking'],
                    3 => ['Deadlocks', 'Synchronization', 'Semaphores', 'Mutex', 'Concurrency'],
                    4 => ['Memory Management', 'Paging', 'Segmentation', 'Virtual Memory', 'Allocation'],
                    5 => ['File Systems', 'Security', 'Protection', 'Recovery', 'Case Studies'],
                ],
            ],
            [
                'title' => 'Computer Networks',
                'description' => 'Develop intermediate networking knowledge through network models, routing, transport protocols, addressing, and network security topics.',
                'difficulty' => 'intermediate',
                'icon' => '🌐',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE',
                'module_topics' => [
                    1 => ['Network Models', 'OSI', 'TCP IP', 'Layers', 'Devices'],
                    2 => ['Physical Layer', 'Data Link Layer', 'MAC', 'Switching', 'Ethernet'],
                    3 => ['IP Addressing', 'Subnetting', 'Routing', 'Routers', 'ICMP'],
                    4 => ['Transport Layer', 'TCP', 'UDP', 'Ports', 'Reliability'],
                    5 => ['Application Layer', 'DNS', 'HTTP', 'Security', 'Network Troubleshooting'],
                ],
            ],
        ];

        foreach ($courses as $courseData) {
            $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
                $courseData['title'],
                $courseData['youtube_link'] ?? null
            );

            $course = Course::updateOrCreate(
                ['title' => $courseData['title']],
                [
                    'description' => $courseData['description'],
                    'department_id' => $department->id,
                    'difficulty' => $courseData['difficulty'],
                    'icon' => $courseData['icon'],
                    'duration' => $courseData['duration'],
                    'youtube_link' => $courseData['youtube_link'],
                    'total_modules' => 5,
                ]
            );

            foreach (range(1, 5) as $moduleNumber) {
                $moduleDetails = $courseData['module_details'][$moduleNumber] ?? null;
                $module = Modules::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'module_number' => $moduleNumber,
                    ],
                    [
                        'title' => $moduleDetails['title'] ?? "Module {$moduleNumber}: {$course->title} Part {$moduleNumber}",
                        'description' => $moduleDetails['description'] ?? "Core learning content for module {$moduleNumber} in {$course->title}.",
                        'duration' => 120,
                        'completed' => false,
                    ]
                );

                $this->seedLessons($course, $module, $moduleDetails['lessons'] ?? null);
                $this->seedQuestions($department->id, $course, $module, $courseData['module_topics'][$moduleNumber] ?? []);
            }
        }
    }

    protected function seedLessons(Course $course, Modules $module, ?array $customLessons = null): void
    {
        $this->syncModuleLessons(
            $module,
            $course->title,
            $module->title,
            $module->description,
            [],
            $customLessons ?? [],
            10
        );
    }

    protected function seedQuestions(int $departmentId, Course $course, Modules $module, array $topics): void
    {
        foreach ($this->buildModuleQuestions($topics, $module->title) as $question) {
            Question::updateOrCreate(
                [
                    'department_id' => $departmentId,
                    'course_id' => $course->id,
                    'module_id' => $module->id,
                    'question_text' => $question['question_text'],
                ],
                [
                    'topic' => $question['topic'],
                    'difficulty_level' => $question['difficulty_level'],
                    'options' => $question['options'],
                    'correct_option' => $question['correct_option'],
                    'is_active' => true,
                ]
            );
        }
    }

    protected function buildModuleQuestions(array $topics, string $moduleLabel): array
    {
        $topics = array_values($topics);
        $questions = [];
        $variantLabels = ['Core Check', 'Practice Check', 'Concept Check', 'Quick Review', 'Module Mastery'];

        foreach ($variantLabels as $variantIndex => $variantLabel) {
            foreach ($topics as $topicIndex => $topic) {
                $questionNumber = ($variantIndex * count($topics)) + $topicIndex + 1;
                $difficulty = min(5, max(1, 1 + $topicIndex + $variantIndex));

                $questions[] = [
                    'topic' => $topic,
                    'difficulty_level' => $difficulty,
                    'question_text' => "{$moduleLabel} Question {$questionNumber} [{$variantLabel} - {$topic}]: Which statement best matches the core idea of {$topic}?",
                    'options' => [
                        "{$topic} focuses on the main concept taught in this module",
                        "{$topic} is only related to hardware troubleshooting",
                        "{$topic} completely removes the need for problem solving",
                        "{$topic} is unrelated to software systems",
                    ],
                    'correct_option' => "{$topic} focuses on the main concept taught in this module",
                ];
            }
        }

        return $questions;
    }
}
