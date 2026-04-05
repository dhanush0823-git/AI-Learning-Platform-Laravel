<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Question;
use Illuminate\Database\Seeder;

class ModuleQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $courseQuestionSets = [
            'Python Programming Basics' => [
                1 => $this->expandQuestions([
                    ['Python Syntax', 1, 'Which symbol is used to start a comment in Python?', ['#', '//', '/*', '--'], '#'],
                    ['Variables', 1, 'Which of these is a valid Python variable name?', ['student_name', '2value', 'total-score', 'class'], 'student_name'],
                    ['Data Types', 2, 'What is the output type of `3 / 2` in Python 3?', ['int', 'float', 'str', 'bool'], 'float'],
                    ['Printing', 1, 'Which function is commonly used to display output in Python?', ['print()', 'echo()', 'write()', 'show()'], 'print()'],
                    ['Case Sensitivity', 1, 'Python variable names are:', ['Case-sensitive', 'Always uppercase', 'Always lowercase', 'Not allowed'], 'Case-sensitive'],
                ], 'Python Basics'),
                2 => $this->expandQuestions([
                    ['Control Flow', 1, 'Which keyword is used for conditional branching in Python?', ['if', 'switch', 'case', 'when'], 'if'],
                    ['Loops', 2, 'Which loop is commonly used to iterate over a list in Python?', ['for', 'repeat', 'loop', 'do-while'], 'for'],
                    ['Loop Control', 2, 'Which statement skips the rest of the current loop iteration?', ['continue', 'break', 'pass', 'return'], 'continue'],
                    ['Comparisons', 2, 'Which operator checks equality in Python?', ['==', '=', '!=', ':='], '=='],
                    ['Ranges', 2, 'What does `range(3)` produce in a loop?', ['0, 1, 2', '1, 2, 3', '0, 1, 2, 3', '3 only'], '0, 1, 2'],
                ], 'Control Flow'),
                3 => $this->expandQuestions([
                    ['Functions', 2, 'Which keyword is used to define a function in Python?', ['def', 'function', 'fun', 'lambda'], 'def'],
                    ['Parameters', 2, 'What is a default parameter in Python?', ['A parameter with a preset value', 'A parameter that cannot be changed', 'A parameter stored globally', 'A parameter used only in loops'], 'A parameter with a preset value'],
                    ['Return Values', 3, 'What does a Python function return if there is no `return` statement?', ['None', '0', 'False', 'An error'], 'None'],
                    ['Arguments', 2, 'What do we call the values passed into a function call?', ['Arguments', 'Modules', 'Classes', 'Loops'], 'Arguments'],
                    ['Lambda', 3, 'A lambda function in Python is best described as:', ['An anonymous function', 'A loop structure', 'A file handler', 'A class decorator'], 'An anonymous function'],
                ], 'Functions'),
                4 => $this->expandQuestions([
                    ['Lists', 2, 'Which method adds an element to the end of a list?', ['append()', 'add()', 'push()', 'insertEnd()'], 'append()'],
                    ['Dictionaries', 3, 'Which data structure stores key-value pairs in Python?', ['dictionary', 'tuple', 'set', 'list'], 'dictionary'],
                    ['Tuples', 3, 'What is true about tuples in Python?', ['They are immutable', 'They can only store numbers', 'They always have two items', 'They are slower than lists because they are dynamic'], 'They are immutable'],
                    ['Sets', 2, 'Which collection automatically removes duplicate values?', ['set', 'list', 'tuple', 'dict'], 'set'],
                    ['Indexing', 2, 'Which index accesses the first item in a Python list?', ['0', '1', '-1', 'first'], '0'],
                ], 'Collections'),
                5 => $this->expandQuestions([
                    ['File Handling', 2, 'Which mode is used to open a file for reading in Python?', ['r', 'w', 'a', 'x'], 'r'],
                    ['Exceptions', 3, 'Which block is used to handle errors in Python?', ['except', 'catch', 'error', 'final'], 'except'],
                    ['Modules', 3, 'Which keyword is used to include a module in Python?', ['import', 'include', 'require', 'using'], 'import'],
                    ['Packages', 3, 'What is a Python package?', ['A folder of Python modules', 'A loop keyword', 'A built-in data type', 'A comment block'], 'A folder of Python modules'],
                    ['Cleanup', 3, 'Which block runs whether an exception occurs or not?', ['finally', 'except', 'raise', 'assert'], 'finally'],
                ], 'Files and Modules'),
            ],
            'Data Structures & Algorithms' => [
                1 => $this->expandQuestions([
                    ['Arrays', 2, 'Which data structure stores elements in contiguous memory locations?', ['Array', 'Tree', 'Graph', 'Heap'], 'Array'],
                    ['Time Complexity', 2, 'What is the time complexity of accessing an element by index in an array?', ['O(1)', 'O(log n)', 'O(n)', 'O(n log n)'], 'O(1)'],
                    ['Searching', 3, 'Which search algorithm requires the data to be sorted first?', ['Binary Search', 'Linear Search', 'Depth-First Search', 'Breadth-First Search'], 'Binary Search'],
                    ['Insertion', 2, 'Inserting an element at the beginning of an array usually requires:', ['Shifting existing elements', 'No extra work', 'Hashing the array', 'Balancing the tree'], 'Shifting existing elements'],
                    ['Traversal', 2, 'Visiting every element of an array one by one is called:', ['Traversal', 'Compilation', 'Recursion', 'Hashing'], 'Traversal'],
                ], 'Arrays'),
                2 => $this->expandQuestions([
                    ['Linked Lists', 2, 'What does each node in a singly linked list contain?', ['Data and a pointer to the next node', 'Only data', 'Pointers to previous nodes only', 'A fixed-size array'], 'Data and a pointer to the next node'],
                    ['Stacks', 2, 'Which principle does a stack follow?', ['LIFO', 'FIFO', 'Round Robin', 'Greedy'], 'LIFO'],
                    ['Queues', 2, 'Which principle does a queue follow?', ['FIFO', 'LIFO', 'Divide and Conquer', 'Backtracking'], 'FIFO'],
                    ['Stack Operations', 2, 'Which operation removes the top element from a stack?', ['pop', 'push', 'enqueue', 'peek'], 'pop'],
                    ['Queue Operations', 2, 'Which operation adds an element to a queue?', ['enqueue', 'push', 'pop', 'peek'], 'enqueue'],
                ], 'Linked Structures'),
                3 => $this->expandQuestions([
                    ['Trees', 3, 'What is the topmost node in a tree called?', ['Root', 'Leaf', 'Parent', 'Edge'], 'Root'],
                    ['Binary Search Trees', 3, 'In a binary search tree, where are smaller values stored relative to a node?', ['Left subtree', 'Right subtree', 'Both sides equally', 'Only in leaves'], 'Left subtree'],
                    ['Tree Traversal', 4, 'Which traversal visits left subtree, root, then right subtree?', ['Inorder', 'Preorder', 'Postorder', 'Level order'], 'Inorder'],
                    ['Leaves', 3, 'A node with no children is called a:', ['Leaf', 'Root', 'Bridge', 'Forest'], 'Leaf'],
                    ['Height', 4, 'Tree height is generally measured as the number of edges on the longest path from the root to a:', ['Leaf', 'Sibling', 'Queue', 'Array'], 'Leaf'],
                ], 'Trees'),
                4 => $this->expandQuestions([
                    ['Sorting', 3, 'Which sorting algorithm repeatedly swaps adjacent elements if they are in the wrong order?', ['Bubble Sort', 'Merge Sort', 'Quick Sort', 'Heap Sort'], 'Bubble Sort'],
                    ['Merge Sort', 4, 'What is the average time complexity of merge sort?', ['O(n log n)', 'O(n^2)', 'O(log n)', 'O(n)'], 'O(n log n)'],
                    ['Quick Sort', 4, 'Quick sort mainly works using which strategy?', ['Divide and conquer', 'Dynamic programming', 'Greedy', 'Backtracking'], 'Divide and conquer'],
                    ['Selection Sort', 3, 'Selection sort works by repeatedly selecting the:', ['Smallest remaining element', 'Middle element', 'Largest hash key', 'Root node'], 'Smallest remaining element'],
                    ['Stability', 4, 'Which of these algorithms is commonly considered stable in its standard form?', ['Merge Sort', 'Quick Sort', 'Heap Sort', 'Selection Sort'], 'Merge Sort'],
                ], 'Sorting'),
                5 => $this->expandQuestions([
                    ['Graphs', 3, 'What does BFS stand for in graph traversal?', ['Breadth-First Search', 'Binary-First Search', 'Branch-First Search', 'Base-First Search'], 'Breadth-First Search'],
                    ['Graphs', 4, 'Which data structure is commonly used to implement BFS?', ['Queue', 'Stack', 'Heap', 'Set'], 'Queue'],
                    ['Algorithm Design', 4, 'Dijkstra\'s algorithm is primarily used for solving which problem?', ['Shortest path in a weighted graph', 'Sorting an array', 'Finding a minimum spanning tree only', 'Balancing a binary tree'], 'Shortest path in a weighted graph'],
                    ['DFS', 3, 'Depth-first search typically uses which data structure internally?', ['Stack', 'Queue', 'Array only', 'Hash map'], 'Stack'],
                    ['Weighted Graphs', 4, 'An edge with an associated cost or distance belongs to a:', ['Weighted graph', 'Binary tree', 'Circular queue', 'Static array'], 'Weighted graph'],
                ], 'Graphs and Algorithms'),
            ],
        ];

        foreach ($courseQuestionSets as $courseTitle => $modules) {
            $course = Course::query()
                ->with(['department', 'modules'])
                ->where('title', $courseTitle)
                ->first();

            if (! $course || ! $course->department) {
                continue;
            }

            foreach ($modules as $moduleNumber => $questions) {
                $module = $course->modules->firstWhere('module_number', $moduleNumber);

                if (! $module) {
                    continue;
                }

                foreach ($questions as $question) {
                    Question::updateOrCreate(
                        [
                            'department_id' => $course->department_id,
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
        }
    }

    protected function expandQuestions(array $baseQuestions, string $moduleLabel): array
    {
        $questions = [];
        $variants = [
            1 => 'Core Check',
            2 => 'Practice Check',
            3 => 'Concept Check',
            4 => 'Quick Review',
            5 => 'Module Mastery',
        ];

        foreach ($variants as $variantIndex => $variantLabel) {
            foreach ($baseQuestions as $questionIndex => [$topic, $difficulty, $text, $options, $correctOption]) {
                $questions[] = [
                    'topic' => $topic,
                    'difficulty_level' => min(5, $difficulty + max(0, $variantIndex - 3)),
                    'question_text' => sprintf(
                        '%s %d [%s - %s]: %s',
                        $moduleLabel,
                        ($questionIndex + 1) + (($variantIndex - 1) * count($baseQuestions)),
                        $variantLabel,
                        $topic,
                        $text
                    ),
                    'options' => $options,
                    'correct_option' => $correctOption,
                ];
            }
        }

        return $questions;
    }
}
