# Database Seeders Documentation

This document describes all the database seeders created for the AI Learning Platform.

## Seeders Overview

### 1. **ComprehensiveCoursesSeeder** 
Main seeder covering all departments with complete course structures.

**Departments Covered:**
- **CSE (Computer Science & Engineering)** - 10 courses
  - PHP Web Development Masterclass
  - Python Programming from Basics to Pro
  - Web Development Foundations with HTML, CSS & JavaScript
  - JavaScript Advanced: ES6+ and Asynchronous Programming
  - Data Structures and Algorithms Complete Guide
  - Database Management with MySQL and Advanced SQL
  - React.js: Building Modern User Interfaces
  - System Design and Software Architecture
  - Object-Oriented Programming with Java
  - C Programming: Low-level Coding Essentials

- **ECE (Electronics & Communication Engineering)** - 10 courses
  - Digital Electronics and Logic Design
  - Circuit Analysis and Network Theory
  - Microcontrollers and Embedded Systems
  - Analog Electronics: From Basics to Advanced Circuits
  - Signal Processing Fundamentals
  - Communication Systems and Modulation Techniques
  - Power Electronics and Drive Systems
  - VLSI Design and Digital IC Development
  - Electromagnetic Fields and Waves
  - PCB Design and Circuit Implementation

- **AIML (Artificial Intelligence & Machine Learning)** - 10 courses
  - Machine Learning Fundamentals
  - Deep Learning and Neural Networks
  - Natural Language Processing (NLP)
  - Computer Vision and Image Processing
  - Reinforcement Learning and Agent Design
  - Data Science and Analytics with Python
  - Generative AI and Large Language Models
  - Feature Engineering and Model Optimization
  - MLOps and Model Deployment
  - AI Ethics and Responsible AI

- **MECH (Mechanical Engineering)** - 10 courses
  - Engineering Mechanics: Statics and Dynamics
  - Thermodynamics and Heat Transfer
  - Machine Design and Power Transmission
  - Fluid Mechanics and Flow Analysis
  - Manufacturing Processes and Materials
  - CAD Design and 3D Modeling with AutoCAD and SolidWorks
  - Finite Element Analysis and Simulation
  - Control Systems and Automation
  - Robotics and Automation Engineering
  - Industrial Engineering and Operations Research

- **AERO (Aeronautical Engineering)** - 10 courses
  - Aerodynamics Fundamentals
  - Aircraft Performance and Flight Mechanics
  - Jet Engines and Propulsion Systems
  - Aircraft Structures and Materials
  - Avionics and Flight Control Systems
  - Computational Fluid Dynamics (CFD) for Aerospace
  - Space Mission Design and Orbital Mechanics
  - Unmanned Aerial Vehicles (UAV) Design
  - Environmental and Noise Control for Aircraft
  - Advanced Aerospace Materials and Composites

**Each Course Includes:**
- 5 Modules
- 8 Lessons per module
- Real YouTube video links
- 5 difficulty levels (beginner to advanced)
- Multiple lesson types (reading, video, quiz, practical)
- Module-specific questions

---

### 2. **CSEDetailedCoursesSeeder**
Additional 4 specialized CSE courses with real-world applications.

**Courses Added:**
- DevOps and Cloud Computing (10 weeks, Advanced)
- Web Security and Ethical Hacking (9 weeks, Advanced)
- Advanced CSS and Web Design (7 weeks, Intermediate)
- Node.js and Backend Development (8 weeks, Intermediate)

---

### 3. **ECEDetailedCoursesSeeder**
Additional 4 advanced ECE courses with cutting-edge technologies.

**Courses Added:**
- FPGA Design and Implementation (10 weeks, Advanced)
- IoT Systems and Wireless Nodes (9 weeks, Advanced)
- Advanced Digital Signal Processing (10 weeks, Advanced)
- Renewable Energy Electronics (8 weeks, Intermediate)

---

### 4. **AIMLDetailedCoursesSeeder**
Additional 5 specialized AIML courses covering emerging technologies.

**Courses Added:**
- Computer Vision for Real-time Applications (10 weeks, Advanced)
- Conversational AI and Chatbots (8 weeks, Intermediate)
- Time Series Analysis and Forecasting (8 weeks, Intermediate)
- Anomaly Detection and Outlier Analysis (7 weeks, Advanced)
- Graph Neural Networks and Knowledge Graphs (9 weeks, Advanced)

---

### 5. **MECHDetailedCoursesSeeder**
Additional 5 advanced MECH courses for specialized applications.

