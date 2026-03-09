<?php

namespace Database\Seeders;

use App\Models\Departments;
use App\Models\DiagnosticQuestion;
use Illuminate\Database\Seeder;

class DepartmentDiagnosticQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questionBank = $this->questionBank();

        foreach ($questionBank as $departmentCode => $config) {
            $department = Departments::firstOrCreate(
                ['code' => $departmentCode],
                [
                    'name' => $config['department_name'],
                    'icon' => null,
                    'color' => null,
                ]
            );

            foreach ($config['questions'] as $item) {
                DiagnosticQuestion::updateOrCreate(
                    [
                        'department_id' => $department->id,
                        'question' => $item['question'],
                    ],
                    [
                        'option_a' => $item['a'],
                        'option_b' => $item['b'],
                        'option_c' => $item['c'],
                        'option_d' => $item['d'],
                        'correct_option' => strtolower($item['correct']),
                        'level' => $item['level'] ?? 'beginner',
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    private function questionBank(): array
    {
        return [
            'CSE' => [
                'department_name' => 'Computer Science & Engineering',
                'questions' => [
                    $this->q('What is a computer program?', 'A physical part of the computer', 'A collection of instructions that performs a specific task', 'A type of computer mouse', 'The plastic casing of a monitor', 'B'),
                    $this->q('What is a variable in programming?', 'A value that never changes', 'A storage location paired with an associated symbolic name', 'A permanent hardware component', 'An error in the code', 'B'),
                    $this->q('What is the use of an algorithm?', 'To decorate a website', 'To provide a step-by-step procedure for solving a problem', 'To increase the weight of a laptop', 'To replace the power supply', 'B'),
                    $this->q('What is a data structure?', 'A way of organizing and storing data for efficient access', 'A physical building for computers', 'A type of keyboard layout', 'The electrical wiring in a CPU', 'A'),
                    $this->q('What is an array?', 'A single variable that can store only one letter', 'A collection of items stored at contiguous memory locations', 'A wireless internet connection', 'A specialized computer screen', 'B'),
                    $this->q('What is a loop in programming?', 'A mistake that crashes the computer', 'A sequence of instructions that repeats until a condition is met', 'A circular piece of hardware', 'A way to turn off the computer', 'B'),
                    $this->q('What is a function?', 'A reusable block of code that performs a specific action', 'The power button on a laptop', 'A type of computer virus', 'A social event for programmers', 'A'),
                    $this->q('What is a database?', 'A folder on a desktop', 'An organized collection of structured information or data', 'A hardware device for printing', 'A type of internet browser', 'B'),
                    $this->q('What does CPU stand for?', 'Central Processing Unit', 'Computer Personal Unit', 'Central Printing User', 'Core Programming Utility', 'A'),
                    $this->q('What is an operating system?', 'Software that manages computer hardware and software resources', 'A program used only for typing letters', 'The physical metal case of a computer', 'A website for downloading games', 'A'),
                    $this->q('What is the purpose of a compiler?', 'To clean the computer fan', 'To translate high-level code into machine code', 'To connect the computer to the internet', 'To act as a digital camera', 'B'),
                    $this->q('What is HTML used for?', 'Creating complex 3D games', 'Structuring web pages and their content', 'Editing high-definition videos', 'Calculating large mathematical formulas', 'B'),
                    $this->q('What is the Internet?', 'A local folder on your PC', 'A global network of computers communicating via protocols', 'A type of software like Microsoft Word', 'A specific brand of laptop', 'B'),
                    $this->q('What is a computer network?', 'A group of computers linked together to share resources', 'A single computer used by one person', 'A television broadcasting system', 'A collection of computer books', 'A'),
                    $this->q('What is cloud computing in simple terms?', 'Storing data on a local USB drive', 'Delivering computing services over the internet', 'Using a computer while outdoors', 'Weather forecasting using computers', 'B'),
                    $this->q('What is artificial intelligence?', 'A robot that can eat food', 'Simulation of human intelligence by machines', 'A computer that never needs electricity', 'A human pretending to be a computer', 'B'),
                    $this->q('What is the difference between hardware and software?', 'Hardware is virtual; software is physical', 'Hardware is the physical parts; software is the set of instructions', 'There is no difference', 'Hardware is for games; software is for work', 'B'),
                    $this->q('What is input and output in computing?', 'Input is what the computer gives; Output is what you give', 'Input is data sent to the computer; Output is data sent from it', 'Input is the power cord; Output is the screen', 'Input is the keyboard; Output is only the mouse', 'B'),
                    $this->q('Explain the difference between stack and queue.', 'Stack is FIFO; Queue is LIFO', 'Stack is LIFO (Last-In-First-Out); Queue is FIFO (First-In-First-Out)', 'Both are exactly the same', 'Stack is for storage; Queue is for deleting', 'B', 'intermediate'),
                    $this->q('What is object-oriented programming?', 'Programming based on "objects" which contain data and code', 'Programming without using any variables', 'A way to build physical objects using a 3D printer', 'A method used only for designing icons', 'A', 'intermediate'),
                    $this->q('What is recursion in programming?', 'A process where a function calls itself', 'A way to stop a program from running', 'An error that deletes all files', 'A type of hardware upgrade', 'A', 'intermediate'),
                    $this->q('What is normalization in databases?', 'Increasing data redundancy', 'Organizing data to reduce redundancy and improve integrity', 'Deleting the entire database', 'Changing the language of the database', 'B', 'intermediate'),
                    $this->q('What is the OSI model in networking?', 'A type of computer monitor', 'A conceptual model that characterizes communication functions', 'A specific type of internet cable', 'An operating system for servers', 'B', 'intermediate'),
                    $this->q('What is multithreading?', 'Using multiple monitors at once', 'The ability of a CPU to provide multiple threads of execution concurrently', 'Connecting multiple computers with a single wire', 'Sewing computer parts together', 'B', 'intermediate'),
                    $this->q('Explain the concept of algorithm complexity.', 'How many colors an algorithm uses', 'The amount of resources (time/space) required by an algorithm', 'How difficult it is for a human to read the code', 'The number of lines of code in a program', 'B', 'intermediate'),
                ],
            ],
            'IT' => [
                'department_name' => 'Information Technology',
                'questions' => [
                    $this->q('What is Information Technology?', 'The study of history and art', 'The use of systems for storing, retrieving, and sending information', 'The process of building furniture', 'Only using a mobile phone', 'B'),
                    $this->q('What are input and output devices?', 'Devices that only store data', 'Hardware used to provide data to and receive data from a computer', 'Parts of the computer that never touch electricity', 'Only the keyboard and monitor', 'B'),
                    $this->q('What is a variable in programming?', 'A mathematical constant', 'A symbolic name for a value that can change', 'A type of hardware cable', 'A computer screen setting', 'B'),
                    $this->q('What is a web browser?', 'A search engine like Google', 'An application used to access and view websites', 'A type of virus protection', 'The physical internet cable', 'B'),
                    $this->q('What is HTML?', 'A high-speed internet connection', 'The standard markup language for creating web pages', 'A type of computer hardware', 'A database management tool', 'B'),
                    $this->q('What is a database table?', 'A physical desk for computers', 'A collection of related data held in a structured format within a database', 'A list of computer parts', 'A furniture item in a server room', 'B'),
                    $this->q('What is a computer network?', 'A single workstation', 'A system that connects multiple computers to share data', 'A social media platform', 'A collection of computer books', 'B'),
                    $this->q('What is cybersecurity?', 'Building faster computers', 'Protecting systems and networks from digital attacks', 'Buying insurance for laptops', 'Using a computer in a secure room', 'B'),
                    $this->q('What is cloud computing?', 'Using a computer during a storm', 'Storing and accessing data over the internet instead of a hard drive', 'A type of weather satellite', 'A hardware device for cooling servers', 'B'),
                    $this->q('What is a programming language?', 'A way to talk to other humans', 'A formal language used to give instructions to a computer', 'The language used in computer manuals', 'A type of foreign language like Spanish', 'B'),
                    $this->q('What is a server?', 'A person who fixes computers', 'A computer or system that provides resources/data to other computers', 'A type of computer mouse', 'A software for editing photos', 'B'),
                    $this->q('What is version control?', 'Controlling the volume of the computer', 'Tracking and managing changes to software code', 'Updating the operating system every day', 'Checking the battery life of a laptop', 'B', 'intermediate'),
                    $this->q('What is DNS in networking?', 'Digital Network System', 'Domain Name System, which translates domain names to IP addresses', 'Data Node Service', 'Direct Network Serial', 'B', 'intermediate'),
                    $this->q('What is a REST API?', 'A way for computers to sleep', 'An architectural style for providing standards between computer systems', 'A type of computer keyboard', 'A method for charging batteries', 'B', 'intermediate'),
                    $this->q('Explain CI/CD in DevOps.', 'Computer Integration / Computer Design', 'Continuous Integration and Continuous Deployment', 'Circuit Integration / Current Design', 'Coding Intelligence / Coding Delivery', 'B', 'intermediate'),
                    $this->q('What is the Internet used for?', 'Only for playing offline games', 'Communication, information sharing, and commerce globally', 'Only for turning on the computer', 'Measuring the temperature of a room', 'B'),
                    $this->q('What is an operating system?', 'A piece of hardware', 'Software that manages computer hardware and software resources', 'A specific type of website', 'A computer repair toolkit', 'B'),
                    $this->q('What is a client in networking?', 'The person who pays for the internet', 'A device or software that accesses a service made available by a server', 'A type of network cable', 'A computer that is turned off', 'B'),
                    $this->q('What is a file system?', 'A physical cabinet for papers', 'The method used by an OS to organize and store files on a disk', 'A type of programming language', 'A way to send emails', 'B', 'intermediate'),
                    $this->q('What is data backup?', 'Moving files to the recycle bin', 'Creating a copy of data to recover it in case of loss', 'Deleting old files to save space', 'Typing data backwards', 'B', 'intermediate'),
                    $this->q('What is software installation?', 'Deleting a program', 'The process of making a program ready for execution on a computer', 'Buying a new computer', 'Cleaning the computer screen', 'B', 'intermediate'),
                    $this->q('What is virtualization?', 'Creating a physical copy of a computer', 'Creating a virtual version of something, like an OS or server', 'Playing video games in VR', 'Updating software drivers', 'B', 'intermediate'),
                    $this->q('Explain the OSI model layers.', 'It has 3 layers for power management', 'It has 7 layers defining how data is sent over a network', 'It has 5 layers for hardware design', 'It is a single layer for software code', 'B', 'intermediate'),
                    $this->q('What is encryption?', 'Deleting sensitive data', 'Converting information into a code to prevent unauthorized access', 'Increasing the brightness of the screen', 'Saving a file in a different folder', 'B', 'intermediate'),
                    $this->q('What is containerization in IT systems?', 'Putting computers in metal boxes', 'Packaging software code with all its dependencies to run anywhere', 'Storing data on physical shipping containers', 'A way to organize folders on a desktop', 'B', 'intermediate'),
                ],
            ],
            'ECE' => [
                'department_name' => 'Electronics & Communication Engineering',
                'questions' => [
                    $this->q('What is electricity?', 'The flow of water', 'The set of physical phenomena associated with the presence of charge', 'A type of solid fuel', 'The movement of air', 'B'),
                    $this->q('What is voltage?', 'The speed of light', 'The electric potential difference between two points', 'The amount of copper in a wire', 'The weight of a battery', 'B'),
                    $this->q('What is current?', 'The age of a circuit', 'The rate of flow of electric charge', 'The resistance to electricity', 'The physical size of a wire', 'B'),
                    $this->q('What is resistance?', 'A measure of the opposition to current flow in a circuit', 'The ability to store energy', 'The power output of a motor', 'The length of a cable', 'A'),
                    $this->q("What is Ohm's Law?", 'V = I x R', 'F = M x A', 'E = MC^2', 'P = V x I', 'A'),
                    $this->q('What is a diode?', 'A device that allows current to flow in both directions', 'A semiconductor device that primarily allows current to flow in one direction', 'A type of battery', 'A switch used to turn off lights', 'B'),
                    $this->q('What is a transistor?', 'A long-distance radio', 'A semiconductor device used to amplify or switch electrical signals', 'A physical wire connector', 'A type of light bulb', 'B'),
                    $this->q('What is a logic gate?', 'A physical gate in a fence', 'An idealized model of computation that implements a Boolean function', 'A way to lock a computer room', 'A software for writing logic puzzles', 'B'),
                    $this->q('What is a digital signal?', 'A signal that is continuous in time', 'A signal that represents data as a sequence of discrete values', 'A signal used only by old radios', 'A physical wave in the ocean', 'B'),
                    $this->q('What is an analog signal?', 'A signal represented by 0s and 1s', 'A continuous signal for which the time-varying feature represents some other time-varying quantity', 'A signal that is either ON or OFF', 'A type of battery charging method', 'B'),
                    $this->q('What is a capacitor?', 'A device that resists all current', 'A component that stores electrical energy in an electric field', 'A type of electrical wire', 'A device that converts AC to DC', 'B'),
                    $this->q('What is binary number system?', 'A system using numbers 1 to 10', 'A base-2 numbering system that uses only 0 and 1', 'A system for naming binary stars', 'A way to count using alphabet letters', 'B'),
                    $this->q('Explain the difference between AC and DC current.', 'AC is for batteries; DC is for walls', 'AC changes direction periodically; DC flows in a single direction', 'AC is safe; DC is dangerous', 'There is no difference', 'B', 'intermediate'),
                    $this->q('What is Boolean algebra in digital electronics?', 'Algebra involving complex numbers', 'A branch of algebra where variables are either True or False (1 or 0)', 'A way to calculate the cost of electronics', 'A method for designing circuit boards', 'B', 'intermediate'),
                    $this->q('What is an embedded system?', 'A computer that is buried underground', 'A dedicated computer system with a specific function within a larger mechanical or electrical system', 'A type of memory card', 'A system for building software apps', 'B', 'intermediate'),
                    $this->q('What is communication in electronics?', 'People talking to each other', 'The transmission, reception, and processing of information using electronic circuits', 'Writing code for a website', 'Fixing a broken television', 'B'),
                    $this->q('What is a microprocessor?', 'A small microscope', 'An integrated circuit that contains all the functions of a CPU', 'A type of electrical motor', 'A device that only stores memory', 'B'),
                    $this->q('What is a sensor?', 'A device that produces electricity from nothing', 'A device that detects and responds to some type of input from the physical environment', 'A type of electrical switch', 'A heavy metal shield for circuits', 'B'),
                    $this->q('What is a resistor?', 'A component that increases the current', 'A passive electrical component that implements electrical resistance', 'A device that generates power', 'A type of electronic display', 'B'),
                    $this->q('What is a circuit?', 'A square shape in geometry', 'A path in which electrons from a voltage or current source flow', 'A type of computer program', 'The outer shell of a computer', 'B'),
                    $this->q('What is modulation?', 'Changing the size of a circuit', 'The process of varying one or more properties of a periodic waveform to transmit information', 'Turning a device on and off quickly', 'Cleaning electronic components', 'B', 'intermediate'),
                    $this->q('What is a flip-flop circuit?', 'A circuit that turns on and off randomly', 'A circuit that has two stable states and can be used to store state information', 'A type of summer footwear', 'A circuit used to reverse gravity', 'B', 'intermediate'),
                    $this->q('Explain amplitude modulation (AM).', 'Changing the frequency of a signal', 'Varying the strength (amplitude) of the carrier signal to transmit information', 'Changing the color of a light signal', 'Increasing the volume of a speaker', 'B', 'intermediate'),
                    $this->q('What is pulse code modulation (PCM)?', "A way to measure a person's pulse", 'A method used to digitally represent sampled analog signals', 'A type of electrical motor', 'A coding language for circuits', 'B', 'intermediate'),
                    $this->q('Explain the role of antennas in communication systems.', 'To provide power to the circuit', 'To convert electrical signals into radio waves and vice versa', 'To decorate the outside of a building', 'To cool down electronic devices', 'B', 'intermediate'),
                ],
            ],
            'AERO' => [
                'department_name' => 'Aeronautical Engineering',
                'questions' => [
                    $this->q('What are the four forces of flight?', 'Speed, Weight, Pressure, Gravity', 'Lift, Weight, Thrust, and Drag', 'Acceleration, Mass, Friction, Lift', 'Height, Velocity, Drag, Fuel', 'B'),
                    $this->q('What is lift in aviation?', 'The force that pulls an aircraft down', 'The force that directly opposes the weight of an airplane and holds it in the air', 'The engine power', 'The air resistance', 'B'),
                    $this->q('What is drag?', 'The force pulling the plane forward', 'The air resistance that tends to slow an aircraft down', 'The weight of the passengers', 'The upward force on the wings', 'B'),
                    $this->q('What is thrust?', 'The force that pulls the plane down', 'The forward force produced by the engines to overcome drag', 'The resistance of the air', 'The movement of the wings', 'B'),
                    $this->q('What is gravity in flight?', 'The force pulling the aircraft toward the Earth', 'The force making the plane fly faster', 'The air pressure above the wing', 'The fuel used by the engine', 'A'),
                    $this->q('What does aerodynamics study?', 'The study of space travel', 'The way air moves around things', 'The study of engine parts', 'The study of aircraft tires', 'B'),
                    $this->q('What is a wing in an aircraft?', 'A decoration for the plane', 'An airfoil that creates lift when moved through the air', 'The place where the pilot sits', 'The wheels used for landing', 'B'),
                    $this->q('What is a jet engine?', 'An engine that uses a propeller', 'A reaction engine discharging a fast-moving jet that generates thrust', 'A type of electric battery', 'An engine that only works on the ground', 'B'),
                    $this->q('What is a rocket?', 'A very fast car', 'A vehicle that obtains thrust from a rocket engine and carries its own oxidizer', 'A type of airplane with wings', 'A balloon filled with air', 'B'),
                    $this->q('What is a satellite?', 'A high-altitude airplane', 'An object that has been intentionally placed into orbit', 'A type of telescope on Earth', 'A bright star in the sky', 'B'),
                    $this->q('What is Bernoulli\'s principle?', 'For every action, there is an equal reaction', 'An increase in the speed of a fluid occurs simultaneously with a decrease in pressure', 'Objects in motion stay in motion', 'Gravity pulls everything down', 'B'),
                    $this->q("What is Newton's second law?", 'E = MC^2', 'F = ma (Force equals mass times acceleration)', 'Energy cannot be destroyed', 'For every action there is a reaction', 'B'),
                    $this->q('Explain the difference between turbofan and turbojet engines.', 'One uses gasoline, the other uses diesel', 'Turbofans have a large fan at the front for bypass air, making them more efficient', 'Turbojets are only used for small cars', 'There is no difference', 'B', 'intermediate'),
                    $this->q('Explain rocket propulsion.', 'Using wind to move a rocket', "Producing thrust by ejecting mass at high speed according to Newton's third law", 'Using a giant rubber band', 'Pulling a rocket with a rope', 'B', 'intermediate'),
                    $this->q('What is avionics in aerospace engineering?', 'The study of birds', 'The electronic systems used on aircraft and spacecraft', 'The design of airplane seats', 'The fuel used in jet engines', 'B', 'intermediate'),
                    $this->q('What is the fuselage of an aircraft?', 'The tail section', 'The main body section that holds crew, passengers, or cargo', 'The engine cover', 'The wing tip', 'B'),
                    $this->q('What is propulsion?', 'The study of wings', 'The action of driving or pushing forward an object', 'The way a plane lands', 'The communication system of a plane', 'B'),
                    $this->q('What is air pressure?', 'The weight of the airplane', 'The force exerted by the weight of air molecules', 'The temperature of the clouds', 'The speed of the wind', 'B'),
                    $this->q('What is an orbit?', 'A straight line through space', 'The curved path of a celestial object or spacecraft around a star, planet, or moon', 'The fuel tank of a rocket', 'The landing strip for a shuttle', 'B'),
                    $this->q('What is space exploration?', 'Looking at stars with a binoculars', 'The use of astronomy and space technology to explore outer space', 'Flying a plane at high altitudes', 'Traveling to different countries', 'B'),
                    $this->q('What is a launch vehicle?', 'A truck that carries airplanes', "A rocket-propelled vehicle used to carry a payload from Earth's surface into space", 'The ramp used by skaters', 'A type of fuel', 'B', 'intermediate'),
                    $this->q('What is aircraft stability?', 'How heavy the aircraft is', 'The tendency of an aircraft to return to its original flight path after a disturbance', 'How many passengers can fit', 'The color of the aircraft', 'B', 'intermediate'),
                    $this->q('What is boundary layer in aerodynamics?', 'The edge of the atmosphere', 'The layer of fluid in the immediate vicinity of a bounding surface', 'The fence around an airport', 'The paint on the wings', 'B', 'intermediate'),
                    $this->q('What are composite materials used in aircraft?', 'Simple blocks of wood', 'Materials made from two or more constituent materials to be lightweight and strong', 'Only pure iron', 'Recycled plastic bottles', 'B', 'intermediate'),
                    $this->q('Explain the concept of orbital velocity.', 'The speed of a car on a track', 'The velocity at which a body revolves around another body', 'The speed of sound', 'The speed needed to stop a rocket', 'B', 'intermediate'),
                ],
            ],
            'AIML' => [
                'department_name' => 'Artificial Intelligence & Machine Learning',
                'questions' => [
                    $this->q('What is Artificial Intelligence?', 'A human with a computer brain', 'The simulation of human intelligence processes by machines', 'A robot that acts exactly like a cat', 'A really fast calculator', 'B'),
                    $this->q('What is Machine Learning?', 'Teaching a machine how to clean itself', 'A subset of AI that allows systems to learn from data and improve from experience', 'Buying new parts for a computer', 'A type of exercise for robots', 'B'),
                    $this->q('What is Python programming language?', 'A language used to talk to snakes', 'A high-level, general-purpose programming language widely used in AI/ML', 'A type of hardware cable', 'A computer virus', 'B'),
                    $this->q('What is a dataset?', 'A set of clothes for a robot', 'A collection of related sets of information that is composed of separate elements', 'A desk where you use a computer', 'A type of internet connection', 'B'),
                    $this->q('What is data in computing?', 'Information processed or stored by a computer', 'Only the numbers 1 and 2', 'The physical weight of the CPU', 'The electricity used by a laptop', 'A'),
                    $this->q('What is a neural network?', 'A network of wires in a house', 'A series of algorithms that endeavors to recognize underlying relationships in a set of data', 'A group of people talking about computers', 'A biological brain in a jar', 'B'),
                    $this->q('What is a feature in machine learning?', 'A special offer on a website', 'An individual measurable property or characteristic of a phenomenon being observed', 'A cool part of a robot\'s body', 'A bug in the code', 'B'),
                    $this->q('What is classification in ML?', 'Sorting books in a library', 'Identifying which of a set of categories a new observation belongs to', 'Making a computer move faster', 'Giving a grade to a student', 'B'),
                    $this->q('What is regression in ML?', 'Going backwards in time', 'A set of statistical processes for estimating the relationships among variables', 'Deleting old data', 'A type of computer error', 'B'),
                    $this->q('What is natural language processing?', 'Learning how to speak a new language naturally', 'The ability of a computer program to understand human language as it is spoken and written', 'A way to process food', 'Coding in a language that looks like English', 'B'),
                    $this->q('What is computer vision?', 'Having good eyesight while using a computer', 'A field of AI that enables computers to derive meaningful information from digital images and videos', 'Wearing special glasses to see the internet', 'The brightness setting of a monitor', 'B'),
                    $this->q('What is generative AI?', 'AI that can only perform one task', 'AI capable of generating text, images, or other media in response to prompts', 'A backup power generator for computers', 'A type of solar energy for robots', 'B'),
                    $this->q('Explain supervised learning.', 'Learning where the computer is watched by a teacher', 'Machine learning task of learning a function that maps an input to an output based on example input-output pairs', 'Learning from data that has no labels', 'A robot following a human around', 'B', 'intermediate'),
                    $this->q('Explain unsupervised learning.', 'Learning where the computer is left alone', 'A type of machine learning that looks for previously unknown patterns in a data set without pre-existing labels', 'Learning from a textbook', 'A computer that never learns anything', 'B', 'intermediate'),
                    $this->q('What is overfitting in machine learning?', 'Wearing a robot suit that is too small', 'When a model learns the training data too well, including the noise, and fails to generalize to new data', 'Having too much data for a small hard drive', 'A computer that is working too hard', 'B', 'intermediate'),
                    $this->q('What is an algorithm in AI?', 'A random guess by a computer', 'A set of rules or instructions for a computer to follow', 'A digital image', 'A type of computer screen', 'B'),
                    $this->q('What is data visualization?', 'Staring at raw data for hours', 'The representation of data through use of common graphics, such as charts or plots', 'Wearing VR glasses', 'Drawing pictures of computers', 'B'),
                    $this->q('What is image data?', 'Data represented by text only', 'Information represented by pixels in a grid', 'The way a computer looks', 'A physical photograph in a frame', 'B'),
                    $this->q('What is text data?', 'Data consisting of sequences of characters and words', 'A text message sent on a phone only', 'A type of programming hardware', 'A digital video file', 'A'),
                    $this->q('What is automation?', 'Doing everything by hand', 'The technology by which a process or procedure is performed with minimal human assistance', 'A type of automatic car', 'Buying a robot to do chores', 'B'),
                    $this->q('What is a chatbot?', 'A human talking to a computer', 'A computer program designed to simulate conversation with human users', 'A robot that can walk and talk', 'A type of microphone', 'B'),
                    $this->q('What is gradient descent?', 'Walking down a hill', 'An optimization algorithm used to minimize some function by iteratively moving in the direction of steepest descent', 'A way to change the color of a graph', 'A type of computer crash', 'B', 'intermediate'),
                    $this->q('What is a convolutional neural network (CNN)?', 'A network used for social media', 'A class of deep neural networks, most commonly applied to analyzing visual imagery', 'A complex web of wires', 'A type of internet connection', 'B', 'intermediate'),
                    $this->q('What is clustering in machine learning?', 'Putting many computers in one room', 'The task of grouping a set of objects in such a way that objects in the same group are more similar to each other', 'A group of people learning AI', 'An error where data gets stuck together', 'B', 'intermediate'),
                    $this->q('What is model evaluation in machine learning?', 'Judging a robot beauty contest', "The process of using different metrics to understand a machine learning model's performance", 'Fixing a broken model', "Deleting a model that doesn't work", 'B', 'intermediate'),
                ],
            ],
        ];
    }

    private function q(
        string $question,
        string $a,
        string $b,
        string $c,
        string $d,
        string $correct,
        string $level = 'beginner'
    ): array {
        return [
            'question' => $question,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'correct' => strtoupper($correct),
            'level' => $level,
        ];
    }
}
