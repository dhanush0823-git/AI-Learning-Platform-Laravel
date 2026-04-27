<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Modules;
use App\Models\Question;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Database\Seeder;

class ComprehensiveCoursesSeeder extends Seeder
{
    use SeedsRichCourseContent;

    public function run(): void
    {
        $this->seedCSECourses();
        $this->seedECECourses();
        $this->seedAIMLCourses();
        $this->seedMECHCourses();
        $this->seedAEROCourses();
    }

    private function seedCSECourses(): void
    {
        $department = Departments::where('code', 'CSE')->first();
        if (!$department) return;

        $courses = [
            [
                'title' => 'PHP Web Development Masterclass',
                'description' => 'Learn PHP from fundamentals to practical web development with forms, sessions, MySQL integration, Laravel concepts, and deployment-ready project structure.',
                'difficulty' => 'beginner',
                'icon' => '🐘',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=OK_JCtrrv-c',
                'modules' => $this->getPhpModules(),
            ],
            [
                'title' => 'Python Programming from Basics to Pro',
                'description' => 'Master Python programming with hands-on projects including web development, data analysis, and automation. From syntax to frameworks like Django and Flask.',
                'difficulty' => 'beginner',
                'icon' => '🐍',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=_uQrJ0TkSuc',
                'modules' => $this->getPythonModules(),
            ],
            [
                'title' => 'Web Development Foundations with HTML, CSS & JavaScript',
                'description' => 'Build responsive websites from scratch. Learn HTML structure, CSS styling, JavaScript interactivity, and modern web development workflows.',
                'difficulty' => 'beginner',
                'icon' => '🌐',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=Kqon6p--RYc',
                'modules' => $this->getWebDevModules(),
            ],
            [
                'title' => 'JavaScript Advanced: ES6+ and Asynchronous Programming',
                'description' => 'Deep dive into modern JavaScript with ES6+, async/await, promises, callbacks, and async patterns for building scalable applications.',
                'difficulty' => 'intermediate',
                'icon' => '⚡',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=PoojliM2K3Q',
                'modules' => $this->getJavaScriptModules(),
            ],
            [
                'title' => 'Data Structures and Algorithms Complete Guide',
                'description' => 'Master essential data structures (arrays, linked lists, trees, graphs) and algorithms (sorting, searching, dynamic programming) for coding interviews.',
                'difficulty' => 'intermediate',
                'icon' => '📊',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=gYzrFDKwEh8',
                'modules' => $this->getDSAModules(),
            ],
            [
                'title' => 'Database Management with MySQL and Advanced SQL',
                'description' => 'Learn relational databases, SQL queries, normalization, indexing, optimization, transactions, and real-world database design patterns.',
                'difficulty' => 'intermediate',
                'icon' => '🗄️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=7S_tz1z_5bA',
                'modules' => $this->getDatabaseModules(),
            ],
            [
                'title' => 'React.js: Building Modern User Interfaces',
                'description' => 'Build interactive SPAs with React including hooks, state management, routing, and integration with REST APIs and Firebase.',
                'difficulty' => 'intermediate',
                'icon' => '⚛️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=SqcY0GlETPk',
                'modules' => $this->getReactModules(),
            ],
            [
                'title' => 'System Design and Software Architecture',
                'description' => 'Learn distributed systems, microservices, scalability patterns, load balancing, caching strategies, and real-world architecture decisions.',
                'difficulty' => 'advanced',
                'icon' => '🏗️',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=UzLMhqg3_Gw',
                'modules' => $this->getSystemDesignModules(),
            ],
            [
                'title' => 'Object-Oriented Programming with Java',
                'description' => 'Master OOP principles with Java including classes, inheritance, polymorphism, exceptions, collections, and enterprise patterns.',
                'difficulty' => 'intermediate',
                'icon' => '☕',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=aqvDZSeaJbI',
                'modules' => $this->getJavaModules(),
            ],
            [
                'title' => 'C Programming: Low-level Coding Essentials',
                'description' => 'Fundamentals of C programming including memory management, pointers, data structures, file I/O, and system-level programming.',
                'difficulty' => 'beginner',
                'icon' => '💻',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=KJgsSFOSQv0',
                'modules' => $this->getCProgrammingModules(),
            ],
        ];

        foreach ($courses as $courseData) {
            $modules = $this->buildModuleBlueprints(
                $courseData['title'],
                $courseData['description'],
                $courseData['modules']
            );
            unset($courseData['modules']);
            $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
                $courseData['title'],
                $courseData['youtube_link'] ?? null
            );

            $course = Course::updateOrCreate(
                ['title' => $courseData['title']],
                array_merge($courseData, ['department_id' => $department->id, 'total_modules' => 5])
            );

            foreach (range(1, 5) as $moduleNumber) {
                $moduleData = $modules[$moduleNumber] ?? null;
                $module = Modules::updateOrCreate(
                    ['course_id' => $course->id, 'module_number' => $moduleNumber],
                    [
                        'title' => $moduleData['title'] ?? "Module {$moduleNumber}: {$course->title}",
                        'description' => $moduleData['description'] ?? "Core content for module {$moduleNumber}",
                        'duration' => 120,
                    ]
                );

                $this->seedModuleLessons($course, $module, $moduleData['lessons'] ?? null);
                $this->seedModuleQuestions($department->id, $course, $module, $moduleData['topics'] ?? []);
            }
        }
    }

    private function seedECECourses(): void
    {
        $department = Departments::where('code', 'ECE')->first();
        if (!$department) return;

        $courses = [
            [
                'title' => 'Digital Electronics and Logic Design',
                'description' => 'Master digital electronics including logic gates, Boolean algebra, combinational and sequential circuits, and practical circuit design.',
                'difficulty' => 'beginner',
                'icon' => '⚡',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=lmZ8-IW5Dps',
                'modules' => $this->getDigitalElectronicsModules(),
            ],
            [
                'title' => 'Circuit Analysis and Network Theory',
                'description' => 'Learn circuit analysis, network theorems, AC/DC analysis, Laplace transforms, and frequency response characterization.',
                'difficulty' => 'intermediate',
                'icon' => '🔌',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=7x_p8d8bm48',
                'modules' => $this->getCircuitAnalysisModules(),
            ],
            [
                'title' => 'Microcontrollers and Embedded Systems',
                'description' => 'Program microcontrollers like Arduino and PIC, understand embedded system architecture, real-time systems, and IoT applications.',
                'difficulty' => 'intermediate',
                'icon' => '🤖',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=17EF0G4-JcY',
                'modules' => $this->getMicrocontrollerModules(),
            ],
            [
                'title' => 'Analog Electronics: From Basics to Advanced Circuits',
                'description' => 'Master analog electronics covering operational amplifiers, transistor circuits, amplifier design, and practical circuit implementation.',
                'difficulty' => 'intermediate',
                'icon' => '〰️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=EJ3CQkLd0io',
                'modules' => $this->getAnalogElectronicsModules(),
            ],
            [
                'title' => 'Signal Processing Fundamentals',
                'description' => 'Learn signal processing theory including Fourier analysis, filtering, DSP algorithms, and practical applications in communication systems.',
                'difficulty' => 'intermediate',
                'icon' => '📡',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=W4R3P6vNc1M',
                'modules' => $this->getSignalProcessingModules(),
            ],
            [
                'title' => 'Communication Systems and Modulation Techniques',
                'description' => 'Explore analog and digital communication, modulation schemes, channel coding, and modern wireless communication standards.',
                'difficulty' => 'advanced',
                'icon' => '📶',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=rQnLXfKqhKw',
                'modules' => $this->getCommunicationModules(),
            ],
            [
                'title' => 'Power Electronics and Drive Systems',
                'description' => 'Study power conversion, DC-DC converters, inverters, motor drives, and renewable energy systems for modern applications.',
                'difficulty' => 'intermediate',
                'icon' => '⚙️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=qYvz5F3zyak',
                'modules' => $this->getPowerElectronicsModules(),
            ],
            [
                'title' => 'VLSI Design and Digital IC Development',
                'description' => 'Learn VLSI design flow, HDL programming, synthesis, timing analysis, and physical design for integrated circuits.',
                'difficulty' => 'advanced',
                'icon' => '🔶',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=HYvz5F3zyak',
                'modules' => $this->getVLSIModules(),
            ],
            [
                'title' => 'Electromagnetic Fields and Waves',
                'description' => 'Master electromagnetic theory, Maxwell\'s equations, wave propagation, antenna theory, and practical electromagnetic applications.',
                'difficulty' => 'advanced',
                'icon' => '〰️🌊',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=6IiMCbfSUGw',
                'modules' => $this->getElectromagneticsModules(),
            ],
            [
                'title' => 'PCB Design and Circuit Implementation',
                'description' => 'Design and fabricate professional PCBs using CAD tools, learn layout principles, manufacturing processes, and quality assurance.',
                'difficulty' => 'intermediate',
                'icon' => '🟩',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=Ov0qH4C0OYE',
                'modules' => $this->getPCBDesignModules(),
            ],
        ];

        foreach ($courses as $courseData) {
            $modules = $this->buildModuleBlueprints(
                $courseData['title'],
                $courseData['description'],
                $courseData['modules']
            );
            unset($courseData['modules']);
            $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
                $courseData['title'],
                $courseData['youtube_link'] ?? null
            );

            $course = Course::updateOrCreate(
                ['title' => $courseData['title']],
                array_merge($courseData, ['department_id' => $department->id, 'total_modules' => 5])
            );

            foreach (range(1, 5) as $moduleNumber) {
                $moduleData = $modules[$moduleNumber] ?? null;
                $module = Modules::updateOrCreate(
                    ['course_id' => $course->id, 'module_number' => $moduleNumber],
                    [
                        'title' => $moduleData['title'] ?? "Module {$moduleNumber}: {$course->title}",
                        'description' => $moduleData['description'] ?? "Core content for module {$moduleNumber}",
                        'duration' => 120,
                    ]
                );

                $this->seedModuleLessons($course, $module, $moduleData['lessons'] ?? null);
                $this->seedModuleQuestions($department->id, $course, $module, $moduleData['topics'] ?? []);
            }
        }
    }

    private function seedAIMLCourses(): void
    {
        $department = Departments::where('code', 'AIML')->first();
        if (!$department) return;

        $courses = [
            [
                'title' => 'Machine Learning Fundamentals',
                'description' => 'Start your AI journey with core ML concepts, supervised and unsupervised learning, model evaluation, and practical scikit-learn implementation.',
                'difficulty' => 'beginner',
                'icon' => '🤖',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=jS4aFq5-91M',
                'modules' => $this->getMLFundamentalsModules(),
            ],
            [
                'title' => 'Deep Learning and Neural Networks',
                'description' => 'Master neural network architecture, backpropagation, CNNs, RNNs, transformers, and implementation with TensorFlow and PyTorch.',
                'difficulty' => 'intermediate',
                'icon' => '🧠',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=CS4cs2xVYuppY',
                'modules' => $this->getDeepLearningModules(),
            ],
            [
                'title' => 'Natural Language Processing (NLP)',
                'description' => 'Learn text processing, word embeddings, sequence models, transformers, and build practical NLP applications with state-of-the-art models.',
                'difficulty' => 'intermediate',
                'icon' => '📝',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=8rXD5-xkjFE',
                'modules' => $this->getNLPModules(),
            ],
            [
                'title' => 'Computer Vision and Image Processing',
                'description' => 'Master image processing techniques, CNN architectures, object detection, segmentation, and practical computer vision applications.',
                'difficulty' => 'intermediate',
                'icon' => '👁️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=IA3WxTeddLs',
                'modules' => $this->getComputerVisionModules(),
            ],
            [
                'title' => 'Reinforcement Learning and Agent Design',
                'description' => 'Understand RL fundamentals, Markov processes, Q-learning, policy gradient methods, and multi-agent systems for autonomous agents.',
                'difficulty' => 'advanced',
                'icon' => '🎮',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=nyjbcRQ-uQ8',
                'modules' => $this->getReinforcementLearningModules(),
            ],
            [
                'title' => 'Data Science and Analytics with Python',
                'description' => 'Learn data collection, cleaning, exploration, visualization, statistical analysis, and predictive modeling with pandas, NumPy, and matplotlib.',
                'difficulty' => 'beginner',
                'icon' => '📊',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=LHBE6QB23Ns',
                'modules' => $this->getDataScienceModules(),
            ],
            [
                'title' => 'Generative AI and Large Language Models',
                'description' => 'Explore transformers, attention mechanisms, fine-tuning LLMs, prompt engineering, and building applications with modern generative models.',
                'difficulty' => 'advanced',
                'icon' => '✨',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=9vM4p9NN0Ts',
                'modules' => $this->getGenerativeAIModules(),
            ],
            [
                'title' => 'Feature Engineering and Model Optimization',
                'description' => 'Master feature selection, extraction, hyperparameter tuning, ensemble methods, and advanced model optimization strategies.',
                'difficulty' => 'advanced',
                'icon' => '🔧',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=FRM46Y4bk3o',
                'modules' => $this->getFeatureEngineeringModules(),
            ],
            [
                'title' => 'MLOps and Model Deployment',
                'description' => 'Learn CI/CD for ML, model versioning, containerization, cloud deployment, monitoring, and maintaining production ML systems.',
                'difficulty' => 'advanced',
                'icon' => '🚀',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YZ58ibqVMvE',
                'modules' => $this->getMLOpsModules(),
            ],
            [
                'title' => 'AI Ethics and Responsible AI',
                'description' => 'Understand bias in ML, fairness, transparency, explainability, privacy-preserving techniques, and ethical considerations in AI systems.',
                'difficulty' => 'intermediate',
                'icon' => '⚖️',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=5UnnCvlSWRw',
                'modules' => $this->getAIEthicsModules(),
            ],
        ];

        foreach ($courses as $courseData) {
            $modules = $this->buildModuleBlueprints(
                $courseData['title'],
                $courseData['description'],
                $courseData['modules']
            );
            unset($courseData['modules']);
            $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
                $courseData['title'],
                $courseData['youtube_link'] ?? null
            );

            $course = Course::updateOrCreate(
                ['title' => $courseData['title']],
                array_merge($courseData, ['department_id' => $department->id, 'total_modules' => 5])
            );

            foreach (range(1, 5) as $moduleNumber) {
                $moduleData = $modules[$moduleNumber] ?? null;
                $module = Modules::updateOrCreate(
                    ['course_id' => $course->id, 'module_number' => $moduleNumber],
                    [
                        'title' => $moduleData['title'] ?? "Module {$moduleNumber}: {$course->title}",
                        'description' => $moduleData['description'] ?? "Core content for module {$moduleNumber}",
                        'duration' => 120,
                    ]
                );

                $this->seedModuleLessons($course, $module, $moduleData['lessons'] ?? null);
                $this->seedModuleQuestions($department->id, $course, $module, $moduleData['topics'] ?? []);
            }
        }
    }

    private function seedMECHCourses(): void
    {
        $department = Departments::where('code', 'MECH')->first();
        if (!$department) return;

        $courses = [
            [
                'title' => 'Engineering Mechanics: Statics and Dynamics',
                'description' => 'Master fundamental mechanics including forces, equilibrium, kinematics, kinetics, and energy methods for engineering design.',
                'difficulty' => 'beginner',
                'icon' => '⚙️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=yx75WK5K9qA',
                'modules' => $this->getMechanicsModules(),
            ],
            [
                'title' => 'Thermodynamics and Heat Transfer',
                'description' => 'Learn thermodynamic laws, energy conversion, engines, heat transfer mechanisms, and practical applications in thermal systems.',
                'difficulty' => 'intermediate',
                'icon' => '🔥',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=FFIP8tqxmBI',
                'modules' => $this->getThermodynamicsModules(),
            ],
            [
                'title' => 'Machine Design and Power Transmission',
                'description' => 'Design mechanical elements, bearings, gears, belts, chains, and understand power transmission systems for industrial machinery.',
                'difficulty' => 'intermediate',
                'icon' => '🔧',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=3Y4Y9f1Z6Hw',
                'modules' => $this->getMachineDesignModules(),
            ],
            [
                'title' => 'Fluid Mechanics and Flow Analysis',
                'description' => 'Study fluid statics, dynamics, pipe flow, pumps, turbines, and computational fluid dynamics for engineering applications.',
                'difficulty' => 'intermediate',
                'icon' => '💧',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=pDi7-qlrW_8',
                'modules' => $this->getFluidMechanicsModules(),
            ],
            [
                'title' => 'Manufacturing Processes and Materials',
                'description' => 'Learn material properties, casting, forming, machining, welding, and modern manufacturing technologies for production.',
                'difficulty' => 'intermediate',
                'icon' => '🏭',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=mfPVlhZT_j8',
                'modules' => $this->getManufacturingModules(),
            ],
            [
                'title' => 'CAD Design and 3D Modeling with AutoCAD and SolidWorks',
                'description' => 'Master 2D and 3D design tools, parametric modeling, assemblies, simulations, and engineering drawing standards.',
                'difficulty' => 'beginner',
                'icon' => '📐',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=GakLfWY6Dfs',
                'modules' => $this->getCADModules(),
            ],
            [
                'title' => 'Finite Element Analysis and Simulation',
                'description' => 'Learn FEA theory, preprocessing, solving, postprocessing, and practical stress analysis, thermal analysis, and optimization studies.',
                'difficulty' => 'advanced',
                'icon' => '🔬',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=hU6xPPLW4C0',
                'modules' => $this->getFEAModules(),
            ],
            [
                'title' => 'Control Systems and Automation',
                'description' => 'Master control theory, system modeling, feedback control, PLC programming, and industrial automation systems.',
                'difficulty' => 'advanced',
                'icon' => '🎛️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=TTXV9FS8nMU',
                'modules' => $this->getControlSystemsModules(),
            ],
            [
                'title' => 'Robotics and Automation Engineering',
                'description' => 'Learn robot kinematics, dynamics, control, vision systems, programming, and practical applications of industrial and collaborative robots.',
                'difficulty' => 'advanced',
                'icon' => '🤖',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=0gSH_wBNuGY',
                'modules' => $this->getRoboticsModules(),
            ],
            [
                'title' => 'Industrial Engineering and Operations Research',
                'description' => 'Master production planning, lean manufacturing, supply chain optimization, queuing theory, and decision-making models.',
                'difficulty' => 'intermediate',
                'icon' => '📈',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=R1Z4F4oE-9c',
                'modules' => $this->getIndustrialEngineeringModules(),
            ],
        ];

        foreach ($courses as $courseData) {
            $modules = $this->buildModuleBlueprints(
                $courseData['title'],
                $courseData['description'],
                $courseData['modules']
            );
            unset($courseData['modules']);
            $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
                $courseData['title'],
                $courseData['youtube_link'] ?? null
            );

            $course = Course::updateOrCreate(
                ['title' => $courseData['title']],
                array_merge($courseData, ['department_id' => $department->id, 'total_modules' => 5])
            );

            foreach (range(1, 5) as $moduleNumber) {
                $moduleData = $modules[$moduleNumber] ?? null;
                $module = Modules::updateOrCreate(
                    ['course_id' => $course->id, 'module_number' => $moduleNumber],
                    [
                        'title' => $moduleData['title'] ?? "Module {$moduleNumber}: {$course->title}",
                        'description' => $moduleData['description'] ?? "Core content for module {$moduleNumber}",
                        'duration' => 120,
                    ]
                );

                $this->seedModuleLessons($course, $module, $moduleData['lessons'] ?? null);
                $this->seedModuleQuestions($department->id, $course, $module, $moduleData['topics'] ?? []);
            }
        }
    }

    private function seedAEROCourses(): void
    {
        $department = Departments::where('code', 'AERO')->first();
        if (!$department) return;

        $courses = [
            [
                'title' => 'Aerodynamics Fundamentals',
                'description' => 'Master aerodynamic principles, airfoil theory, lift and drag, boundary layers, and flow visualization for aircraft design.',
                'difficulty' => 'beginner',
                'icon' => '✈️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=oR1oBVd2PgE',
                'modules' => $this->getAerodynamicsModules(),
            ],
            [
                'title' => 'Aircraft Performance and Flight Mechanics',
                'description' => 'Study aircraft equations of motion, stability, control, performance analysis, and flight envelope considerations.',
                'difficulty' => 'intermediate',
                'icon' => '🛩️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=xzA6bDXdxrE',
                'modules' => $this->getAircraftPerformanceModules(),
            ],
            [
                'title' => 'Jet Engines and Propulsion Systems',
                'description' => 'Learn thermodynamic cycles, gas turbine engines, turbofan engines, and modern propulsion technologies for aircraft.',
                'difficulty' => 'intermediate',
                'icon' => '🚀',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=WLUIcQrCMEA',
                'modules' => $this->getPropulsionModules(),
            ],
            [
                'title' => 'Aircraft Structures and Materials',
                'description' => 'Understand aircraft structural design, material selection, stress analysis, fatigue, damage tolerance, and manufacturing processes.',
                'difficulty' => 'intermediate',
                'icon' => '🏗️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=z-b2bqZqMZ8',
                'modules' => $this->getAircraftStructuresModules(),
            ],
            [
                'title' => 'Avionics and Flight Control Systems',
                'description' => 'Study avionics systems, autopilot design, fly-by-wire systems, navigation systems, and modern aircraft control electronics.',
                'difficulty' => 'intermediate',
                'icon' => '📡',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=qOjFMGDfJe8',
                'modules' => $this->getAvionicsModules(),
            ],
            [
                'title' => 'Computational Fluid Dynamics (CFD) for Aerospace',
                'description' => 'Master CFD theory, mesh generation, solver algorithms, turbulence modeling, and practical simulations for aircraft design.',
                'difficulty' => 'advanced',
                'icon' => '💻',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=FT1Ql1PXqVk',
                'modules' => $this->getAerospaceCFDModules(),
            ],
            [
                'title' => 'Space Mission Design and Orbital Mechanics',
                'description' => 'Learn orbital mechanics, mission planning, trajectory design, launch vehicles, and space system engineering for satellite missions.',
                'difficulty' => 'advanced',
                'icon' => '🛰️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=VnLHBt43Dno',
                'modules' => $this->getOrbitalMechanicsModules(),
            ],
            [
                'title' => 'Unmanned Aerial Vehicles (UAV) Design',
                'description' => 'Design and build UAVs including multi-rotor and fixed-wing platforms, control systems, communication, and autonomous flight.',
                'difficulty' => 'intermediate',
                'icon' => '🚁',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=7s-yqmpbODo',
                'modules' => $this->getUAVDesignModules(),
            ],
            [
                'title' => 'Environmental and Noise Control for Aircraft',
                'description' => 'Study aircraft emissions, noise abatement procedures, environmental impact, sustainability, and regulatory compliance.',
                'difficulty' => 'intermediate',
                'icon' => '🌍',
                'duration' => '6 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=qvZb0JAIgOA',
                'modules' => $this->getEnvironmentalModules(),
            ],
            [
                'title' => 'Advanced Aerospace Materials and Composites',
                'description' => 'Master advanced materials, composite manufacturing, mechanical properties, failure analysis, and material selection for aerospace.',
                'difficulty' => 'advanced',
                'icon' => '🔬',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=dJHV3yOmm3Q',
                'modules' => $this->getAdvancedMaterialsModules(),
            ],
        ];

        foreach ($courses as $courseData) {
            $modules = $this->buildModuleBlueprints(
                $courseData['title'],
                $courseData['description'],
                $courseData['modules']
            );
            unset($courseData['modules']);
            $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
                $courseData['title'],
                $courseData['youtube_link'] ?? null
            );

            $course = Course::updateOrCreate(
                ['title' => $courseData['title']],
                array_merge($courseData, ['department_id' => $department->id, 'total_modules' => 5])
            );

            foreach (range(1, 5) as $moduleNumber) {
                $moduleData = $modules[$moduleNumber] ?? null;
                $module = Modules::updateOrCreate(
                    ['course_id' => $course->id, 'module_number' => $moduleNumber],
                    [
                        'title' => $moduleData['title'] ?? "Module {$moduleNumber}: {$course->title}",
                        'description' => $moduleData['description'] ?? "Core content for module {$moduleNumber}",
                        'duration' => 120,
                    ]
                );

                $this->seedModuleLessons($course, $module, $moduleData['lessons'] ?? null);
                $this->seedModuleQuestions($department->id, $course, $module, $moduleData['topics'] ?? []);
            }
        }
    }

    // PHP Module Data
    private function getPhpModules(): array
    {
        return [
            1 => [
                'title' => 'Module 1: PHP Fundamentals and Environment Setup',
                'description' => 'Set up local PHP environment and master syntax, variables, operators, and control flow.',
                'topics' => ['PHP Basics', 'Syntax Rules', 'Variables', 'Data Types', 'Operators'],
                'lessons' => [
                    ['title' => 'Introduction to PHP and Server-Side Development', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Understanding what PHP is and why it powers web applications. Learn about server-side scripting and how PHP interacts with browsers.'],
                    ['title' => 'Installing XAMPP and Setting Up Environment', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=eL6T_yrmk-k', 'content' => 'Step-by-step setup of local development environment using XAMPP or LAMP stack.'],
                    ['title' => 'PHP Syntax and Basic Output', 'type' => 'reading', 'duration' => 14, 'video_url' => '', 'content' => 'Master PHP tags, echo, print statements, and basic HTML integration.'],
                    ['title' => 'Variables and Data Types in PHP', 'type' => 'video', 'duration' => 16, 'video_url' => 'https://www.youtube.com/watch?v=7TF00hJI78Y', 'content' => 'Understanding strings, integers, floats, booleans, arrays, and type casting.'],
                    ['title' => 'Operators and Expressions', 'type' => 'reading', 'duration' => 13, 'video_url' => '', 'content' => 'Arithmetic, assignment, comparison, logical, and bitwise operators.'],
                    ['title' => 'Control Flow: If, Else, Switch', 'type' => 'video', 'duration' => 17, 'video_url' => 'https://www.youtube.com/watch?v=9h4dLxFhYwM', 'content' => 'Conditional statements for decision-making in PHP applications.'],
                    ['title' => 'Loops: For, While, Foreach', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Iterating over data structures and repeating operations efficiently.'],
                    ['title' => 'Module 1 Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => '', 'content' => 'Test your understanding of PHP fundamentals.'],
                ],
            ],
            2 => [
                'title' => 'Module 2: Functions and Arrays',
                'description' => 'Create reusable functions and work with complex data structures like arrays.',
                'topics' => ['Functions', 'Arrays', 'Associative Arrays', 'Array Functions', 'Scope'],
                'lessons' => [
                    ['title' => 'Creating and Using Functions', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Function declaration, parameters, return values, and scope.'],
                    ['title' => 'Function Parameters and Return Values', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=Vx4dQ3S3QSE', 'content' => 'Passing arguments, return types, variable scope, and best practices.'],
                    ['title' => 'Working with Arrays', 'type' => 'reading', 'duration' => 16, 'video_url' => '', 'content' => 'Indexed arrays, associative arrays, multidimensional arrays, and array operations.'],
                    ['title' => 'Built-in Array Functions', 'type' => 'video', 'duration' => 14, 'video_url' => 'https://www.youtube.com/watch?v=q7x8Y6r2YJk', 'content' => 'Using array_map, array_filter, foreach loops, and array manipulation.'],
                    ['title' => 'String Functions and Manipulation', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'String concatenation, formatting, parsing, and manipulation methods.'],
                    ['title' => 'Variable Functions and Callbacks', 'type' => 'video', 'duration' => 16, 'video_url' => 'https://www.youtube.com/watch?v=O4rFMe5XcSE', 'content' => 'Function variables, callbacks, anonymous functions, and closures.'],
                    ['title' => 'Advanced Array Techniques', 'type' => 'reading', 'duration' => 14, 'video_url' => '', 'content' => 'Sorting arrays, searching, merging, and processing complex data structures.'],
                    ['title' => 'Module 2 Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => '', 'content' => 'Assess your knowledge of functions and arrays.'],
                ],
            ],
            3 => [
                'title' => 'Module 3: Forms, Sessions, and Security',
                'description' => 'Handle forms, maintain user sessions, and implement basic security practices.',
                'topics' => ['HTML Forms', 'Form Validation', 'Sessions', 'Cookies', 'Security'],
                'lessons' => [
                    ['title' => 'HTML Forms and GET/POST Methods', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Form structure, input types, and HTTP methods for data submission.'],
                    ['title' => 'Processing Form Data with Superglobals', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=O4rFMe5XcSE', 'content' => 'Using $_GET, $_POST, $_REQUEST, and $_FILES for form processing.'],
                    ['title' => 'Form Validation Best Practices', 'type' => 'reading', 'duration' => 16, 'video_url' => '', 'content' => 'Client-side and server-side validation, error handling, and user feedback.'],
                    ['title' => 'Working with Sessions', 'type' => 'video', 'duration' => 17, 'video_url' => 'https://www.youtube.com/watch?v=4Wc7JgB1z8M', 'content' => 'Session management, $_SESSION, session_start(), and user login systems.'],
                    ['title' => 'Cookies and Browser Storage', 'type' => 'reading', 'duration' => 14, 'video_url' => '', 'content' => 'Setting and retrieving cookies, cookie security, and browser storage options.'],
                    ['title' => 'Security Basics and Common Vulnerabilities', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=WY2oB8bJX9M', 'content' => 'XSS, SQL injection, CSRF, password hashing, and input sanitization.'],
                    ['title' => 'Escaping and Sanitizing Data', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'htmlspecialchars(), filter_var(), and preventing injection attacks.'],
                    ['title' => 'Module 3 Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => '', 'content' => 'Test your knowledge of forms, sessions, and security.'],
                ],
            ],
            4 => [
                'title' => 'Module 4: Database Integration and CRUD',
                'description' => 'Connect PHP to MySQL databases and perform CRUD operations safely.',
                'topics' => ['MySQL Basics', 'Connections', 'Prepared Statements', 'CRUD Operations', 'Queries'],
                'lessons' => [
                    ['title' => 'Introduction to Databases and SQL', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Database concepts, tables, relationships, and SQL fundamentals.'],
                    ['title' => 'Connecting PHP to MySQL', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=3B-Cnezwm7k', 'content' => 'Using mysqli_connect, PDO, and connection pooling for reliability.'],
                    ['title' => 'SELECT Queries and Retrieving Data', 'type' => 'reading', 'duration' => 16, 'video_url' => '', 'content' => 'Fetching results, iterating records, and handling result sets.'],
                    ['title' => 'INSERT, UPDATE, DELETE Operations', 'type' => 'video', 'duration' => 17, 'video_url' => 'https://www.youtube.com/watch?v=3isdcAEZoq0', 'content' => 'Modifying database records through PHP applications.'],
                    ['title' => 'Prepared Statements and SQL Injection Prevention', 'type' => 'reading', 'duration' => 16, 'video_url' => '', 'content' => 'Using parameterized queries to prevent SQL injection attacks.'],
                    ['title' => 'Transactions and Error Handling', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=nLinqtCfhKY', 'content' => 'ACID properties, rollback, commit, and robust error handling.'],
                    ['title' => 'Building a Simple CRUD Application', 'type' => 'reading', 'duration' => 17, 'video_url' => '', 'content' => 'Practical project combining all CRUD concepts into a working application.'],
                    ['title' => 'Module 4 Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => '', 'content' => 'Evaluate your database integration skills.'],
                ],
            ],
            5 => [
                'title' => 'Module 5: Laravel Framework and Modern Development',
                'description' => 'Master Laravel framework for building scalable web applications.',
                'topics' => ['Laravel Basics', 'Routing', 'Blade Templates', 'Models', 'Migrations'],
                'lessons' => [
                    ['title' => 'Why Use Frameworks and Laravel Intro', 'type' => 'reading', 'duration' => 14, 'video_url' => '', 'content' => 'Framework benefits, Laravel ecosystem, and modern PHP practices.'],
                    ['title' => 'Installing Laravel and Project Structure', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE', 'content' => 'using Composer, project directory structure, and configuration.'],
                    ['title' => 'Routing and HTTP Methods', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Defining routes, controllers, middleware, and request handling.'],
                    ['title' => 'Blade Templating Engine', 'type' => 'video', 'duration' => 16, 'video_url' => 'https://www.youtube.com/watch?v=9xwazD5SyVg', 'content' => 'Template syntax, loops, conditionals, and component reuse.'],
                    ['title' => 'Models and Database Migrations', 'type' => 'reading', 'duration' => 16, 'video_url' => '', 'content' => 'Eloquent ORM, migrations, relationships, and database seeding.'],
                    ['title' => 'Building a Complete CRUD Application', 'type' => 'video', 'duration' => 20, 'video_url' => 'https://www.youtube.com/watch?v=Y2bR7m4qg0E', 'content' => 'Create, read, update, delete operations using Laravel frameworks.'],
                    ['title' => 'Deployment and Production Best Practices', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Environment configuration, optimization, caching, and debugging.'],
                    ['title' => 'Final Assessment', 'type' => 'quiz', 'duration' => 10, 'video_url' => '', 'content' => 'Comprehensive evaluation of Laravel and PHP knowledge.'],
                ],
            ],
        ];
    }

    private function getPythonModules(): array
    {
        return [
            1 => [
                'title' => 'Module 1: Python Fundamentals',
                'description' => 'Learn Python basics, syntax, variables, and data types.',
                'topics' => ['Python Basics', 'Syntax', 'Variables', 'Data Types', 'Input/Output'],
                'lessons' => [
                    ['title' => 'Why Python and Setup', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'Introduction to Python, installation, and IDE setup.'],
                    ['title' => 'Your First Python Program', 'type' => 'video', 'duration' => 18, 'video_url' => 'https://www.youtube.com/watch?v=_uQrJ0TkSuc', 'content' => 'Writing and running basic Python scripts.'],
                    ['title' => 'Variables and Data Types', 'type' => 'reading', 'duration' => 16, 'video_url' => '', 'content' => 'Strings, integers, floats, booleans, and type conversion.'],
                    ['title' => 'Operations and Expressions', 'type' => 'video', 'duration' => 17, 'video_url' => '', 'content' => 'Arithmetic, comparison, and logical operations.'],
                    ['title' => 'Input and Output', 'type' => 'reading', 'duration' => 14, 'video_url' => '', 'content' => 'Using input(), print(), and f-strings for formatted output.'],
                    ['title' => 'Control Flow', 'type' => 'video', 'duration' => 18, 'video_url' => '', 'content' => 'If statements, loops, and decision-making.'],
                    ['title' => 'String Operations', 'type' => 'reading', 'duration' => 15, 'video_url' => '', 'content' => 'String manipulation, formatting, and methods.'],
                    ['title' => 'Module 1 Quiz', 'type' => 'quiz', 'duration' => 10, 'video_url' => '', 'content' => 'Test your Python fundamentals.'],
                ],
            ],
            2 => [
                'title' => 'Module 2: Lists, Dictionaries, and Data Structures',
                'description' => 'Master Python data structures and collections.',
                'topics' => ['Lists', 'Tuples', 'Dictionaries', 'Sets', 'Collections'],
                'lessons' => [],
            ],
            3 => [
                'title' => 'Module 3: Functions and Object-Oriented Programming',
                'description' => 'Create reusable functions and understand OOP principles.',
                'topics' => ['Functions', 'Classes', 'Objects', 'Inheritance', 'Polymorphism'],
                'lessons' => [],
            ],
            4 => [
                'title' => 'Module 4: File Handling and Exception Management',
                'description' => 'Work with files and handle errors gracefully.',
                'topics' => ['File I/O', 'Exception Handling', 'Context Managers', 'Logging', 'Debugging'],
                'lessons' => [],
            ],
            5 => [
                'title' => 'Module 5: Web Frameworks and Advanced Topics',
                'description' => 'Build web applications with Flask and Django.',
                'topics' => ['Flask Basics', 'Django Basics', 'REST APIs', 'Authentication', 'Deployment'],
                'lessons' => [],
            ],
        ];
    }

    private function getWebDevModules(): array
    {
        return [
            1 => [
                'title' => 'Module 1: HTML Fundamentals',
                'description' => 'Learn HTML structure and semantic markup.',
                'topics' => ['HTML Tags', 'Semantic HTML', 'Forms', 'Accessibility', 'Structure'],
                'lessons' => [],
            ],
            2 => [
                'title' => 'Module 2: CSS Styling and Layouts',
                'description' => 'Master CSS for beautiful designs and responsive layouts.',
                'topics' => ['CSS Basics', 'Flexbox', 'Grid', 'Responsive Design', 'Animations'],
                'lessons' => [],
            ],
            3 => [
                'title' => 'Module 3: JavaScript Interactivity',
                'description' => 'Add interactive features with JavaScript.',
                'topics' => ['JavaScript Basics', 'DOM Manipulation', 'Events', 'Callbacks', 'Promises'],
                'lessons' => [],
            ],
            4 => [
                'title' => 'Module 4: Building Projects',
                'description' => 'Combine HTML, CSS, and JavaScript to build real projects.',
                'topics' => ['Project Planning', 'Development Workflow', 'Git Basics', 'Browser DevTools', 'Testing'],
                'lessons' => [],
            ],
            5 => [
                'title' => 'Module 5: Deployment and Best Practices',
                'description' => 'Deploy websites and follow industry best practices.',
                'topics' => ['Hosting', 'Domains', 'Performance', 'SEO', 'Web Standards'],
                'lessons' => [],
            ],
        ];
    }

    private function getJavaScriptModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Advanced JS Concepts', 'description' => 'ES6+ features and modern JavaScript.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Asynchronous Programming', 'description' => 'Callbacks, promises, and async/await.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: DOM and BOM APIs', 'description' => 'Browser APIs and DOM manipulation.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Functional Programming', 'description' => 'Functional concepts and patterns in JavaScript.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Testing and Debugging', 'description' => 'Unit testing and debugging JavaScript.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getDSAModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Array and Linked List', 'description' => 'Fundamental data structures.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Stacks and Queues', 'description' => 'LIFO and FIFO data structures.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Trees and Graphs', 'description' => 'Hierarchical and networked data structures.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Sorting and Searching', 'description' => 'Key algorithms for data manipulation.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Advanced Algorithms', 'description' => 'Dynamic programming and optimization.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getDatabaseModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Database Design', 'description' => 'Relational modeling and normalization.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: SQL Basics', 'description' => 'Query language fundamentals.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Advanced Queries', 'description' => 'Joins, subqueries, and complex operations.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Optimization and Performance', 'description' => 'Indexing and query optimization.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Administration', 'description' => 'Database maintenance and security.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getReactModules(): array
    {
        return [
            1 => ['title' => 'Module 1: React Fundamentals', 'description' => 'Components, JSX, and props.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: State and Lifecycle', 'description' => 'State management and hooks.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Routing and Navigation', 'description' => 'React Router for SPAs.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: API Integration', 'description' => 'Fetching and managing external data.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Advanced Patterns', 'description' => 'Context, Redux, and performance optimization.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getSystemDesignModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Scalability Fundamentals', 'description' => 'Horizontal and vertical scaling.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Distributed Systems', 'description' => 'Consistency, availability, and partitioning.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Caching Strategies', 'description' => 'Redis, memcached, and cache patterns.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Microservices Architecture', 'description' => 'Service-oriented architecture and communication.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Real-world Case Studies', 'description' => 'Analyzing production systems.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getJavaModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Java Basics', 'description' => 'Syntax, types, and compilation.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: OOP Principles', 'description' => 'Classes, inheritance, and polymorphism.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Exception Handling', 'description' => 'Try-catch, custom exceptions, and best practices.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Collections Framework', 'description' => 'Lists, sets, maps, and iterators.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Concurrency', 'description' => 'Threads, synchronization, and concurrent utilities.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getCProgrammingModules(): array
    {
        return [
            1 => ['title' => 'Module 1: C Fundamentals', 'description' => 'Syntax, types, and basic operations.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Pointers and Memory', 'description' => 'Memory management and pointer arithmetic.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Arrays and Strings', 'description' => 'Working with collections and text.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Functions and Structures', 'description' => 'Modular code and custom types.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: File I/O and System Programming', 'description' => 'File operations and system calls.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getDigitalElectronicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Digital Fundamentals', 'description' => 'Number systems and logic gates.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Boolean Algebra', 'description' => 'Logic simplification and Karnaugh maps.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Combinational Circuits', 'description' => 'Multiplexers, decoders, and adders.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Sequential Circuits', 'description' => 'Flip-flops, counters, and state machines.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: HDL Implementation', 'description' => 'Verilog and VHDL for circuit design.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getCircuitAnalysisModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Circuit Laws and Theorems', 'description' => 'Ohm\'s law, Kirchhoff laws, and network theorems.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: AC Analysis', 'description' => 'Sinusoidal signals and phasor analysis.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Frequency Response', 'description' => 'Bode plots and resonance.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Transient Analysis', 'description' => 'Step response and differential equations.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Network Parameters', 'description' => 'Two-port networks and S-parameters.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getMicrocontrollerModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Microcontroller Basics', 'description' => 'Architecture and pin configuration.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Digital I/O and Sensors', 'description' => 'GPIO, interrupts, and sensor interfacing.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Communication Protocols', 'description' => 'UART, SPI, I2C, and CAN.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Timers and PWM', 'description' => 'Timer functions and pulse width modulation.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Real-time Systems', 'description' => 'Operating systems and embedded design.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAnalogElectronicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Transistor Basics', 'description' => 'BJT and FET characteristics.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Amplifier Design', 'description' => 'Small-signal analysis and gain.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Operational Amplifiers', 'description' => 'Op-amp circuits and applications.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Feedback Circuits', 'description' => 'Stability and frequency compensation.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Power Amplifiers', 'description' => 'Class A, B, and D amplifier design.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getSignalProcessingModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Signal Fundamentals', 'description' => 'Classification and basic operations.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Fourier Analysis', 'description' => 'DFT, FFT, and spectral analysis.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Filtering', 'description' => 'IIR and FIR filter design.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Sampling and Quantization', 'description' => 'Shannon theorem and A/D conversion.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: DSP Applications', 'description' => 'Audio and image processing.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getCommunicationModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Analog Communication', 'description' => 'AM, FM, and receiver design.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Digital Communication', 'description' => 'Modulation and detection techniques.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Channel Coding', 'description' => 'Error detection and correction codes.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Wireless Systems', 'description' => '5G, Wi Fi, and cellular standards.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Network Security', 'description' => 'Encryption and authentication protocols.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getPowerElectronicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Power Conversion Basics', 'description' => 'Rectifiers and inverters.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: DC-DC Converters', 'description' => 'Buck, boost, and buck-boost converters.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Motor Drives', 'description' => 'AC and DC motor control.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Renewable Energy Systems', 'description' => 'Solar and wind power conversion.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Control and Protection', 'description' => 'PWM control and over-current protection.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getVLSIModules(): array
    {
        return [
            1 => ['title' => 'Module 1: VLSI Design Flow', 'description' => 'Design methodology and tools.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: RTL Design and Synthesis', 'description' => 'VHDL/Verilog and logic synthesis.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Physical Design', 'description' => 'Place and route, timing closure.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Verification', 'description' => 'Simulation, formal verification.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: IC Testing', 'description' => 'Fault models and test generation.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getElectromagneticsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Static Fields', 'description' => 'Electrostatics and magnetostatics.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Maxwell\'s Equations', 'description' => 'Electromagnetic wave theory.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Propagation', 'description' => 'Plane waves and reflection/transmission.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Antenna Theory', 'description' => 'Radiation and antenna arrays.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Applications', 'description' => 'Transmission lines and waveguides.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getPCBDesignModules(): array
    {
        return [
            1 => ['title' => 'Module 1: PCB Basics', 'description' => 'Materials and layer stackup.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Schematic Capture', 'description' => 'Using EDA tools like KiCAD.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Layout Design', 'description' => 'Routing and placement strategies.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Manufacturing', 'description' => 'Fabrication and assembly processes.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Quality Control', 'description' => 'Testing and reliability assurance.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getMLFundamentalsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: ML Concepts', 'description' => 'Supervised vs unsupervised learning.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Regression', 'description' => 'Linear and polynomial regression.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Classification', 'description' => 'Decision trees and naive Bayes.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Clustering', 'description' => 'K-means and hierarchical clustering.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Evaluation', 'description' => 'Cross-validation and metrics.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getDeepLearningModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Neural Networks', 'description' => 'Perceptrons and MLPs.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: CNNs', 'description' => 'Convolutional neural networks.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: RNNs', 'description' => 'Recurrent neural networks and LSTMs.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Transformers', 'description' => 'Attention mechanisms and BERT.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Training', 'description' => 'Optimization and regularization.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getNLPModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Text Processing', 'description' => 'Tokenization and normalization.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Embeddings', 'description' => 'Word2Vec and GloVe.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Language Models', 'description' => 'RNNs and transformers for NLP.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Applications', 'description' => 'NER, sentiment analysis, and machine translation.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: LLMs', 'description' => 'Working with ChatGPT and BERT.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getComputerVisionModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Image Basics', 'description' => 'Pixels, filtering, and convolution.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Feature Detection', 'description' => 'Edges, corners, and descriptors.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Object Detection', 'description' => 'YOLO, R-CNN, and SSD.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Segmentation', 'description' => 'Semantic and instance segmentation.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Pose and Tracking', 'description' => 'Keypoint detection and object tracking.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getReinforcementLearningModules(): array
    {
        return [
            1 => ['title' => 'Module 1: RL Fundamentals', 'description' => 'Markov processes and value iteration.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Q-Learning', 'description' => 'Tabular and function approximation.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Policy Gradient', 'description' => 'Actor-critic and PPO.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Game Playing', 'description' => 'Alpha-Zero and game theory.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Applications', 'description' => 'Robotics and autonomous systems.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getDataScienceModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Data Fundamentals', 'description' => 'Collection and cleaning.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Exploration', 'description' => 'EDA and visualization.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Statistical Analysis', 'description' => 'Inference and testing.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Modeling', 'description' => 'Prediction and evaluation.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Communication', 'description' => 'Dashboards and reporting.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getGenerativeAIModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Transformer Architecture', 'description' => 'Attention and self-attention.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Model Training', 'description' => 'Pre-training and fine-tuning.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Prompt Engineering', 'description' => 'Effective prompting strategies.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Multimodal Models', 'description' => 'Vision-language models.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Deployment', 'description' => 'API integration and scaling.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getFeatureEngineeringModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Feature Selection', 'description' => 'Correlation and importance.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Feature Extraction', 'description' => 'Dimensionality reduction.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Encoding', 'description' => 'Categorical and text encoding.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Hyperparameter Tuning', 'description' => 'Grid search and Bayesian optimization.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Ensemble Methods', 'description' => 'Bagging, boosting, and stacking.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getMLOpsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: ML Pipelines', 'description' => 'Workflow automation.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Containerization', 'description' => 'Docker and Kubernetes.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Monitoring', 'description' => 'Model drift and performance.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Version Control', 'description' => 'Model versioning and reproducibility.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Cloud Deployment', 'description' => 'AWS, Azure, and GCP.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAIEthicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Bias and Fairness', 'description' => 'Identifying and mitigating bias.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Transparency', 'description' => 'Explainability and interpretability.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Privacy', 'description' => 'Privacy-preserving ML techniques.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Responsibility', 'description' => 'Ethical considerations and governance.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Regulations', 'description' => 'GDPR and AI governance frameworks.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getMechanicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Fundamentals', 'description' => 'Vectors and force analysis.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Statics', 'description' => 'Equilibrium and reactions.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Dynamics', 'description' => 'Kinematics and kinetics.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Work and Energy', 'description' => 'Conservation of energy.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Vibrations', 'description' => 'Simple harmonic motion.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getThermodynamicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Basics', 'description' => 'First and second laws.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Cycles', 'description' => 'Carnot, Otto, and Diesel cycles.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Combustion', 'description' => 'Stoichiometry and reactions.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Heat Transfer', 'description' => 'Conduction, convection, radiation.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Application', 'description' => 'Heat exchangers and engines.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getMachineDesignModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Design Basics', 'description' => 'Failure analysis and factors of safety.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Shafts', 'description' => 'Shaft design and stress concentration.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Bearings', 'description' => 'Selection and life calculation.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Gears', 'description' => 'Gear types and design.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Transmission', 'description' => 'Belts, chains, and couplings.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getFluidMechanicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Fundamentals', 'description' => 'Properties and statics.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Kinematics', 'description' => 'Continuity and Bernoulli equations.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Dynamics', 'description' => 'Momentum and energy equations.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Pipe Flow', 'description' => 'Friction and losses.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Turbomachinery', 'description' => 'Pumps and turbines.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getManufacturingModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Casting', 'description' => 'Foundry processes and defects.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Forming', 'description' => 'Forging, rolling, and drawing.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Machining', 'description' => 'Cutting, drilling, and boring.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Joining', 'description' => 'Welding, brazing, and adhesive bonding.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Finishing', 'description' => 'Surface treatment and coatings.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getCADModules(): array
    {
        return [
            1 => ['title' => 'Module 1: CAD Basics', 'description' => 'Interface and tools.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: 2D Drafting', 'description' => 'Drawing and dimensioning.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: 3D Modeling', 'description' => 'Part design and assemblies.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Simulation', 'description' => 'Stress and thermal analysis.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Documentation', 'description' => 'Drawing generation and export.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getFEAModules(): array
    {
        return [
            1 => ['title' => 'Module 1: FEA Concepts', 'description' => 'Element types and meshing.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Static Analysis', 'description' => 'Linear and nonlinear.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Dynamic Analysis', 'description' => 'Modal and transient analysis.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Thermal Analysis', 'description' => 'Heat transfer and thermal stress.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Optimization', 'description' => 'Design optimization and sensitivity.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getControlSystemsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Basics', 'description' => 'Open and closed loop systems.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Analysis', 'description' => 'Bode plots and root locus.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Design', 'description' => 'Controller design and tuning.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Implementation', 'description' => 'Microcontrollers and PLC programming.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Applications', 'description' => 'Industrial control systems.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getRoboticsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Kinematics', 'description' => 'Forward and inverse kinematics.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Dynamics', 'description' => 'Robot dynamics and control.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Path Planning', 'description' => 'Trajectory and motion planning.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Vision', 'description' => 'Robot vision and perception.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Programming', 'description' => 'ROS and robot programming.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getIndustrialEngineeringModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Production Planning', 'description' => 'Forecasting and scheduling.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Lean Manufacturing', 'description' => 'Waste elimination and kaizen.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Supply Chain', 'description' => 'SCM and logistics.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Quality', 'description' => 'SQC and six sigma.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Operations', 'description' => 'OR and optimization.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAerodynamicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Fundamentals', 'description' => 'Airflow and atmosphere.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Subsonic Flow', 'description' => 'Incompressible flow basics.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Airfoil Theory', 'description' => 'Lift and drag characteristics.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Wing Design', 'description' => 'Induced drag and efficiency.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Compressibility', 'description' => 'High-speed aerodynamics.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAircraftPerformanceModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Stability', 'description' => 'Static and dynamic stability.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Control', 'description' => 'Control surfaces and authority.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Performance', 'description' => 'Takeoff and landing performance.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Weight and Balance', 'description' => 'CG and loading.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Flight Planning', 'description' => 'Range and endurance.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getPropulsionModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Basics', 'description' => 'Thrust and power.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Gas Turbines', 'description' => 'Turbine engine cycles.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Compressors', 'description' => 'Compressor design and performance.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Combustors', 'description' => 'Combustion and fuel systems.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Turbines', 'description' => 'Turbine design and analysis.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAircraftStructuresModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Structural Concepts', 'description' => 'Fuselage and wing structures.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Materials', 'description' => 'Aluminum alloys and composites.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Analysis', 'description' => 'Stress and strain analysis.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Fatigue', 'description' => 'Fatigue and crack growth.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Repair', 'description' => 'Maintenance and damage tolerance.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAvionicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Navigation', 'description' => 'INS, GPS, and NDB.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Communication', 'description' => 'Radio systems and transponders.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Displays', 'description' => 'Glass cockpit systems.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Autopilot', 'description' => 'Flight control systems.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Integration', 'description' => 'Avionics integration and certification.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAerospaceCFDModules(): array
    {
        return [
            1 => ['title' => 'Module 1: CFD Basics', 'description' => 'Governing equations and solvers.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Meshing', 'description' => 'Grid generation and adaptation.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Turbulence', 'description' => 'RANS and LES modeling.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Applications', 'description' => 'Aerodynamic analysis and design.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Validation', 'description' => 'Verification and validation.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getOrbitalMechanicsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Orbital Elements', 'description' => 'Kepler elements and orbits.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Trajectories', 'description' => 'Hohmann and Lambert transfers.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Mission Design', 'description' => 'Launch windows and rendezvous.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Perturbations', 'description' => 'Orbital perturbations and maneuvers.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Operations', 'description' => 'Station keeping and deorbit.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getUAVDesignModules(): array
    {
        return [
            1 => ['title' => 'Module 1: UAV Types', 'description' => 'Multi-rotor and fixed-wing.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Aerodynamics', 'description' => 'Design for efficiency.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Propulsion', 'description' => 'Motors and batteries.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Control', 'description' => 'Flight controller tuning.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Autonomy', 'description' => 'Autonomous flight and mission planning.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getEnvironmentalModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Emissions', 'description' => 'Aircraft emissions and analysis.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Noise', 'description' => 'Noise generation and abatement.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Regulations', 'description' => 'EASA and FAA standards.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Sustainability', 'description' => 'Sustainable aviation fuels.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Climate', 'description' => 'Climate impact assessment.', 'topics' => [], 'lessons' => []],
        ];
    }

    private function getAdvancedMaterialsModules(): array
    {
        return [
            1 => ['title' => 'Module 1: Material Properties', 'description' => 'Mechanical and thermal properties.', 'topics' => [], 'lessons' => []],
            2 => ['title' => 'Module 2: Composites', 'description' => 'Fiber-reinforced materials.', 'topics' => [], 'lessons' => []],
            3 => ['title' => 'Module 3: Manufacturing', 'description' => 'Composite processing and layup.', 'topics' => [], 'lessons' => []],
            4 => ['title' => 'Module 4: Analysis', 'description' => 'Composite mechanics and failure.', 'topics' => [], 'lessons' => []],
            5 => ['title' => 'Module 5: Advanced Materials', 'description' => 'Ceramics, MMCs, and BMCs.', 'topics' => [], 'lessons' => []],
        ];
    }

    protected function seedModuleLessons(Course $course, Modules $module, ?array $customLessons = null): void
    {
        $topics = $this->normalizeTopics([], $course->title, $module->title, $module->description, $module->module_number);

        $this->syncModuleLessons(
            $module,
            $course->title,
            $module->title,
            $module->description,
            $topics,
            $customLessons ?? [],
            14
        );
    }

    protected function seedModuleQuestions(int $departmentId, Course $course, Modules $module, array $topics): void
    {
        $topics = $this->normalizeTopics($topics, $course->title, $module->title, $module->description, $module->module_number);

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
        if (empty($topics)) return [];

        $topics = array_values($topics);
        $questions = [];
        $variantLabels = ['Core Concept', 'Practice Question', 'Quick Check', 'Application', 'Mastery'];

        foreach ($variantLabels as $variantIndex => $variantLabel) {
            foreach ($topics as $topicIndex => $topic) {
                $questionNumber = ($variantIndex * count($topics)) + $topicIndex + 1;
                $difficulty = min(5, max(1, 1 + $topicIndex + $variantIndex));

                $questions[] = [
                    'topic' => $topic,
                    'difficulty_level' => $difficulty,
                    'question_text' => "{$variantLabel} - Which concept best relates to {$topic}?",
                    'options' => [
                        "{$topic} is a fundamental concept in this module",
                        "{$topic} is only theoretical with no practical application",
                        "{$topic} is outdated in modern practice",
                        "{$topic} is unrelated to the course content",
                    ],
                    'correct_option' => "{$topic} is a fundamental concept in this module",
                ];
            }
        }

        return $questions;
    }
}