**Courses Added:**
- Advanced Materials Science and Engineering (9 weeks, Advanced)
- HVAC Systems Design and Optimization (8 weeks, Intermediate)
- Vibration Analysis and Dynamics (9 weeks, Advanced)
- Six Sigma and Continuous Improvement (7 weeks, Intermediate)
- Product Design and Development (8 weeks, Intermediate)

---

### 6. **AERODetailedCoursesSeeder**
Additional 5 expert-level AERO courses for advanced applications.

**Courses Added:**
- Advanced Flight Dynamics and Control (10 weeks, Advanced)
- Hypersonic Aerodynamics and Flight (10 weeks, Advanced)
- Helicopter Aerodynamics and Dynamics (9 weeks, Advanced)
- Aircraft Systems Integration (9 weeks, Advanced)
- Supersonic and Transonic Flow (9 weeks, Advanced)

---

## Total Courses by Department

| Department | Comprehensive | Detailed | Total |
|------------|---------------|----------|-------|
| CSE        | 10            | 4        | **14**  |
| ECE        | 10            | 4        | **14**  |
| AIML       | 10            | 5        | **15**  |
| MECH       | 10            | 5        | **15**  |
| AERO       | 10            | 5        | **15**  |
| **TOTAL**  | **50**        | **23**   | **73**  |

---

## Key Features

### Real YouTube Videos
All courses include real YouTube video links from:
- MIT OpenCourseWare
- freeCodeCamp
- Coursera
- edX
- Official Educational Channels
- Tech Industry Leaders

### Module Structure
Each course has:
- **5 Modules** covering progression from basics to advanced
- **8 Lessons per Module** (40 lessons per course)
- **3-4 Question Variants** per module topic
- **Multiple Learning Methods**:
  - Reading materials
  - Video lectures
  - Interactive quizzes
  - Practical labs
  - Case studies
  - Simulations
  - Projects

### Difficulty Levels
- **Beginner**: Fundamentals and introductory concepts
- **Intermediate**: Applied knowledge and practical skills
- **Advanced**: Expert-level and specialized topics

### Assessment
Each module includes:
- Multiple-choice questions
- Topic-specific questions
- Difficulty levels 1-5
- Active question banks for testing

---

## How to Run the Seeders

### Run All Seeders
```bash
php artisan db:seed
```

### Run Specific Seeders
```bash
php artisan db:seed --class=ComprehensiveCoursesSeeder
php artisan db:seed --class=CSEDetailedCoursesSeeder
php artisan db:seed --class=ECEDetailedCoursesSeeder
php artisan db:seed --class=AIMLDetailedCoursesSeeder
php artisan db:seed --class=MECHDetailedCoursesSeeder
php artisan db:seed --class=AERODetailedCoursesSeeder
```

### Fresh Migration with Seeders
```bash
php artisan migrate:fresh --seed
```

---

## Database Tables Populated

1. **departments** - 5 departments
2. **courses** - 73 courses total
3. **modules** - 365 modules (73 courses × 5 modules)
4. **lessons** - 2,920 lessons (365 modules × 8 lessons)
5. **questions** - Multiple question variants per module
6. **users** - Super admin user

---

## Data Characteristics

### Video Links
- All videos are real educational content
- Topics match course and lesson content
- Sources are reputable educational platforms
- Duration: 7-40 weeks per course

### Content Quality
- Professional descriptions
- Clear learning objectives
- Progressive difficulty
- Real-world applications
- Industry-relevant projects

### Course Metadata
- Each course has an icon/emoji
- Color-coded by department
- Duration estimates
- Difficulty level indicators
- YouTube reference links

---

## Customization

To add more courses or modify existing ones:

1. Edit the respective seeder file
2. Add course data to the `$additionalCourses` array
3. Run the seeder: `php artisan db:seed --class=SeederName`

Example addition:
```php
[
    'title' => 'New Course Title',
    'description' => 'Detailed description',
    'difficulty' => 'beginner|intermediate|advanced',
    'icon' => '🎓',
    'duration' => '8 weeks',
    'youtube_link' => 'https://www.youtube.com/watch?v=VIDEO_ID',
],
```

---

## Notes

- All seeders use `updateOrCreate()` to prevent duplicates
- Safe to run multiple times
- Video links should be verified before production use
- Content can be modified post-seeding through admin panel
- Questions are auto-generated based on topics

---

## Support

For adding new courses or departments:
1. Create a new seeder file following the pattern
2. Add the department to `DatabaseSeeder.php`
3. Call the seeder in the `run()` method
4. Run migrations and seeders

---

Last Updated: April 27, 2026
